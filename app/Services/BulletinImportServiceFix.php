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

    public function processZip(UploadedFile $zip, int $entrepriseId, int $uploadedBy, bool $notifier = true): array
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
                $this->traiterPdf($pdfPath, $entrepriseId, $uploadedBy, $salaires, $notifier);
            }
        } finally {
            $this->supprimerRepertoire($tmpDir);
        }

        return $this->result;
    }

    private function traiterPdf(string $pdfPath, int $entrepriseId, int $uploadedBy, array $salaires, bool $notifier): void
    {
        $basename = basename($pdfPath);
        $parsed = $this->parseFilename($basename);

        if (!$parsed) {
            $this->result['erreurs'][] = ['fichier' => $basename, 'raison' => 'Format de nom invalide.'];
            return;
        }

        $personnel = $this->matchPersonnel($parsed['police'], $parsed['nom'], $entrepriseId);
        if (!$personnel) {
            $this->result['erreurs'][] = ['fichier' => $basename, 'raison' => "Police «{$parsed['police']}» introuvable dans cette entreprise."];
            return;
        }

        // Vérifier doublon (withTrashed pour attraper les enregistrements soft-deleted)
        if (BulletinPaie::withTrashed()->where('personnel_id', $personnel->id)->where('mois', $parsed['mois'])->where('annee', $parsed['annee'])->exists()) {
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

    public function matchPersonnel(string $police, string $nom, int $entrepriseId): ?Personnel
    {
        // 1. Par police
        try {
            $p = Personnel::where('police', $police)->where('entreprise_id', $entrepriseId)->first();
            if ($p) return $p;
        } catch (\Exception $e) {}

        // 2. Par matricule
        try {
            $p = Personnel::where('matricule', $police)->where('entreprise_id', $entrepriseId)->first();
            if ($p) return $p;
        } catch (\Exception $e) {}

        // 3. Par nom approché
        $parts = array_filter(explode(' ', trim($nom)), fn($p) => strlen($p) >= 3);
        if (empty($parts)) return null;

        return Personnel::where('entreprise_id', $entrepriseId)
            ->where(function ($q) use ($parts) {
                foreach ($parts as $part) {
                    $q->where(function ($qq) use ($part) {
                        $qq->where('nom', 'like', "%{$part}%")->orWhere('prenoms', 'like', "%{$part}%");
                    });
                }
            })->first();
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
