<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Departement;
use App\Models\Service;

class GlobalDepartementServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Départements globaux (disponibles pour toutes les entreprises)
        $departements = [
            [
                'nom' => 'Direction Générale',
                'code' => 'DG',
                'description' => 'Direction générale et stratégie d\'entreprise',
                'is_global' => true,
                'is_active' => true,
            ],
            [
                'nom' => 'Ressources Humaines',
                'code' => 'RH',
                'description' => 'Gestion du personnel et administration RH',
                'is_global' => true,
                'is_active' => true,
            ],
            [
                'nom' => 'Finance et Comptabilité',
                'code' => 'FIN',
                'description' => 'Gestion financière et comptable',
                'is_global' => true,
                'is_active' => true,
            ],
            [
                'nom' => 'Informatique',
                'code' => 'IT',
                'description' => 'Systèmes d\'information et technologies',
                'is_global' => true,
                'is_active' => true,
            ],
            [
                'nom' => 'Commercial',
                'code' => 'COM',
                'description' => 'Ventes et développement commercial',
                'is_global' => true,
                'is_active' => true,
            ],
            [
                'nom' => 'Marketing',
                'code' => 'MKT',
                'description' => 'Marketing et communication',
                'is_global' => true,
                'is_active' => true,
            ],
            [
                'nom' => 'Production',
                'code' => 'PROD',
                'description' => 'Gestion de la production',
                'is_global' => true,
                'is_active' => true,
            ],
            [
                'nom' => 'Logistique',
                'code' => 'LOG',
                'description' => 'Gestion des stocks et logistique',
                'is_global' => true,
                'is_active' => true,
            ],
            [
                'nom' => 'Qualité',
                'code' => 'QUAL',
                'description' => 'Contrôle qualité et amélioration continue',
                'is_global' => true,
                'is_active' => true,
            ],
            [
                'nom' => 'Juridique',
                'code' => 'JUR',
                'description' => 'Affaires juridiques et conformité',
                'is_global' => true,
                'is_active' => true,
            ],
        ];

        foreach ($departements as $dept) {
            Departement::create($dept);
        }

        $this->command->info('10 départements globaux créés avec succès!');

        // Services globaux par département
        $services = [
            // Direction Générale
            ['departement_code' => 'DG', 'nom' => 'Direction', 'code' => 'DG-DIR'],
            ['departement_code' => 'DG', 'nom' => 'Secrétariat de Direction', 'code' => 'DG-SEC'],

            // Ressources Humaines
            ['departement_code' => 'RH', 'nom' => 'Recrutement', 'code' => 'RH-REC'],
            ['departement_code' => 'RH', 'nom' => 'Formation', 'code' => 'RH-FOR'],
            ['departement_code' => 'RH', 'nom' => 'Paie', 'code' => 'RH-PAI'],
            ['departement_code' => 'RH', 'nom' => 'Administration du Personnel', 'code' => 'RH-ADP'],

            // Finance et Comptabilité
            ['departement_code' => 'FIN', 'nom' => 'Comptabilité Générale', 'code' => 'FIN-CG'],
            ['departement_code' => 'FIN', 'nom' => 'Contrôle de Gestion', 'code' => 'FIN-CDG'],
            ['departement_code' => 'FIN', 'nom' => 'Trésorerie', 'code' => 'FIN-TRE'],

            // Informatique
            ['departement_code' => 'IT', 'nom' => 'Développement', 'code' => 'IT-DEV'],
            ['departement_code' => 'IT', 'nom' => 'Infrastructure', 'code' => 'IT-INF'],
            ['departement_code' => 'IT', 'nom' => 'Support', 'code' => 'IT-SUP'],

            // Commercial
            ['departement_code' => 'COM', 'nom' => 'Ventes', 'code' => 'COM-VEN'],
            ['departement_code' => 'COM', 'nom' => 'Grands Comptes', 'code' => 'COM-GC'],
            ['departement_code' => 'COM', 'nom' => 'Service Client', 'code' => 'COM-SC'],

            // Marketing
            ['departement_code' => 'MKT', 'nom' => 'Marketing Digital', 'code' => 'MKT-DIG'],
            ['departement_code' => 'MKT', 'nom' => 'Communication', 'code' => 'MKT-COM'],
            ['departement_code' => 'MKT', 'nom' => 'Études de Marché', 'code' => 'MKT-ETU'],
        ];

        foreach ($services as $srv) {
            $departement = Departement::where('code', $srv['departement_code'])->first();
            if ($departement) {
                Service::create([
                    'departement_id' => $departement->id,
                    'nom' => $srv['nom'],
                    'code' => $srv['code'],
                    'description' => null,
                    'is_global' => true,
                    'is_active' => true,
                ]);
            }
        }

        $this->command->info(count($services) . ' services globaux créés avec succès!');
    }
}
