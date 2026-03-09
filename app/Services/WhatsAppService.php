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
        $approuve = $conge->statut === 'approuve';
        $emoji    = $approuve ? '✅' : '❌';
        $statut   = $approuve ? 'APPROUVÉE' : 'REFUSÉE';

        $body  = "🏢 *Portail RH+ — Décision sur votre congé*\n";
        $body .= "━━━━━━━━━━━━━━━━━━━━━\n\n";
        $body .= "Bonjour *{$personnel->prenoms}*,\n\n";
        $body .= "Votre demande de congé a été traitée.\n\n";
        $body .= "📋 *Détails de la demande :*\n";
        $body .= "• Période : {$conge->date_debut->format('d/m/Y')} → {$conge->date_fin->format('d/m/Y')}\n";
        $body .= "• Durée : *{$conge->nombre_jours} jour(s)*\n";
        $body .= "• Décision : {$emoji} *{$statut}*\n";

        if (!$approuve && $conge->motif_refus) {
            $body .= "\n💬 *Motif du refus :*\n_{$conge->motif_refus}_\n";
        }

        $body .= "\n🔗 Consultez votre dossier sur le portail :\n";
        $body .= "https://portail-rh.com/\n\n";
        $body .= "_Cordialement,\nService des Ressources Humaines_";

        return $this->sendToPersonnel($personnel, $body);
    }

    public function notifyAbsenceValidation($absence, Personnel $personnel): bool
    {
        $approuvee = $absence->statut === 'approuvee';
        $emoji     = $approuvee ? '✅' : '❌';
        $statut    = $approuvee ? 'APPROUVÉE' : 'REFUSÉE';
        $typeNom   = $absence->typeAbsence->nom ?? 'Absence';

        $body  = "🏢 *Portail RH+ — Décision sur votre absence*\n";
        $body .= "━━━━━━━━━━━━━━━━━━━━━\n\n";
        $body .= "Bonjour *{$personnel->prenoms}*,\n\n";
        $body .= "Votre déclaration d'absence a été traitée.\n\n";
        $body .= "📋 *Détails de la déclaration :*\n";
        $body .= "• Type : {$typeNom}\n";
        $body .= "• Date : *{$absence->date_absence->format('d/m/Y')}*\n";
        $body .= "• Décision : {$emoji} *{$statut}*\n";

        if (!$approuvee && $absence->motif_refus) {
            $body .= "\n💬 *Motif du refus :*\n_{$absence->motif_refus}_\n";
        }

        $body .= "\n🔗 Consultez votre dossier sur le portail :\n";
        $body .= "https://portail-rh.com/\n\n";
        $body .= "_Cordialement,\nService des Ressources Humaines_";

        return $this->sendToPersonnel($personnel, $body);
    }

    public function notifyNewConge($conge, Personnel $adminPersonnel): bool
    {
        $employe = $conge->personnel->nom . ' ' . $conge->personnel->prenoms;
        $typeNom = $conge->typeConge->nom ?? 'Congé';

        $body  = "🔔 *Portail RH+ — Nouvelle demande à traiter*\n";
        $body .= "━━━━━━━━━━━━━━━━━━━━━\n\n";
        $body .= "Bonjour *{$adminPersonnel->prenoms}*,\n\n";
        $body .= "Une nouvelle demande de congé a été soumise et attend votre validation.\n\n";
        $body .= "👤 *Employé :* {$employe}\n";
        $body .= "📂 *Type :* {$typeNom}\n";
        $body .= "📅 *Période :* {$conge->date_debut->format('d/m/Y')} → {$conge->date_fin->format('d/m/Y')}\n";
        $body .= "⏱ *Durée :* {$conge->nombre_jours} jour(s)\n\n";
        $body .= "🔗 Traitez cette demande sur le portail :\n";
        $body .= "https://portail-rh.com/\n\n";
        $body .= "_Portail RH+ — Gestion des Ressources Humaines_";

        return $this->sendToPersonnel($adminPersonnel, $body);
    }

    public function notifyNewAbsence($absence, Personnel $adminPersonnel): bool
    {
        $employe = $absence->personnel->nom . ' ' . $absence->personnel->prenoms;
        $typeNom = $absence->typeAbsence->nom ?? 'Absence';

        $body  = "🔔 *Portail RH+ — Absence à traiter*\n";
        $body .= "━━━━━━━━━━━━━━━━━━━━━\n\n";
        $body .= "Bonjour *{$adminPersonnel->prenoms}*,\n\n";
        $body .= "Une nouvelle absence a été déclarée et attend votre validation.\n\n";
        $body .= "👤 *Employé :* {$employe}\n";
        $body .= "📂 *Type :* {$typeNom}\n";
        $body .= "📅 *Date :* {$absence->date_absence->format('d/m/Y')}\n\n";
        $body .= "🔗 Traitez cette déclaration sur le portail :\n";
        $body .= "https://portail-rh.com/\n\n";
        $body .= "_Portail RH+ — Gestion des Ressources Humaines_";

        return $this->sendToPersonnel($adminPersonnel, $body);
    }

    public function notifyBulletinPaie($bulletin, Personnel $personnel): bool
    {
        $moisNom = $bulletin->mois_nom ?? $bulletin->mois;

        $body  = "💰 *Portail RH+ — Bulletin de paie disponible*\n";
        $body .= "━━━━━━━━━━━━━━━━━━━━━\n\n";
        $body .= "Bonjour *{$personnel->prenoms}*,\n\n";
        $body .= "Votre bulletin de paie est disponible sur le portail.\n\n";
        $body .= "📄 *Période :* {$moisNom} {$bulletin->annee}\n";

        if (!empty($bulletin->salaire_net)) {
            $body .= "💵 *Salaire net :* " . number_format($bulletin->salaire_net, 0, ',', ' ') . " FCFA\n";
        }

        $body .= "\n📥 *Téléchargez votre bulletin en vous connectant :*\n";
        $body .= "https://portail-rh.com/\n\n";
        $body .= "_(Rubrique Mon Espace → Bulletins de paie)_\n\n";
        $body .= "_Cordialement,\nService des Ressources Humaines_";

        return $this->sendToPersonnel($personnel, $body);
    }

    public function notifyDocumentAgent($document, Personnel $personnel): bool
    {
        $titre     = $document->titre ?? $document->nom_original;
        $categorie = $document->categorie->nom ?? 'Document';

        $body  = "📎 *Portail RH+ — Nouveau document disponible*\n";
        $body .= "━━━━━━━━━━━━━━━━━━━━━\n\n";
        $body .= "Bonjour *{$personnel->prenoms}*,\n\n";
        $body .= "Un nouveau document a été ajouté à votre dossier personnel.\n\n";
        $body .= "📋 *Document :* {$titre}\n";
        $body .= "📁 *Catégorie :* {$categorie}\n\n";
        $body .= "🔗 Consultez votre dossier sur le portail :\n";
        $body .= "https://portail-rh.com/\n\n";
        $body .= "_Cordialement,\nService des Ressources Humaines_";

        return $this->sendToPersonnel($personnel, $body);
    }

    public function notifyAccountCreation($user, Personnel $personnel, string $temporaryPassword): bool
    {
        $body  = "🎉 *Bienvenue sur le Portail RH+*\n";
        $body .= "━━━━━━━━━━━━━━━━━━━━━\n\n";
        $body .= "Bonjour *{$personnel->prenoms}*,\n\n";
        $body .= "Votre compte d'accès au portail RH a été créé avec succès.\n\n";
        $body .= "🔐 *Vos identifiants de connexion :*\n";
        $body .= "• Email : {$user->email}\n";
        $body .= "• Mot de passe temporaire : *{$temporaryPassword}*\n\n";
        $body .= "⚠️ *Important :* Changez votre mot de passe dès votre première connexion.\n\n";
        $body .= "🔗 Accédez au portail ici :\n";
        $body .= "https://portail-rh.com/\n\n";
        $body .= "_Cordialement,\nService des Ressources Humaines_";

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
