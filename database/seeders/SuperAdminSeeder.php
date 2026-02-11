<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Spatie\Permission\Models\Role;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // S'assurer que le rôle Super Admin existe
        Role::firstOrCreate(['name' => 'Super Admin', 'guard_name' => 'web']);

        // Créer ou mettre à jour le compte Super Admin
        $superAdmin = User::updateOrCreate(
            ['email' => 'admin@portail-rh.com'],
            [
                'entreprise_id' => null,
                'name' => 'Super Administrateur',
                'password' => Hash::make('Admin@2025'),
                'phone' => '+237 690 000 000',
                'role' => 'super_admin',
                'department' => 'Direction Générale',
                'status' => 'active',
            ]
        );

        // Assigner le rôle Spatie
        if (!$superAdmin->hasRole('Super Admin')) {
            $superAdmin->assignRole('Super Admin');
        }

        $this->command->info('Super Admin cree avec succes !');
        $this->command->info('Email: admin@portail-rh.com');
        $this->command->info('Mot de passe: Admin@2025');
        $this->command->newLine();
        $this->command->warn('Veuillez changer le mot de passe apres la premiere connexion !');
    }
}
