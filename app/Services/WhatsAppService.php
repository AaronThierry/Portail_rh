<?php

namespace App\Services;

use Twilio\Rest\Client;
use Illuminate\Support\Facades\Log;
use Exception;

/**
 * Service de gestion des notifications WhatsApp via Twilio
 *
 * Ce service permet d'envoyer des notifications WhatsApp aux utilisateurs
 * pour différents événements : validation de congés, rappels, etc.
 */
class WhatsAppService
{
    protected $twilio;
    protected $from;
    protected $enabled;

    public function __construct()
    {
        // Vérifier si WhatsApp est activé
        $this->enabled = config('services.whatsapp.enabled', false);

        if ($this->enabled) {
            $this->twilio = new Client(
                config('services.whatsapp.sid'),
                config('services.whatsapp.token')
            );
            $this->from = config('services.whatsapp.from');
        }
    }

    /**
     * Envoyer une notification WhatsApp
     *
     * @param string $to Numéro au format international (+226XXXXXXXX)
     * @param string $message Message à envoyer
     * @param array $templateData Données pour template (optionnel)
     * @return bool
     */
    public function sendNotification(string $to, string $message, array $templateData = []): bool
    {
        if (!$this->enabled) {
            Log::info('WhatsApp désactivé, message non envoyé', [
                'to' => $to,
                'message' => $message
            ]);
            return false;
        }

        try {
            // Formater le numéro de téléphone
            $formattedTo = $this->formatPhoneNumber($to);

            // Préparer le message
            $body = $this->prepareMessage($message, $templateData);

            // Envoyer via Twilio
            $result = $this->twilio->messages->create(
                "whatsapp:{$formattedTo}",
                [
                    'from' => $this->from,
                    'body' => $body
                ]
            );

            Log::info('Message WhatsApp envoyé avec succès', [
                'sid' => $result->sid,
                'to' => $formattedTo,
                'status' => $result->status
            ]);

            return true;

        } catch (Exception $e) {
            Log::error('Erreur lors de l\'envoi du message WhatsApp', [
                'to' => $to,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return false;
        }
    }

    /**
     * Envoyer une notification de validation de congé
     *
     * @param object $conge
     * @param string $phoneNumber
     * @return bool
     */
    public function notifyCongeValidation($conge, string $phoneNumber): bool
    {
        $status = $conge->statut === 'approuve' ? 'approuvée' : 'refusée';

        $message = "🏖️ *Notification Congé*\n\n";
        $message .= "Bonjour {$conge->personnel->prenoms},\n\n";
        $message .= "Votre demande de congé du *{$conge->date_debut->format('d/m/Y')}* ";
        $message .= "au *{$conge->date_fin->format('d/m/Y')}* ";
        $message .= "a été *{$status}*.\n\n";

        if ($conge->statut === 'refuse' && $conge->motif_refus) {
            $message .= "Motif : {$conge->motif_refus}\n\n";
        }

        $message .= "Cordialement,\n";
        $message .= "Service RH";

        return $this->sendNotification($phoneNumber, $message);
    }

    /**
     * Envoyer une notification de rappel d'événement
     *
     * @param string $phoneNumber
     * @param string $eventTitle
     * @param string $eventDate
     * @return bool
     */
    public function notifyEventReminder(string $phoneNumber, string $eventTitle, string $eventDate): bool
    {
        $message = "📅 *Rappel Événement*\n\n";
        $message .= "N'oubliez pas l'événement suivant :\n\n";
        $message .= "*{$eventTitle}*\n";
        $message .= "Date : {$eventDate}\n\n";
        $message .= "À bientôt !";

        return $this->sendNotification($phoneNumber, $message);
    }

    /**
     * Envoyer une notification de création de compte
     *
     * @param object $user
     * @param string $phoneNumber
     * @param string $temporaryPassword
     * @return bool
     */
    public function notifyAccountCreation($user, string $phoneNumber, string $temporaryPassword): bool
    {
        $message = "👤 *Bienvenue sur le Portail RH*\n\n";
        $message .= "Bonjour {$user->personnel->prenoms},\n\n";
        $message .= "Votre compte utilisateur a été créé avec succès !\n\n";
        $message .= "📧 Email : {$user->email}\n";
        $message .= "🔐 Mot de passe temporaire : {$temporaryPassword}\n\n";
        $message .= "⚠️ Pensez à changer votre mot de passe lors de votre première connexion.\n\n";
        $message .= "🔗 Portail : " . config('app.url');

        return $this->sendNotification($phoneNumber, $message);
    }

    /**
     * Envoyer une notification de rappel de fin de contrat
     *
     * @param object $personnel
     * @param string $phoneNumber
     * @param int $daysRemaining
     * @return bool
     */
    public function notifyContractExpiration($personnel, string $phoneNumber, int $daysRemaining): bool
    {
        $message = "⏰ *Rappel Fin de Contrat*\n\n";
        $message .= "Bonjour {$personnel->prenoms},\n\n";
        $message .= "Votre contrat arrive à expiration dans *{$daysRemaining} jours* ";
        $message .= "le {$personnel->date_fin_contrat->format('d/m/Y')}.\n\n";
        $message .= "Veuillez contacter le service RH pour plus d'informations.\n\n";
        $message .= "Cordialement,\n";
        $message .= "Service RH";

        return $this->sendNotification($phoneNumber, $message);
    }

    /**
     * Envoyer une notification personnalisée
     *
     * @param string $phoneNumber
     * @param string $title
     * @param string $content
     * @return bool
     */
    public function notifyCustom(string $phoneNumber, string $title, string $content): bool
    {
        $message = "*{$title}*\n\n";
        $message .= $content;

        return $this->sendNotification($phoneNumber, $message);
    }

    /**
     * Formater le numéro de téléphone au format international
     *
     * @param string $phoneNumber
     * @return string
     */
    protected function formatPhoneNumber(string $phoneNumber): string
    {
        // Retirer tous les espaces, tirets, parenthèses
        $cleaned = preg_replace('/[^0-9+]/', '', $phoneNumber);

        // Si le numéro commence par 0, remplacer par +226 (Burkina Faso)
        if (substr($cleaned, 0, 1) === '0') {
            $cleaned = '+226' . substr($cleaned, 1);
        }

        // Si le numéro ne commence pas par +, ajouter +226
        if (substr($cleaned, 0, 1) !== '+') {
            $cleaned = '+226' . $cleaned;
        }

        return $cleaned;
    }

    /**
     * Préparer le message avec les données du template
     *
     * @param string $message
     * @param array $data
     * @return string
     */
    protected function prepareMessage(string $message, array $data): string
    {
        foreach ($data as $key => $value) {
            $message = str_replace("{{$key}}", $value, $message);
        }

        return $message;
    }

    /**
     * Vérifier si le service WhatsApp est activé
     *
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    /**
     * Vérifier si un numéro est valide pour WhatsApp
     *
     * @param string $phoneNumber
     * @return bool
     */
    public function isValidPhoneNumber(string $phoneNumber): bool
    {
        $formatted = $this->formatPhoneNumber($phoneNumber);

        // Vérifier le format international
        return preg_match('/^\+[1-9]\d{1,14}$/', $formatted);
    }

    /**
     * Envoyer des notifications en masse
     *
     * @param array $recipients Format: [['phone' => '+226...', 'message' => '...']]
     * @return array Résultats: ['sent' => count, 'failed' => count, 'details' => [...]]
     */
    public function sendBulkNotifications(array $recipients): array
    {
        $results = [
            'sent' => 0,
            'failed' => 0,
            'details' => []
        ];

        foreach ($recipients as $recipient) {
            $success = $this->sendNotification(
                $recipient['phone'],
                $recipient['message']
            );

            if ($success) {
                $results['sent']++;
            } else {
                $results['failed']++;
            }

            $results['details'][] = [
                'phone' => $recipient['phone'],
                'success' => $success
            ];

            // Pause pour éviter le rate limiting (optionnel)
            usleep(100000); // 100ms entre chaque message
        }

        return $results;
    }
}
