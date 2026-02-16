<?php

namespace App\Services;

use App\Models\Personnel;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class WhatsAppService
{
    protected bool $enabled;

    public function __construct()
    {
        $this->enabled = config('services.whatsapp.enabled', false);
    }

    /**
     * Envoyer un message WhatsApp via CallMeBot
     */
    public function sendNotification(string $phone, string $message, string $apikey): bool
    {
        if (!$this->enabled) {
            Log::info('WhatsApp desactive, message non envoye', ['to' => $phone]);
            return false;
        }

        if (empty($apikey)) {
            Log::warning('WhatsApp: pas de cle API pour le numero', ['to' => $phone]);
            return false;
        }

        try {
            $formattedPhone = $this->formatPhoneNumber($phone);

            $response = Http::timeout(15)->get('https://api.callmebot.com/whatsapp.php', [
                'phone' => $formattedPhone,
                'text' => $message,
                'apikey' => $apikey,
            ]);

            if ($response->successful()) {
                Log::info('WhatsApp envoye avec succes', [
                    'to' => $formattedPhone,
                    'status' => $response->status(),
                ]);
                return true;
            }

            Log::error('WhatsApp: erreur API CallMeBot', [
                'to' => $formattedPhone,
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
            return false;

        } catch (Exception $e) {
            Log::error('WhatsApp: exception lors de l\'envoi', [
                'to' => $phone,
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }

    /**
     * Envoyer un message WhatsApp a un personnel (recupere phone + apikey automatiquement)
     */
    public function sendToPersonnel(Personnel $personnel, string $message): bool
    {
        if (!$personnel->callmebot_apikey || !$personnel->telephone) {
            return false;
        }

        $phone = ($personnel->telephone_code_pays ?? '+226') . $personnel->telephone;

        return $this->sendNotification($phone, $message, $personnel->callmebot_apikey);
    }

    /**
     * Notification de validation/refus de conge
     */
    public function notifyCongeValidation($conge, Personnel $personnel): bool
    {
        $status = $conge->statut === 'approuve' ? 'approuvee' : 'refusee';

        $message = "Notification Conge - Portail RH+\n\n";
        $message .= "Bonjour {$conge->personnel->prenoms},\n\n";
        $message .= "Votre demande de conge du {$conge->date_debut->format('d/m/Y')} ";
        $message .= "au {$conge->date_fin->format('d/m/Y')} ";
        $message .= "a ete {$status}.\n";

        if ($conge->statut === 'refuse' && $conge->motif_refus) {
            $message .= "Motif : {$conge->motif_refus}\n";
        }

        $message .= "\nCordialement, Service RH";

        return $this->sendToPersonnel($personnel, $message);
    }

    /**
     * Notification de validation/refus d'absence
     */
    public function notifyAbsenceValidation($absence, Personnel $personnel): bool
    {
        $status = $absence->statut === 'approuvee' ? 'approuvee' : 'refusee';
        $typeNom = $absence->typeAbsence->nom ?? 'Absence';

        $message = "Notification Absence - Portail RH+\n\n";
        $message .= "Bonjour {$personnel->prenoms},\n\n";
        $message .= "Votre declaration d'absence ({$typeNom}) du {$absence->date_absence->format('d/m/Y')} ";
        $message .= "a ete {$status}.\n";

        if ($absence->statut === 'refusee' && $absence->motif_refus) {
            $message .= "Motif : {$absence->motif_refus}\n";
        }

        $message .= "\nCordialement, Service RH";

        return $this->sendToPersonnel($personnel, $message);
    }

    /**
     * Notifier les admins d'une nouvelle demande de conge
     */
    public function notifyNewConge($conge, Personnel $adminPersonnel): bool
    {
        $employe = $conge->personnel->nom . ' ' . $conge->personnel->prenoms;
        $typeNom = $conge->typeConge->nom ?? 'Conge';

        $message = "Nouvelle demande de conge - Portail RH+\n\n";
        $message .= "{$employe} a soumis une demande de {$typeNom}\n";
        $message .= "Du {$conge->date_debut->format('d/m/Y')} au {$conge->date_fin->format('d/m/Y')}\n";
        $message .= "Duree : {$conge->nombre_jours} jours\n\n";
        $message .= "Connectez-vous au portail pour traiter cette demande.";

        return $this->sendToPersonnel($adminPersonnel, $message);
    }

    /**
     * Notifier les admins d'une nouvelle declaration d'absence
     */
    public function notifyNewAbsence($absence, Personnel $adminPersonnel): bool
    {
        $employe = $absence->personnel->nom . ' ' . $absence->personnel->prenoms;
        $typeNom = $absence->typeAbsence->nom ?? 'Absence';

        $message = "Nouvelle absence declaree - Portail RH+\n\n";
        $message .= "{$employe} a declare une absence ({$typeNom})\n";
        $message .= "Date : {$absence->date_absence->format('d/m/Y')}\n\n";
        $message .= "Connectez-vous au portail pour traiter cette demande.";

        return $this->sendToPersonnel($adminPersonnel, $message);
    }

    /**
     * Notification de creation de compte
     */
    public function notifyAccountCreation($user, Personnel $personnel, string $temporaryPassword): bool
    {
        $message = "Bienvenue sur le Portail RH+\n\n";
        $message .= "Bonjour {$personnel->prenoms},\n\n";
        $message .= "Votre compte a ete cree !\n\n";
        $message .= "Email : {$user->email}\n";
        $message .= "Mot de passe : {$temporaryPassword}\n\n";
        $message .= "Changez votre mot de passe a la premiere connexion.\n";
        $message .= "Portail : " . config('app.url');

        return $this->sendToPersonnel($personnel, $message);
    }

    /**
     * Notification personnalisee
     */
    public function notifyCustom(Personnel $personnel, string $title, string $content): bool
    {
        $message = "{$title} - Portail RH+\n\n{$content}";

        return $this->sendToPersonnel($personnel, $message);
    }

    /**
     * Envoyer des notifications en masse
     */
    public function sendBulkToPersonnels(array $personnelIds, string $message): array
    {
        $results = ['sent' => 0, 'failed' => 0, 'skipped' => 0];

        $personnels = Personnel::whereIn('id', $personnelIds)
            ->whereNotNull('callmebot_apikey')
            ->whereNotNull('telephone')
            ->get();

        foreach ($personnels as $personnel) {
            $success = $this->sendToPersonnel($personnel, $message);

            if ($success) {
                $results['sent']++;
            } else {
                $results['failed']++;
            }

            // Pause pour eviter le rate limiting CallMeBot
            usleep(500000); // 500ms entre chaque message
        }

        $results['skipped'] = count($personnelIds) - $personnels->count();

        return $results;
    }

    /**
     * Formater le numero au format international (sans +, requis par CallMeBot)
     */
    protected function formatPhoneNumber(string $phoneNumber): string
    {
        $cleaned = preg_replace('/[^0-9+]/', '', $phoneNumber);

        // Si commence par 0, remplacer par +226
        if (substr($cleaned, 0, 1) === '0') {
            $cleaned = '+226' . substr($cleaned, 1);
        }

        // Si ne commence pas par +, ajouter +226
        if (substr($cleaned, 0, 1) !== '+') {
            $cleaned = '+226' . $cleaned;
        }

        return $cleaned;
    }

    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    public function isValidPhoneNumber(string $phoneNumber): bool
    {
        $formatted = $this->formatPhoneNumber($phoneNumber);
        return (bool) preg_match('/^\+[1-9]\d{1,14}$/', $formatted);
    }
}
