<?php

namespace App\Services;

use App\Models\Personnel;
use Illuminate\Support\Facades\Log;
use Twilio\Rest\Client;
use Twilio\Exceptions\TwilioException;

/**
 * WhatsApp Notification Service — Twilio
 *
 * Envoie des messages WhatsApp via l'API Twilio (actif 24h/24).
 * Utilise le SDK officiel Twilio PHP pour la fiabilité et la simplicité.
 *
 * Configuration requise dans .env :
 *   TWILIO_SID=ACxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
 *   TWILIO_AUTH_TOKEN=xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
 *   TWILIO_WHATSAPP_FROM=whatsapp:+14155238886
 *   WHATSAPP_ENABLED=true
 *   WHATSAPP_DEFAULT_COUNTRY_CODE=226
 */
class WhatsAppService
{
    protected bool $enabled;
    protected string $from;
    protected string $defaultCountryCode;
    protected ?Client $client = null;

    public function __construct()
    {
        $this->enabled            = config('services.whatsapp.enabled', false);
        $this->from               = config('services.twilio.whatsapp_from', '');
        $this->defaultCountryCode = config('services.whatsapp.default_country_code', '226');
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Envoi de base
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * Envoyer un message texte WhatsApp
     *
     * @param string $phone Numéro complet avec indicatif (ex: 22607123456)
     * @param string $body  Contenu du message
     */
    public function sendMessage(string $phone, string $body): bool
    {
        if (!$this->isEnabled()) {
            Log::info('WhatsApp désactivé — message non envoyé', ['to' => $phone]);
            return false;
        }

        try {
            $message = $this->client()->messages->create(
                'whatsapp:+' . $this->formatPhone($phone),
                [
                    'from' => $this->from,
                    'body' => $body,
                ]
            );

            Log::info('WhatsApp envoyé', [
                'to'  => $phone,
                'sid' => $message->sid,
            ]);

            return true;

        } catch (TwilioException $e) {
            Log::error('WhatsApp: erreur Twilio', [
                'to'    => $phone,
                'code'  => $e->getCode(),
                'error' => $e->getMessage(),
            ]);
            return false;

        } catch (\Exception $e) {
            Log::error('WhatsApp: exception inattendue', [
                'to'    => $phone,
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }

    /**
     * Envoyer à un personnel via son profil
     */
    public function sendToPersonnel(Personnel $personnel, string $message): bool
    {
        if (!$personnel->telephone) {
            return false;
        }

        return $this->sendMessage($this->buildPhone($personnel), $message);
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Notifications métier
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * Notification statut congé (approuvé ou refusé)
     */
    public function notifyCongeValidation($conge, Personnel $personnel): bool
    {
        $statut = $conge->statut === 'approuve' ? 'approuvée ✅' : 'refusée ❌';

        $body  = "*Portail RH+ — Demande de congé*\n\n";
        $body .= "Bonjour {$personnel->prenoms},\n\n";
        $body .= "Votre demande de congé ";
        $body .= "du *{$conge->date_debut->format('d/m/Y')}* ";
        $body .= "au *{$conge->date_fin->format('d/m/Y')}* ";
        $body .= "({$conge->nombre_jours} jour(s)) ";
        $body .= "a été *{$statut}*.\n";

        if ($conge->statut === 'refuse' && $conge->motif_refus) {
            $body .= "\n_Motif :_ {$conge->motif_refus}\n";
        }

        $body .= "\nCordialement,\nService RH";

        return $this->sendToPersonnel($personnel, $body);
    }

    /**
     * Notification statut absence (approuvée ou refusée)
     */
    public function notifyAbsenceValidation($absence, Personnel $personnel): bool
    {
        $statut  = $absence->statut === 'approuvee' ? 'approuvée ✅' : 'refusée ❌';
        $typeNom = $absence->typeAbsence->nom ?? 'Absence';

        $body  = "*Portail RH+ — Déclaration d'absence*\n\n";
        $body .= "Bonjour {$personnel->prenoms},\n\n";
        $body .= "Votre déclaration d'absence ({$typeNom}) ";
        $body .= "du *{$absence->date_absence->format('d/m/Y')}* ";
        $body .= "a été *{$statut}*.\n";

        if ($absence->statut === 'refusee' && $absence->motif_refus) {
            $body .= "\n_Motif :_ {$absence->motif_refus}\n";
        }

        $body .= "\nCordialement,\nService RH";

        return $this->sendToPersonnel($personnel, $body);
    }

    /**
     * Notifier les admins d'une nouvelle demande de congé
     */
    public function notifyNewConge($conge, Personnel $adminPersonnel): bool
    {
        $employe = $conge->personnel->nom . ' ' . $conge->personnel->prenoms;
        $typeNom = $conge->typeConge->nom ?? 'Congé';

        $body  = "*Portail RH+ — Nouvelle demande de congé*\n\n";
        $body .= "Bonjour {$adminPersonnel->prenoms},\n\n";
        $body .= "*{$employe}* a soumis une demande de {$typeNom}\n";
        $body .= "📅 Du *{$conge->date_debut->format('d/m/Y')}* ";
        $body .= "au *{$conge->date_fin->format('d/m/Y')}* ";
        $body .= "({$conge->nombre_jours} jours)\n\n";
        $body .= "Connectez-vous sur le portail pour traiter cette demande.";

        return $this->sendToPersonnel($adminPersonnel, $body);
    }

    /**
     * Notifier les admins d'une nouvelle déclaration d'absence
     */
    public function notifyNewAbsence($absence, Personnel $adminPersonnel): bool
    {
        $employe = $absence->personnel->nom . ' ' . $absence->personnel->prenoms;
        $typeNom = $absence->typeAbsence->nom ?? 'Absence';

        $body  = "*Portail RH+ — Nouvelle absence déclarée*\n\n";
        $body .= "Bonjour {$adminPersonnel->prenoms},\n\n";
        $body .= "*{$employe}* a déclaré une absence ({$typeNom})\n";
        $body .= "📅 Le *{$absence->date_absence->format('d/m/Y')}*\n\n";
        $body .= "Connectez-vous sur le portail pour traiter cette déclaration.";

        return $this->sendToPersonnel($adminPersonnel, $body);
    }

    /**
     * Notification bulletin de paie disponible
     */
    public function notifyBulletinPaie($bulletin, Personnel $personnel): bool
    {
        $moisNom = $bulletin->mois_nom ?? $bulletin->mois;

        $body  = "*Portail RH+ — Bulletin de paie disponible* 📄\n\n";
        $body .= "Bonjour {$personnel->prenoms},\n\n";
        $body .= "Votre bulletin de paie de *{$moisNom} {$bulletin->annee}* est disponible.\n\n";
        $body .= "Connectez-vous sur le portail RH+ pour le consulter et le télécharger.\n\n";
        $body .= "Cordialement,\nService RH";

        return $this->sendToPersonnel($personnel, $body);
    }

    /**
     * Notification nouveau document dans le dossier agent
     */
    public function notifyDocumentAgent($document, Personnel $personnel): bool
    {
        $titre     = $document->titre ?? $document->nom_original;
        $categorie = $document->categorie->nom ?? 'Document';

        $body  = "*Portail RH+ — Nouveau document disponible* 📎\n\n";
        $body .= "Bonjour {$personnel->prenoms},\n\n";
        $body .= "Un nouveau document a été ajouté à votre dossier :\n";
        $body .= "• *{$titre}*\n";
        $body .= "• Catégorie : {$categorie}\n\n";
        $body .= "Connectez-vous sur le portail RH+ pour le consulter.\n\n";
        $body .= "Cordialement,\nService RH";

        return $this->sendToPersonnel($personnel, $body);
    }

    /**
     * Notification de création de compte
     */
    public function notifyAccountCreation($user, Personnel $personnel, string $temporaryPassword): bool
    {
        $body  = "*Bienvenue sur le Portail RH+* 🎉\n\n";
        $body .= "Bonjour {$personnel->prenoms},\n\n";
        $body .= "Votre compte a été créé avec succès !\n\n";
        $body .= "📧 Email : {$user->email}\n";
        $body .= "🔑 Mot de passe temporaire : *{$temporaryPassword}*\n\n";
        $body .= "⚠️ Changez votre mot de passe dès votre première connexion.\n";
        $body .= "🔗 " . config('app.url') . "\n\n";
        $body .= "Cordialement,\nService RH";

        return $this->sendToPersonnel($personnel, $body);
    }

    /**
     * Notification personnalisée
     */
    public function notifyCustom(Personnel $personnel, string $title, string $content): bool
    {
        $body = "*Portail RH+ — {$title}*\n\n{$content}";

        return $this->sendToPersonnel($personnel, $body);
    }

    /**
     * Envoi en masse à plusieurs personnels
     */
    public function sendBulkToPersonnels(array $personnelIds, string $message): array
    {
        $results   = ['sent' => 0, 'failed' => 0, 'skipped' => 0];
        $personnels = Personnel::whereIn('id', $personnelIds)
            ->whereNotNull('telephone')
            ->get();

        foreach ($personnels as $personnel) {
            $this->sendToPersonnel($personnel, $message)
                ? $results['sent']++
                : $results['failed']++;

            usleep(300_000); // 300 ms entre chaque envoi (rate limit Twilio)
        }

        $results['skipped'] = count($personnelIds) - $personnels->count();

        return $results;
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Utilitaires
    // ─────────────────────────────────────────────────────────────────────────

    public function isEnabled(): bool
    {
        $sid   = config('services.twilio.sid', '');
        $token = config('services.twilio.token', '');

        return $this->enabled && !empty($sid) && !empty($token) && !empty($this->from);
    }

    public function isValidPhoneNumber(string $phone): bool
    {
        $cleaned = preg_replace('/[^0-9]/', '', $phone);
        return strlen($cleaned) >= 8 && strlen($cleaned) <= 15;
    }

    /**
     * Construire le numéro complet depuis un personnel
     */
    protected function buildPhone(Personnel $personnel): string
    {
        $code = $personnel->telephone_code_pays
            ? preg_replace('/[^0-9]/', '', $personnel->telephone_code_pays)
            : $this->defaultCountryCode;

        return $code . preg_replace('/[^0-9]/', '', $personnel->telephone);
    }

    /**
     * Nettoyer un numéro (chiffres uniquement, sans le +)
     * Twilio attend : whatsapp:+22607123456
     */
    protected function formatPhone(string $phone): string
    {
        return preg_replace('/[^0-9]/', '', $phone);
    }

    /**
     * Client Twilio (instanciation lazy)
     */
    protected function client(): Client
    {
        if ($this->client === null) {
            $this->client = new Client(
                config('services.twilio.sid'),
                config('services.twilio.token')
            );
        }

        return $this->client;
    }
}
