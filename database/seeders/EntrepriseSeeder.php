<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Entreprise;

class EntrepriseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $entreprises = [
            [
                'nom' => 'TechCorp Solutions',
                'sigle' => 'TCS',
                'email' => 'contact@techcorp.cm',
                'telephone' => '+237 699 123 456',
                'adresse' => 'Bonanjo, Douala',
                'ville' => 'Douala',
                'pays' => 'Cameroun',
                'code_postal' => 'BP 1234',
                'site_web' => 'https://www.techcorp.cm',
                'description' => 'Entreprise de solutions technologiques et de développement logiciel',
                'secteur_activite' => 'Technologie',
                'nombre_employes' => 150,
                'numero_registre' => 'RC-DLA-2020-A-1234',
                'numero_fiscal' => 'NIF-M012345678',
                'is_active' => true,
            ],
            [
                'nom' => 'Commerce Plus SARL',
                'sigle' => 'CP',
                'email' => 'info@commerceplus.cm',
                'telephone' => '+237 677 987 654',
                'adresse' => 'Bastos, Yaoundé',
                'ville' => 'Yaoundé',
                'pays' => 'Cameroun',
                'code_postal' => 'BP 5678',
                'site_web' => 'https://www.commerceplus.cm',
                'description' => 'Distribution et commerce de biens de consommation',
                'secteur_activite' => 'Commerce',
                'nombre_employes' => 85,
                'numero_registre' => 'RC-YDE-2019-B-5678',
                'numero_fiscal' => 'NIF-M098765432',
                'is_active' => true,
            ],
            [
                'nom' => 'Santé Pro Services',
                'sigle' => 'SPS',
                'email' => 'contact@santepro.cm',
                'telephone' => '+237 655 456 789',
                'adresse' => 'Akwa, Douala',
                'ville' => 'Douala',
                'pays' => 'Cameroun',
                'code_postal' => 'BP 9876',
                'site_web' => 'https://www.santepro.cm',
                'description' => 'Services médicaux et gestion d\'établissements de santé',
                'secteur_activite' => 'Santé',
                'nombre_employes' => 220,
                'numero_registre' => 'RC-DLA-2018-C-9876',
                'numero_fiscal' => 'NIF-M054321098',
                'is_active' => true,
            ],
        ];

        foreach ($entreprises as $entreprise) {
            Entreprise::create($entreprise);
        }

        $this->command->info('3 entreprises créées avec succès!');
    }
}
