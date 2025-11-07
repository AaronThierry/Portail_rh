<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Entreprise;

class AdminSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Récupérer la première entreprise (TechCorp Solutions)
        $entreprise = Entreprise::where('sigle', 'TCS')->first();

        if (!$entreprise) {
            $this->command->error('❌ Aucune entreprise trouvée. Veuillez exécuter EntrepriseSeeder d\'abord.');
            return;
        }

        // Créer un utilisateur admin pour l'entreprise
        User::updateOrCreate(
            ['email' => 'admin.techcorp@portail-rh.com'],
            [
                'entreprise_id' => $entreprise->id,
                'name' => 'Admin TechCorp',
                'password' => Hash::make('Admin@2025'),
                'role' => 'admin',
                'department' => 'Direction',
                'status' => 'active',
                'phone' => '+237 690 111 222',
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('✅ Utilisateur admin créé avec succès!');
        $this->command->info('🏢 Entreprise: ' . $entreprise->nom);
        $this->command->info('📧 Email: admin.techcorp@portail-rh.com');
        $this->command->info('🔑 Mot de passe: Admin@2025');
        $this->command->newLine();
        $this->command->warn('⚠️  Veuillez changer le mot de passe après la première connexion !');
    }
}
