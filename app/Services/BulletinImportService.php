<?php

namespace App\Services;

use App\Models\BulletinPaie;
use App\Models\Personnel;
use App\Notifications\BulletinPaieNotification;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use ZipArchive;

/**
 * Service d'import automatique des bulletins de paie
 *
 * Convention de nommage des PDFs dans le ZIP :
 *   Bulletin_{Matricule}_{NomPrenom}_{YYYY-MM-DD}_au_{YYYY-MM-DD}.pdf
 *
 * Exemples :
 *   Bulletin_EMP001_Jean_Dupont_2024-01-01_au_2024-01-31.pdf
 *   Bulletin_SANS_MATRICULE_Pierre_Bernard_2024-03-01_au_2024-03-31.pdf
 *
 * CSV optionnel (salaires.csv dans le ZIP) :
 *   matricule,salaire_brut,salaire_net
 *   EMP001,500000,450000
 */
class BulletinImportService
{
    /**
     * Résultat d'un import
     */
    private array $result = [
        'total'         => 0,
        'succes'        => 0,
        'doublons'      => 0,
        'erreurs'       => [],
        'bulletins_ids' => [],
    ];

    /**
     * Point d'entrée principal : traiter un ZIP uploadé
     */
    public function processZip(
        UploadedFile $zip,
        int $entrepriseId,
        int $uploadedBy,
        bool $notifier = true
    ): array {
        $this->result = ['total' => 0, 'succes' => 0, 'doublons' => 0, 'erreurs' => [], 'bulletins_ids' => []];

        // Extraire le ZIP dans un répertoire temporaire
        $tmpDir = sys_get_temp_dir() . '/bulletin_import_' . uniqid();
        @mkdir($tmpDir, 0755, true);

        try {
            $archive = new ZipArchive();
            $opened  = $archive->open($zip->getRealPath());

            if ($opened !== true) {
                throw new \RuntimeException("Impossible d'ouvrir l'archive ZIP (code: {$opened})");
            }

            $archive->extractTo($tmpDir);
            $archive->close();

            // Lire le CSV de salaires s'il existe
            $salaires = $this->lireSalairesCsv($tmpDir);

            // Parcourir tous les PDFs du ZIP
            $pdfs = $this->listerPdfs($tmpDir);
            $this->result['total'] = count($pdfs);

            foreach ($pdfs as $pdfPath) {
                $this->traiterPdf($pdfPath, $entrepriseId, $uploadedBy, $salaires, $notifier);
            }

        } finally {
            // Nettoyage du répertoire temporaire
            $this->supprimerRepertoire($tmpDir);
        }

        return $this->result;
    }

    /**
     * Traiter un répertoire de PDFs sur le serveur (pour la commande Artisan)
     */
    public function processRepertoire(
        string $repertoire,
        int $entrepriseId,
        int $uploadedBy,
        bool $notifier = true
    ): array {
        $this->result = ['total' => 0, 'succes' => 0, 'doublons' => 0, 'erreurs' => [], 'bulletins_ids' => []];

        if (!is_dir($repertoire)) {
            throw new \RuntimeException("Le répertoire '{$repertoire}' n'existe pas.");
        }

        $salaires = $this->lireSalairesCsv($repertoire);
        $pdfs     = $this->listerPdfs($repertoire);
        $this->result['total'] = count($pdfs);

        foreach ($pdfs as $pdfPath) {
            $this->traiterPdf($pdfPath, $entrepriseId, $uploadedBy, $salaires, $notifier);

            // Déplacer le fichier traité dans done/
            $done = $repertoire . '/done';
            @mkdir($done, 0755, true);
            @rename($pdfPath, $done . '/' . basename($pdfPath));
        }

        return $this->result;
    }

    /**
     * Traiter un PDF individuel
     */
    private function traiterPdf(
        string $pdfPath,
        int $entrepriseId,
        int $uploadedBy,
        array $salaires,
        bool $notifier
    ): void {
        $basename = basename($pdfPath);

        // Parser le nom du fichier
        $parsed = $this->parseFilename($basename);
        if (!$parsed) {
            $this->result['erreurs'][] = [
                'fichier' => $basename,
                'raison'  => 'Format de nom invalide. Attendu : Bulletin_{Matricule}_{Nom}_{YYYY-MM-DD}_au_{YYYY-MM-DD}.pdf',
            ];
            return;
        }

        // Trouver l'employé correspondant
        $personnel = $this->matchPersonnel($parsed['police'], $parsed['nom'], $entrepriseId);
        if (!$personnel) {
            $this->result['erreurs'][] = [
                'fichier' => $basename,
                'raison'  => "Police «{$parsed['police']}» introuvable dans cette entreprise.",
            ];
            return;
        }

        // Vérifier doublon
        if (BulletinPaie::existePourPeriode($personnel->id, $parsed['annee'], $parsed['mois'])) {
            $this->result['doublons']++;
            return;
        }

        // Données de salaire depuis le CSV (si dispo)
        $matricule    = $personnel->matricule ?? '';
        $salaireBrut  = $salaires[$matricule]['brut'] ?? null;
        $salaireNet   = $salaires[$matricule]['net']  ?? null;

        // Stocker le fichier PDF
        $storagePath = BulletinPaie::getStoragePath($entrepriseId, $parsed['annee'], $parsed['mois']);
        $filename    = Str::slug($personnel->matricule ?? 'emp') . '_' . $parsed['annee'] . '_' . str_pad($parsed['mois'], 2, '0', STR_PAD_LEFT) . '.pdf';
        $destination = $storagePath . '/' . $filename;

        $stored = Storage::disk('public')->put($destination, file_get_contents($pdfPath));
        if (!$stored) {
            $this->result['erreurs'][] = [
                'fichier' => $basename,
                'raison'  => 'Erreur lors de la copie du fichier dans le stockage.',
            ];
            return;
        }

        // Créer le bulletin en base
        try {
            DB::beginTransaction();

            $bulletin = BulletinPaie::create([
                'personnel_id'        => $personnel->id,
                'entreprise_id'       => $entrepriseId,
                'uploaded_by'         => $uploadedBy,
                'mois'                => $parsed['mois'],
                'annee'               => $parsed['annee'],
                'fichier_path'        => $destination,
                'fichier_nom_original' => $basename,
                'fichier_type'        => 'application/pdf',
                'fichier_taille'      => filesize($pdfPath),
                'salaire_brut'        => $salaireBrut,
                'salaire_net'         => $salaireNet,
                'reference'           => BulletinPaie::genererReference($entrepriseId, $personnel->id, $parsed['annee'], $parsed['mois']),
                'statut'              => 'publie',
                'visible_employe'     => true,
                'notifier_employe'    => $notifier,
            ]);

            DB::commit();

            $this->result['succes']++;
            $this->result['bulletins_ids'][] = $bulletin->id;

            // Notifier l'employé si demandé
            if ($notifier && $personnel->user) {
                $personnel->user->notify(new BulletinPaieNotification($bulletin));
            }

        } catch (\Exception $e) {
            DB::rollBack();
            Storage::disk('public')->delete($destination);

            $this->result['erreurs'][] = [
                'fichier' => $basename,
                'raison'  => 'Erreur base de données : ' . $e->getMessage(),
            ];

            Log::error('BulletinImportService: erreur création bulletin', [
                'fichier'  => $basename,
                'error'    => $e->getMessage(),
            ]);
        }
    }

    /**
     * Parser le nom d'un fichier PDF bulletin
     *
     * Format : Bulletin_{Police}_{NomPrenom}_{YYYY-MM-DD}_au_{YYYY-MM-DD}.pdf
     *
     * Exemples :
     *   Bulletin_580U224_TAMINI_THIERRY_NOHMITE_2026-04-19_au_2026-04-19.pdf
     *   Bulletin_001ABC_KABORE_BRICE_2026-03-01_au_2026-03-31.pdf
     */
    public function parseFilename(string $filename): ?array
    {
        $basename = pathinfo($filename, PATHINFO_FILENAME);

        // Pattern : Bulletin_{middle}_{YYYY-MM-DD}_au_{YYYY-MM-DD}
        if (!preg_match('/^Bulletin_(.+)_(\d{4}-\d{2}-\d{2})_au_(\d{4}-\d{2}-\d{2})$/i', $basename, $m)) {
            return null;
        }

        $middle    = $m[1];
        $dateDebut = $m[2];

        $annee = (int) substr($dateDebut, 0, 4);
        $mois  = (int) substr($dateDebut, 5, 2);
        $dateFin = $m[3];

        if ($annee < 2000 || $annee > 2100 || $mois < 1 || $mois > 12) {
            return null;
        }

        // Premier segment = police, reste = nom
        $parts  = explode('_', $middle, 2);
        $police = $parts[0];
        $nom    = isset($parts[1]) ? str_replace('_', ' ', $parts[1]) : '';

        return [
            'police'     => $police,
            'nom'        => $nom,
            'annee'      => $annee,
            'mois'       => $mois,
            'date_debut' => $dateDebut,
            'date_fin'   => $dateFin,
        ];
    }

    /**
     * Trouver l'employé correspondant dans l'entreprise
     * - Recherche d'abord par numéro de police
     * - Repli sur recherche par nom si police non trouvée
     */
    public function matchPersonnel(string $police, string $nom, int $entrepriseId): ?Personnel
    {
        // 1. Recherche par police (identifiant principal)
        $personnel = Personnel::where('police', $police)
            ->where('entreprise_id', $entrepriseId)
            ->first();

        if ($personnel) {
            return $personnel;
        }

        // 2. Repli : recherche approximative par nom
        $parts = array_filter(explode(' ', trim($nom)));
        if (empty($parts)) {
            return null;
        }

        return Personnel::where('entreprise_id', $entrepriseId)
            ->where(function ($query) use ($parts) {
                foreach ($parts as $part) {
                    if (strlen($part) < 3) continue;
                    $query->where(function ($q) use ($part) {
                        $q->where('nom', 'like', "%{$part}%")
                          ->orWhere('prenoms', 'like', "%{$part}%");
                    });
                }
            })
            ->first();
    }

    /**
     * Prévisualiser un ensemble de noms de fichiers sans les importer
     * Retourne pour chaque fichier : police, nom, période, statut (ok/not_found/doublon/parse_error)
     */
    public function preview(array $filenames, int $entrepriseId): array
    {
        $rows = [];

        foreach ($filenames as $filename) {
            $parsed = $this->parseFilename($filename);

            if (!$parsed) {
                $rows[] = [
                    'fichier'    => $filename,
                    'police'     => null,
                    'nom'        => null,
                    'periode'    => null,
                    'personnel'  => null,
                    'doublon'    => false,
                    'statut'     => 'parse_error',
                    'raison'     => 'Format invalide. Attendu : Bulletin_{Police}_{Nom}_{date}_au_{date}.pdf',
                ];
                continue;
            }

            $personnel = $this->matchPersonnel($parsed['police'], $parsed['nom'], $entrepriseId);

            $doublon = $personnel
                ? BulletinPaie::existePourPeriode($personnel->id, $parsed['annee'], $parsed['mois'])
                : false;

            $rows[] = [
                'fichier'   => $filename,
                'police'    => $parsed['police'],
                'nom'       => $parsed['nom'],
                'periode'   => sprintf('%02d/%d', $parsed['mois'], $parsed['annee']),
                'personnel' => $personnel ? [
                    'id'          => $personnel->id,
                    'nom_complet' => $personnel->nom_complet,
                    'matricule'   => $personnel->matricule,
                    'police'      => $personnel->police,
                ] : null,
                'doublon'   => $doublon,
                'statut'    => $doublon ? 'doublon' : ($personnel ? 'ok' : 'not_found'),
                'raison'    => $doublon ? 'Bulletin déjà existant pour cette période' : (!$personnel ? "Police «{$parsed['police']}» introuvable" : null),
            ];
        }

        return $rows;
    }

    /**
     * Lire le fichier salaires.csv optionnel
     * Retourne : ['MATRICULE' => ['brut' => float, 'net' => float], ...]
     */
    private function lireSalairesCsv(string $dir): array
    {
        $csvPath = $dir . '/salaires.csv';
        if (!file_exists($csvPath)) {
            return [];
        }

        $salaires = [];
        $handle   = fopen($csvPath, 'r');

        if (!$handle) {
            return [];
        }

        $headers = fgetcsv($handle); // Ignorer la ligne d'en-tête
        while (($row = fgetcsv($handle)) !== false) {
            if (count($row) >= 3) {
                $matricule           = trim($row[0]);
                $salaires[$matricule] = [
                    'brut' => (float) str_replace(',', '.', $row[1]),
                    'net'  => (float) str_replace(',', '.', $row[2]),
                ];
            }
        }

        fclose($handle);
        return $salaires;
    }

    /**
     * Lister tous les PDFs dans un répertoire (sans les sous-répertoires done/)
     */
    private function listerPdfs(string $dir): array
    {
        $pdfs = [];
        $it   = new \DirectoryIterator($dir);

        foreach ($it as $file) {
            if ($file->isDot() || $file->isDir()) {
                continue;
            }
            if (strtolower($file->getExtension()) === 'pdf') {
                $pdfs[] = $file->getRealPath();
            }
        }

        return $pdfs;
    }

    /**
     * Supprimer récursivement un répertoire temporaire
     */
    private function supprimerRepertoire(string $dir): void
    {
        if (!is_dir($dir)) {
            return;
        }

        $it = new \RecursiveDirectoryIterator($dir, \FilesystemIterator::SKIP_DOTS);
        $ri = new \RecursiveIteratorIterator($it, \RecursiveIteratorIterator::CHILD_FIRST);

        foreach ($ri as $file) {
            $file->isDir() ? rmdir($file->getRealPath()) : unlink($file->getRealPath());
        }

        rmdir($dir);
    }
}
