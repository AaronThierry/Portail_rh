<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetCodeMail;
use App\Models\User;

class TestEmailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:email {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test l\'envoi d\'email de réinitialisation de mot de passe';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');

        $this->info("Test d'envoi d'email vers: {$email}");

        // Créer un utilisateur fictif pour le test
        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error("Aucun utilisateur trouvé avec l'email: {$email}");
            $this->info("Création d'un utilisateur fictif pour le test...");

            $user = new User();
            $user->nom = 'Test';
            $user->prenom = 'User';
            $user->email = $email;
        }

        $code = '123456';

        try {
            Mail::to($email)->send(new ResetCodeMail($user, $code));
            $this->info("✅ Email envoyé avec succès!");
            $this->info("Code OTP: {$code}");
        } catch (\Exception $e) {
            $this->error("❌ Erreur lors de l'envoi de l'email:");
            $this->error($e->getMessage());
            $this->error("\nStack trace:");
            $this->error($e->getTraceAsString());
        }

        return 0;
    }
}
