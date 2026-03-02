<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class CreateSuperAdmin extends Command
{
    protected $signature   = 'admin:create-super-admin {email} {--name=Super Administrateur}';
    protected $description = 'Créer un compte Super Admin et envoyer les identifiants par email';

    public function handle(): int
    {
        $email = $this->argument('email');
        $name  = $this->option('name');

        // Générer un mot de passe sécurisé
        $password = Str::upper(Str::random(2))
            . Str::lower(Str::random(4))
            . rand(100, 999)
            . Str::random(2, '!@#$%');

        // S'assurer que le rôle existe
        Role::firstOrCreate(['name' => 'Super Admin', 'guard_name' => 'web']);

        // Créer ou mettre à jour l'utilisateur
        $existed = User::where('email', $email)->exists();

        $user = User::updateOrCreate(
            ['email' => $email],
            [
                'name'           => $name,
                'password'       => Hash::make($password),
                'entreprise_id'  => null,
                'role'           => 'super_admin',
                'status'         => 'active',
                'email_verified_at' => now(),
            ]
        );

        // Assigner le rôle Spatie
        if (!$user->hasRole('Super Admin')) {
            $user->assignRole('Super Admin');
        }

        // Envoyer les identifiants par email
        try {
            $appName = config('app.name', 'Portail RH+');
            $appUrl  = config('app.url');

            Mail::raw(
                "Bonjour {$name},\n\n"
                . "Votre compte Super Administrateur sur {$appName} a été créé.\n\n"
                . "--- Vos identifiants de connexion ---\n"
                . "URL      : {$appUrl}\n"
                . "Email    : {$email}\n"
                . "Mot de passe : {$password}\n\n"
                . "⚠️  Veuillez changer votre mot de passe dès votre première connexion.\n\n"
                . "Cordialement,\nL'équipe {$appName}",
                function ($message) use ($email, $name, $appName) {
                    $message->to($email, $name)
                            ->subject("Vos identifiants {$appName} — Compte Super Administrateur");
                }
            );

            $this->info("✅ Email envoyé à {$email}");
        } catch (\Exception $e) {
            $this->warn("⚠️  Email non envoyé : " . $e->getMessage());
            $this->line("   Mot de passe généré : {$password}");
        }

        $action = $existed ? 'mis à jour' : 'créé';
        $this->info("✅ Compte Super Admin {$action} : {$email}");

        return self::SUCCESS;
    }
}
