<?php

namespace App\Console\Commands;

use App\Models\BulletinImport;
use App\Models\Entreprise;
use App\Services\BulletinImportService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ImportBulletins extends Command
{
    protected $signature = 'bulletins:import
                            {--entreprise= : ID de l\'entreprise}
                            {--dossier=    : Chemin du dossier de PDFs (défaut : storage/app/imports/bulletins/{entreprise_id})}
                            {--notify      : Notifier les employés après import}';

    protected $description = 'Importer automatiquement les bulletins de paie depuis un dossier de PDFs';

    public function handle(BulletinImportService $service): int
    {
        $entrepriseId = $this->option('entreprise');
        $notifier     = (bool) $this->option('notify');

        // Résoudre l'entreprise
        if (!$entrepriseId) {
            $entreprises = Entreprise::orderBy('nom')->get();

            if ($entreprises->isEmpty()) {
                $this->error('Aucune entreprise trouvée dans la base de données.');
                return self::FAILURE;
            }

            $choix = $this->choice(
                'Quelle entreprise ?',
                $entreprises->pluck('nom', 'id')->toArray()
            );

            $entrepriseId = $entreprises->firstWhere('nom', $choix)?->id;
        }

        $entreprise = Entreprise::find($entrepriseId);
        if (!$entreprise) {
            $this->error("Entreprise ID={$entrepriseId} introuvable.");
            return self::FAILURE;
        }

        // Résoudre le dossier
        $dossier = $this->option('dossier')
            ?? Storage::disk('local')->path("imports/bulletins/{$entrepriseId}");

        if (!is_dir($dossier)) {
            @mkdir($dossier, 0755, true);
            $this->warn("Dossier créé : {$dossier}");
            $this->info("Déposez vos PDFs dans ce dossier puis relancez la commande.");
            return self::SUCCESS;
        }

        $pdfs = glob($dossier . '/*.pdf');
        if (empty($pdfs)) {
            $this->info("Aucun PDF trouvé dans : {$dossier}");
            return self::SUCCESS;
        }

        $this->info("Traitement de " . count($pdfs) . " PDF(s) pour {$entreprise->nom}...");
        $this->newLine();

        $bar = $this->output->createProgressBar(count($pdfs));
        $bar->start();

        // Import via le service (mode répertoire)
        $result = $service->processRepertoire($dossier, $entrepriseId, 1, $notifier);

        $bar->finish();
        $this->newLine(2);

        // Afficher le résumé
        $this->table(
            ['Métrique', 'Valeur'],
            [
                ['Total PDFs', $result['total']],
                ['✅ Succès', $result['succes']],
                ['⚠️  Doublons ignorés', $result['doublons']],
                ['❌ Erreurs', count($result['erreurs'])],
            ]
        );

        // Afficher les erreurs
        if (!empty($result['erreurs'])) {
            $this->newLine();
            $this->warn('Détail des erreurs :');
            foreach ($result['erreurs'] as $erreur) {
                $this->line("  - {$erreur['fichier']} : {$erreur['raison']}");
            }
        }

        // Enregistrer dans les logs
        $statut = 'termine';
        if ($result['succes'] === 0 && $result['total'] > 0) {
            $statut = 'echec';
        } elseif (!empty($result['erreurs'])) {
            $statut = 'partiel';
        }

        BulletinImport::create([
            'entreprise_id'   => $entrepriseId,
            'uploaded_by'     => 1,
            'fichier_zip'     => 'commande:bulletins:import (dossier)',
            'total'           => $result['total'],
            'succes'          => $result['succes'],
            'doublons'        => $result['doublons'],
            'erreurs_count'   => count($result['erreurs']),
            'erreurs'         => $result['erreurs'],
            'bulletins_crees' => $result['bulletins_ids'],
            'statut'          => $statut,
        ]);

        if ($result['succes'] > 0) {
            $this->info("✅ {$result['succes']} bulletin(s) importé(s) avec succès.");
        }

        return self::SUCCESS;
    }
}
