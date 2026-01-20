<?php

namespace App\Console\Commands;

use App\Models\Personnel;
use Illuminate\Console\Command;

class CreerDossiersAgentsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'agents:creer-dossiers
                            {--entreprise= : ID de l\'entreprise (optionnel, tous si non spécifié)}
                            {--force : Recréer les dossiers même s\'ils existent}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Créer les dossiers agents manquants pour tous les employés existants';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('=== Création des dossiers agents ===');
        $this->newLine();

        $query = Personnel::query();

        // Filtrer par entreprise si spécifié
        if ($entrepriseId = $this->option('entreprise')) {
            $query->where('entreprise_id', $entrepriseId);
            $this->info("Filtrage par entreprise ID: {$entrepriseId}");
        }

        $personnels = $query->get();
        $total = $personnels->count();

        if ($total === 0) {
            $this->warn('Aucun personnel trouvé.');
            return Command::SUCCESS;
        }

        $this->info("Traitement de {$total} employé(s)...");
        $this->newLine();

        $bar = $this->output->createProgressBar($total);
        $bar->start();

        $created = 0;
        $skipped = 0;
        $errors = 0;

        foreach ($personnels as $personnel) {
            $force = $this->option('force');

            // Vérifier si le dossier existe déjà
            if (!$force && $personnel->dossierAgentExiste()) {
                $skipped++;
                $bar->advance();
                continue;
            }

            // Créer le dossier
            if ($personnel->creerDossierAgent()) {
                $created++;
            } else {
                $errors++;
                $this->newLine();
                $this->error("Erreur pour {$personnel->nom_complet} (ID: {$personnel->id})");
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);

        // Résumé
        $this->info('=== Résumé ===');
        $this->table(
            ['Statut', 'Nombre'],
            [
                ['Dossiers créés', $created],
                ['Déjà existants (ignorés)', $skipped],
                ['Erreurs', $errors],
                ['Total traité', $total],
            ]
        );

        if ($errors > 0) {
            $this->warn('Des erreurs se sont produites. Consultez les logs pour plus de détails.');
            return Command::FAILURE;
        }

        $this->info('Terminé avec succès !');
        return Command::SUCCESS;
    }
}
