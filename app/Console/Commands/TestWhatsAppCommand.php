<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\WhatsAppService;

/**
 * Commande pour tester l'envoi de messages WhatsApp
 *
 * Usage: php artisan whatsapp:test +22670123456
 */
class TestWhatsAppCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'whatsapp:test {phone : Le numéro de téléphone au format +226XXXXXXXX}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tester l\'envoi d\'un message WhatsApp via Twilio';

    protected $whatsapp;

    /**
     * Create a new command instance.
     */
    public function __construct(WhatsAppService $whatsapp)
    {
        parent::__construct();
        $this->whatsapp = $whatsapp;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $phone = $this->argument('phone');

        // Vérifier si WhatsApp est activé
        if (!$this->whatsapp->isEnabled()) {
            $this->error('❌ WhatsApp est désactivé dans la configuration.');
            $this->info('💡 Activez-le en ajoutant TWILIO_WHATSAPP_ENABLED=true dans .env');
            return 1;
        }

        $this->info("📱 Test d'envoi WhatsApp vers {$phone}");
        $this->newLine();

        // Vérifier le format du numéro
        if (!$this->whatsapp->isValidPhoneNumber($phone)) {
            $this->error('❌ Le numéro de téléphone n\'est pas valide.');
            $this->info('💡 Format attendu : +226XXXXXXXX');
            return 1;
        }

        $this->info('✅ Numéro de téléphone valide');

        // Message de test
        $message = "🧪 *Message de test*\n\n"
                 . "Bonjour,\n\n"
                 . "Ceci est un message de test du Portail RH.\n\n"
                 . "Si vous recevez ce message, l'intégration WhatsApp fonctionne correctement ! ✅\n\n"
                 . "Date : " . now()->format('d/m/Y H:i') . "\n\n"
                 . "Cordialement,\n"
                 . "L'équipe technique";

        // Envoyer le message
        $this->info('📤 Envoi en cours...');

        $bar = $this->output->createProgressBar(3);
        $bar->start();

        for ($i = 0; $i < 3; $i++) {
            sleep(1);
            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);

        try {
            $success = $this->whatsapp->sendNotification($phone, $message);

            if ($success) {
                $this->info('✅ Message envoyé avec succès !');
                $this->newLine();
                $this->info('📱 Vérifiez WhatsApp sur le téléphone ' . $phone);
                $this->newLine();
                $this->comment('💡 Astuce : Si vous utilisez le sandbox Twilio, assurez-vous que');
                $this->comment('   le numéro a bien envoyé le code d\'activation au préalable.');
                return 0;
            } else {
                $this->error('❌ Échec de l\'envoi du message.');
                $this->info('📋 Consultez les logs pour plus de détails : storage/logs/laravel.log');
                return 1;
            }

        } catch (\Exception $e) {
            $this->error('❌ Erreur : ' . $e->getMessage());
            $this->newLine();
            $this->error('Trace : ' . $e->getTraceAsString());
            return 1;
        }
    }
}
