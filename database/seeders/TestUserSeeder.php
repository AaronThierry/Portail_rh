<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

/**
 * Seeder pour créer des utilisateurs de test
 * avec différents rôles pour tester le système de permissions
 */
class TestUserSeeder extends Seeder
{
    /**
     * Exécute le seeder
     */
    public function run(): void
    {
        // Compte Super Admin
        $superAdmin = User::create([
            'name' => 'Super Admin Test',
            'email' => 'superadmin@test.com',
            'password' => Hash::make('password'),
            'status' => 'active',
        ]);
        $superAdmin->assignRole('Super Admin');

        // Compte Admin
        $admin = User::create([
            'name' => 'Admin Test',
            'email' => 'admin@test.com',
            'password' => Hash::make('password'),
            'status' => 'active',
        ]);
        $admin->assignRole('Admin');

        // Compte Manager
        $manager = User::create([
            'name' => 'Manager Test',
            'email' => 'manager@test.com',
            'password' => Hash::make('password'),
            'status' => 'active',
        ]);
        $manager->assignRole('Manager');

        // Compte Employé
        $employe = User::create([
            'name' => 'Employé Test',
            'email' => 'employe@test.com',
            'password' => Hash::make('password'),
            'status' => 'active',
        ]);
        $employe->assignRole('Employé');

        $this->command->info('✅ Comptes de test créés avec succès!');
        $this->command->info('');
        $this->command->info('📧 Identifiants de connexion:');
        $this->command->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->command->info('Super Admin : superadmin@test.com / password');
        $this->command->info('Admin       : admin@test.com / password');
        $this->command->info('Manager     : manager@test.com / password');
        $this->command->info('Employé     : employe@test.com / password');
        $this->command->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
    }
}
