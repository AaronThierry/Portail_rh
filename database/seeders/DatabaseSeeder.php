<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Créer les départements et services globaux
        $this->call([
            RolesAndPermissionsSeeder::class,
            GlobalDepartementServiceSeeder::class,
            EntrepriseSeeder::class,
            SuperAdminSeeder::class,
            AdminSeeder::class,
        ]);

        $this->command->info('✨ Base de données initialisée avec succès!');
    }
}
