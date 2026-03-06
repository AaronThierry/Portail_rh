<?php

namespace App\Services;

use App\Models\Personnel;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * WhatsApp Notification Service — WASenderAPI
 *
 * Envoie des messages WhatsApp via WASenderAPI (connexion QR code).
 * Pas de templates Meta requis — envoi direct comme WhatsApp Web.
 *
 * Configuration requise dans .env :
 *   WASENDER_API_KEY=your_api_key_here
 *   WHATSAPP_ENABLED=true
 *   WHATSAPP_DEFAULT_COUNTRY_CODE=226
 */
class WhatsAppService
{
    protected bool $enabled;
    protected string $defaultCountryCode;
    protected string $apiKey;

    const API_URL = 'https://wasenderapi.com/api/send-message';

    public function __construct()
    {
        $this->enabled            = config('services.whatsapp.enabled', false);
        $this->defaultCountryCode = config('services.whatsapp.default_country_code', '226');
        $this->apiKey             = config('services.wasender.api_key', '');
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Envoi de base
    // ─────────────────────────────────────────────────────────────────────────

    public function sendMessage(string $phone, string $body): bool
    {
        if (!$this->isEnabled()) {
            Log::info('WhatsApp désactivé — message non envoyé', ['to' => $phone]);
            return false;
        }

        $phone = $this->formatPhone($phone);

        try {
            $response = Http::withToken($this->apiKey)
                ->post(self::API_URL, [
                    'to'   => $phone,
                    'text' => $body,
                ]);

            if ($response->successful()) {
                Log::info('WASender: message envoyé', ['to' => $phone]);
                return true;
            }

            Log::warning('WASender: envoi échoué', [
                'to'       => $phone,
                'status'   => $response->status(),
                'body'     => $response->body(),
            ]);

            return false;

        } catch (\Exception $e) {
            Log::error('WASender: exception', [
                'to'    => $phone,
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }

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

    public function notifyBulletinPaie($bulletin, Personnel $personnel): bool
    {
        $moisNom = $bulletin->mois_nom ?? $bulletin->mois;

        $body  = "*Portail RH+ — Bulletin de paie disponible* 📄\n\n";
        $body .= "Bonjour {$personnel->prenoms},\n\n";
        $body .= "Votre bulletin de paie de *{$moisNom} {$bulletin->annee}* est disponible.\n\n";
        $body .= "Connectez-vous sur le portail RH+ pour le consulter et le télécharger.\n";
        $body .= "🔗 " . config('app.url') . "\n\n";
        $body .= "Cordialement,\nService RH";

        return $this->sendToPersonnel($personnel, $body);
    }

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

    public function notifyCustom(Personnel $personnel, string $title, string $content): bool
    {
        return $this->sendToPersonnel($personnel, "*Portail RH+ — {$title}*\n\n{$content}");
    }

    public function sendBulkToPersonnels(array $personnelIds, string $message): array
    {
        $results    = ['sent' => 0, 'failed' => 0, 'skipped' => 0];
        $personnels = Personnel::whereIn('id', $personnelIds)
            ->whereNotNull('telephone')
            ->get();

        foreach ($personnels as $personnel) {
            $this->sendToPersonnel($personnel, $message)
                ? $results['sent']++
                : $results['failed']++;

            usleep(500_000); // 500ms entre envois (anti-spam WhatsApp)
        }

        $results['skipped'] = count($personnelIds) - $personnels->count();

        return $results;
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Utilitaires
    // ─────────────────────────────────────────────────────────────────────────

    public function isEnabled(): bool
    {
        return $this->enabled && !empty($this->apiKey);
    }

    public function isValidPhoneNumber(string $phone): bool
    {
        $cleaned = preg_replace('/[^0-9]/', '', $phone);
        return strlen($cleaned) >= 8 && strlen($cleaned) <= 15;
    }

    protected function buildPhone(Personnel $personnel): string
    {
        $code = $personnel->telephone_code_pays
            ? preg_replace('/[^0-9]/', '', $personnel->telephone_code_pays)
            : $this->defaultCountryCode;

        return $code . preg_replace('/[^0-9]/', '', $personnel->telephone);
    }

    protected function formatPhone(string $phone): string
    {
        return preg_replace('/[^0-9]/', '', $phone);
    }
}
