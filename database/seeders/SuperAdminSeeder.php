<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer le compte Super Admin
        $superAdmin = User::create([
            'entreprise_id' => null, // null = accès à toutes les entreprises
            'name' => 'Super Administrateur',
            'email' => 'admin@portail-rh.com',
            'password' => Hash::make('Admin@2025'),
            'phone' => '+237 690 000 000',
            'role' => 'super_admin',
            'department' => 'Direction Générale',
            'status' => 'active',
        ]);

        $this->command->info('✅ Super Admin créé avec succès !');
        $this->command->info('📧 Email: admin@portail-rh.com');
        $this->command->info('🔑 Mot de passe: Admin@2025');
        $this->command->newLine();
        $this->command->warn('⚠️  Veuillez changer le mot de passe après la première connexion !');
    }
}
