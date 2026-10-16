<?php

namespace App\Services;

use App\Models\BulletinPaie;
use App\Models\BulletinImport;
use App\Models\Personnel;
use App\Notifications\BulletinPaieNotification;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use ZipArchive;

class BulletinImportServiceFix
{
    private array $result = [
        'total' => 0, 'succes' => 0, 'doublons' => 0, 'erreurs' => [], 'bulletins_ids' => [],
    ];

    /**
     * @param array<string,int|string> $overrides Correspondance manuelle décidée en prévisualisation :
     *   nom de fichier => id personnel (affectation manuelle) ou "skip" (fichier à ignorer).
     *   Prioritaire sur le repérage automatique par police/matricule.
     */
    public function processZip(UploadedFile $zip, int $entrepriseId, int $uploadedBy, bool $notifier = true, array $overrides = []): array
    {
        $this->result = ['total' => 0, 'succes' => 0, 'doublons' => 0, 'erreurs' => [], 'bulletins_ids' => []];

        $tmpDir = sys_get_temp_dir() . '/bulletin_import_' . uniqid();
        @mkdir($tmpDir, 0755, true);

        try {
            $archive = new ZipArchive();
            if ($archive->open($zip->getRealPath()) !== true) {
                throw new \RuntimeException("Impossible d'ouvrir l'archive ZIP.");
            }
            $archive->extractTo($tmpDir);
            $archive->close();

            $salaires = $this->lireSalairesCsv($tmpDir);
            $pdfs = $this->listerPdfs($tmpDir);
            $this->result['total'] = count($pdfs);

            foreach ($pdfs as $pdfPath) {
                $this->traiterPdf($pdfPath, $entrepriseId, $uploadedBy, $salaires, $notifier, $overrides);
            }
        } finally {
            $this->supprimerRepertoire($tmpDir);
        }

        return $this->result;
    }

    private function traiterPdf(string $pdfPath, int $entrepriseId, int $uploadedBy, array $salaires, bool $notifier, array $overrides = []): void
    {
        $basename = basename($pdfPath);
        $parsed = $this->parseFilename($basename);

        if (!$parsed) {
            $this->result['erreurs'][] = ['fichier' => $basename, 'raison' => 'Format de nom invalide.'];
            return;
        }

        $override = $overrides[$basename] ?? null;
        if ($override === 'skip') {
            return;
        }

        $personnel = $override
            ? Personnel::where('id', $override)->where('entreprise_id', $entrepriseId)->first()
            : $this->matchPersonnel($parsed['police'], $parsed['nom'], $entrepriseId);

        if (!$personnel) {
            $this->result['erreurs'][] = ['fichier' => $basename, 'raison' => "Police «{$parsed['police']}» introuvable — aucune affectation manuelle fournie."];
            return;
        }

        // Vérifier doublon (sans withTrashed : un bulletin soft-deleted permet un ré-import)
        if (BulletinPaie::where('personnel_id', $personnel->id)->where('mois', $parsed['mois'])->where('annee', $parsed['annee'])->exists()) {
            $this->result['doublons']++;
            return;
        }

        $matricule   = $personnel->matricule ?? 'emp';
        $salaireBrut = $salaires[$matricule]['brut'] ?? null;
        $salaireNet  = $salaires[$matricule]['net']  ?? null;

        $storagePath = 'bulletins/' . $entrepriseId . '/' . $parsed['annee'] . '/' . str_pad($parsed['mois'], 2, '0', STR_PAD_LEFT);
        $filename    = Str::slug($matricule) . '_' . $parsed['annee'] . '_' . str_pad($parsed['mois'], 2, '0', STR_PAD_LEFT) . '.pdf';
        $destination = $storagePath . '/' . $filename;

        if (!Storage::disk('public')->put($destination, file_get_contents($pdfPath))) {
            $this->result['erreurs'][] = ['fichier' => $basename, 'raison' => 'Erreur copie fichier.'];
            return;
        }

        try {
            DB::beginTransaction();
            $bulletin = BulletinPaie::create([
                'personnel_id'         => $personnel->id,
                'entreprise_id'        => $entrepriseId,
                'uploaded_by'          => $uploadedBy,
                'mois'                 => $parsed['mois'],
                'annee'                => $parsed['annee'],
                'fichier_path'         => $destination,
                'fichier_nom_original' => $basename,
                'fichier_type'         => 'application/pdf',
                'fichier_taille'       => filesize($pdfPath),
                'salaire_brut'         => $salaireBrut,
                'salaire_net'          => $salaireNet,
                'reference'            => 'BP-' . $entrepriseId . '-' . $personnel->id . '-' . $parsed['annee'] . str_pad($parsed['mois'], 2, '0', STR_PAD_LEFT),
                'statut'               => 'publie',
                'visible_employe'      => true,
                'notifier_employe'     => $notifier,
            ]);
            DB::commit();

            $this->result['succes']++;
            $this->result['bulletins_ids'][] = $bulletin->id;

            if ($notifier && $personnel->user) {
                try { $personnel->user->notify(new BulletinPaieNotification($bulletin)); } catch (\Exception $e) {}
            }
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();
            Storage::disk('public')->delete($destination);
            // Contrainte unique = doublon
            if ($e->errorInfo[1] === 1062) {
                $this->result['doublons']++;
            } else {
                $this->result['erreurs'][] = ['fichier' => $basename, 'raison' => 'DB: ' . $e->getMessage()];
                Log::error('BulletinImportServiceFix', ['fichier' => $basename, 'error' => $e->getMessage()]);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            Storage::disk('public')->delete($destination);
            $this->result['erreurs'][] = ['fichier' => $basename, 'raison' => $e->getMessage()];
        }
    }

    public function parseFilename(string $filename): ?array
    {
        $base = pathinfo($filename, PATHINFO_FILENAME);
        if (!preg_match('/^Bulletin_(.+)_(\d{4}-\d{2}-\d{2})_au_(\d{4}-\d{2}-\d{2})$/i', $base, $m)) {
            return null;
        }
        $parts  = explode('_', $m[1], 2);
        $police = $parts[0];
        $nom    = isset($parts[1]) ? str_replace('_', ' ', $parts[1]) : '';
        $annee  = (int) substr($m[2], 0, 4);
        $mois   = (int) substr($m[2], 5, 2);
        if ($annee < 2000 || $annee > 2100 || $mois < 1 || $mois > 12) return null;
        return ['police' => $police, 'nom' => $nom, 'annee' => $annee, 'mois' => $mois, 'date_debut' => $m[2], 'date_fin' => $m[3]];
    }

    /**
     * Recherche exacte uniquement (police puis matricule). Un nom ne suffit jamais à lui
     * seul à identifier un employé ici — trop de risque d'associer le bulletin de paie à
     * la mauvaise personne sur un nom approché. Quand ni la police ni le matricule ne
     * correspondent, l'appelant doit passer par une affectation manuelle (voir $overrides
     * dans processZip) plutôt que de deviner.
     */
    public function matchPersonnel(string $police, string $nom, int $entrepriseId): ?Personnel
    {
        try {
            $p = Personnel::where('police', $police)->where('entreprise_id', $entrepriseId)->first();
            if ($p) return $p;
        } catch (\Exception $e) {}

        try {
            $p = Personnel::where('matricule', $police)->where('entreprise_id', $entrepriseId)->first();
            if ($p) return $p;
        } catch (\Exception $e) {}

        return null;
    }

    private function lireSalairesCsv(string $dir): array
    {
        $path = $dir . '/salaires.csv';
        if (!file_exists($path)) return [];
        $salaires = [];
        $h = fopen($path, 'r');
        if (!$h) return [];
        fgetcsv($h);
        while (($row = fgetcsv($h)) !== false) {
            if (count($row) >= 3) {
                $salaires[trim($row[0])] = ['brut' => (float) str_replace(',', '.', $row[1]), 'net' => (float) str_replace(',', '.', $row[2])];
            }
        }
        fclose($h);
        return $salaires;
    }

    private function listerPdfs(string $dir): array
    {
        $pdfs = [];
        foreach (new \DirectoryIterator($dir) as $f) {
            if (!$f->isDot() && !$f->isDir() && strtolower($f->getExtension()) === 'pdf') {
                $pdfs[] = $f->getRealPath();
            }
        }
        return $pdfs;
    }

    private function supprimerRepertoire(string $dir): void
    {
        if (!is_dir($dir)) return;
        $it = new \RecursiveDirectoryIterator($dir, \FilesystemIterator::SKIP_DOTS);
        $ri = new \RecursiveIteratorIterator($it, \RecursiveIteratorIterator::CHILD_FIRST);
        foreach ($ri as $f) { $f->isDir() ? rmdir($f->getRealPath()) : unlink($f->getRealPath()); }
        rmdir($dir);
    }
}
