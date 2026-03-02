<?php

namespace App\Services;

use App\Models\Personnel;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * WhatsApp Notification Service — CallMeBot
 *
 * Envoie des messages WhatsApp gratuitement via CallMeBot.
 * Aucune configuration serveur, aucun abonnement.
 *
 * Prérequis par employé (une seule fois) :
 *   1. Envoyer "I allow callmebot to send me messages" au +34 644 45 77 87
 *   2. Recevoir l'API key par WhatsApp
 *   3. L'admin saisit cette key dans la fiche personnel (champ callmebot_apikey)
 *
 * Doc : https://www.callmebot.com/blog/free-api-whatsapp-messages/
 */
class WhatsAppService
{
    protected const API_URL = 'https://api.callmebot.com/whatsapp.php';
    protected bool $enabled;
    protected string $defaultCountryCode;

    public function __construct()
    {
        $this->enabled            = config('services.whatsapp.enabled', false);
        $this->defaultCountryCode = config('services.whatsapp.default_country_code', '226');
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Envoi de base
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * Envoyer un message WhatsApp via CallMeBot
     *
     * @param string $phone  Numéro complet avec indicatif (ex: 22607123456)
     * @param string $apiKey API key CallMeBot de l'employé
     * @param string $body   Contenu du message
     */
    public function sendMessage(string $phone, string $apiKey, string $body): bool
    {
        if (!$this->isEnabled()) {
            Log::info('WhatsApp désactivé — message non envoyé', ['to' => $phone]);
            return false;
        }

        try {
            $response = Http::timeout(15)->get(self::API_URL, [
                'phone'  => '+' . preg_replace('/[^0-9]/', '', $phone),
                'text'   => $body,
                'apikey' => $apiKey,
            ]);

            if ($response->successful()) {
                Log::info('WhatsApp envoyé', ['to' => $phone]);
                return true;
            }

            Log::error('WhatsApp: erreur CallMeBot', [
                'to'     => $phone,
                'status' => $response->status(),
                'body'   => $response->body(),
            ]);
            return false;

        } catch (\Exception $e) {
            Log::error('WhatsApp: exception', [
                'to'    => $phone,
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }

    /**
     * Envoyer à un personnel (vérifie qu'il a une API key CallMeBot)
     */
    public function sendToPersonnel(Personnel $personnel, string $message): bool
    {
        if (!$personnel->telephone || !$personnel->callmebot_apikey) {
            return false;
        }

        return $this->sendMessage(
            $this->buildPhone($personnel),
            $personnel->callmebot_apikey,
            $message
        );
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

        $body  = "Portail RH+ — Demande de congé\n\n";
        $body .= "Bonjour {$personnel->prenoms},\n\n";
        $body .= "Votre demande de congé ";
        $body .= "du {$conge->date_debut->format('d/m/Y')} ";
        $body .= "au {$conge->date_fin->format('d/m/Y')} ";
        $body .= "({$conge->nombre_jours} jour(s)) ";
        $body .= "a été {$statut}";

        if ($conge->statut === 'refuse' && $conge->motif_refus) {
            $body .= "\n\nMotif : {$conge->motif_refus}";
        }

        $body .= "\n\nCordialement, Service RH";

        return $this->sendToPersonnel($personnel, $body);
    }

    /**
     * Notification statut absence (approuvée ou refusée)
     */
    public function notifyAbsenceValidation($absence, Personnel $personnel): bool
    {
        $statut  = $absence->statut === 'approuvee' ? 'approuvée ✅' : 'refusée ❌';
        $typeNom = $absence->typeAbsence->nom ?? 'Absence';

        $body  = "Portail RH+ — Absence\n\n";
        $body .= "Bonjour {$personnel->prenoms},\n\n";
        $body .= "Votre déclaration d'absence ({$typeNom}) ";
        $body .= "du {$absence->date_absence->format('d/m/Y')} ";
        $body .= "a été {$statut}";

        if ($absence->statut === 'refusee' && $absence->motif_refus) {
            $body .= "\n\nMotif : {$absence->motif_refus}";
        }

        $body .= "\n\nCordialement, Service RH";

        return $this->sendToPersonnel($personnel, $body);
    }

    /**
     * Notifier un admin d'une nouvelle demande de congé
     */
    public function notifyNewConge($conge, Personnel $adminPersonnel): bool
    {
        $employe = $conge->personnel->nom . ' ' . $conge->personnel->prenoms;
        $typeNom = $conge->typeConge->nom ?? 'Congé';

        $body  = "Portail RH+ — Nouvelle demande\n\n";
        $body .= "Bonjour {$adminPersonnel->prenoms},\n\n";
        $body .= "{$employe} a soumis une demande de {$typeNom}\n";
        $body .= "Du {$conge->date_debut->format('d/m/Y')} ";
        $body .= "au {$conge->date_fin->format('d/m/Y')} ";
        $body .= "({$conge->nombre_jours} jours)\n\n";
        $body .= "Connectez-vous sur le portail pour traiter.";

        return $this->sendToPersonnel($adminPersonnel, $body);
    }

    /**
     * Notifier un admin d'une nouvelle déclaration d'absence
     */
    public function notifyNewAbsence($absence, Personnel $adminPersonnel): bool
    {
        $employe = $absence->personnel->nom . ' ' . $absence->personnel->prenoms;
        $typeNom = $absence->typeAbsence->nom ?? 'Absence';

        $body  = "Portail RH+ — Nouvelle absence\n\n";
        $body .= "Bonjour {$adminPersonnel->prenoms},\n\n";
        $body .= "{$employe} a déclaré une absence ({$typeNom})\n";
        $body .= "Le {$absence->date_absence->format('d/m/Y')}\n\n";
        $body .= "Connectez-vous sur le portail pour traiter.";

        return $this->sendToPersonnel($adminPersonnel, $body);
    }

    /**
     * Notification bulletin de paie disponible
     */
    public function notifyBulletinPaie($bulletin, Personnel $personnel): bool
    {
        $moisNom = $bulletin->mois_nom ?? $bulletin->mois;

        $body  = "Portail RH+ — Bulletin de paie 📄\n\n";
        $body .= "Bonjour {$personnel->prenoms},\n\n";
        $body .= "Votre bulletin de paie de {$moisNom} {$bulletin->annee} est disponible.\n\n";
        $body .= "Connectez-vous sur le portail RH+ pour le consulter.\n\n";
        $body .= "Cordialement, Service RH";

        return $this->sendToPersonnel($personnel, $body);
    }

    /**
     * Notification nouveau document dans le dossier agent
     */
    public function notifyDocumentAgent($document, Personnel $personnel): bool
    {
        $titre     = $document->titre ?? $document->nom_original;
        $categorie = $document->categorie->nom ?? 'Document';

        $body  = "Portail RH+ — Nouveau document 📎\n\n";
        $body .= "Bonjour {$personnel->prenoms},\n\n";
        $body .= "Un document a été ajouté à votre dossier :\n";
        $body .= "- {$titre} ({$categorie})\n\n";
        $body .= "Connectez-vous sur le portail pour le consulter.\n\n";
        $body .= "Cordialement, Service RH";

        return $this->sendToPersonnel($personnel, $body);
    }

    /**
     * Notification création de compte
     */
    public function notifyAccountCreation($user, Personnel $personnel, string $temporaryPassword): bool
    {
        $body  = "Bienvenue sur le Portail RH+ 🎉\n\n";
        $body .= "Bonjour {$personnel->prenoms},\n\n";
        $body .= "Votre compte a été créé !\n\n";
        $body .= "Email : {$user->email}\n";
        $body .= "Mot de passe : {$temporaryPassword}\n\n";
        $body .= "Changez votre mot de passe à la première connexion.\n";
        $body .= config('app.url') . "\n\n";
        $body .= "Cordialement, Service RH";

        return $this->sendToPersonnel($personnel, $body);
    }

    /**
     * Notification personnalisée
     */
    public function notifyCustom(Personnel $personnel, string $title, string $content): bool
    {
        return $this->sendToPersonnel($personnel, "Portail RH+ — {$title}\n\n{$content}");
    }

    /**
     * Envoi en masse
     */
    public function sendBulkToPersonnels(array $personnelIds, string $message): array
    {
        $results   = ['sent' => 0, 'failed' => 0, 'skipped' => 0];
        $personnels = Personnel::whereIn('id', $personnelIds)
            ->whereNotNull('telephone')
            ->whereNotNull('callmebot_apikey')
            ->get();

        foreach ($personnels as $personnel) {
            $this->sendToPersonnel($personnel, $message)
                ? $results['sent']++
                : $results['failed']++;

            usleep(300_000); // 300 ms entre chaque envoi
        }

        $results['skipped'] = count($personnelIds) - $personnels->count();

        return $results;
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Utilitaires
    // ─────────────────────────────────────────────────────────────────────────

    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    public function isValidPhoneNumber(string $phone): bool
    {
        $cleaned = preg_replace('/[^0-9]/', '', $phone);
        return \strlen($cleaned) >= 8 && \strlen($cleaned) <= 15;
    }

    protected function buildPhone(Personnel $personnel): string
    {
        $code = $personnel->telephone_code_pays
            ? preg_replace('/[^0-9]/', '', $personnel->telephone_code_pays)
            : $this->defaultCountryCode;

        return $code . preg_replace('/[^0-9]/', '', $personnel->telephone);
    }
}
