<?php

namespace App\Services;

use App\Models\Personnel;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * WhatsApp Notification Service — Zavu (https://zavu.dev)
 *
 * Envoie des messages WhatsApp via l'API unifiée de Zavu.
 *
 * Configuration requise dans .env :
 *   ZAVU_API_KEY=your_api_key_here
 *   WHATSAPP_ENABLED=true
 *   WHATSAPP_DEFAULT_COUNTRY_CODE=226
 */
class WhatsAppService
{
    protected bool $enabled;
    protected string $defaultCountryCode;
    protected string $apiKey;

    const API_URL    = 'https://api.zavu.dev/v1/messages';
    const PORTAL_URL = 'https://portail-rh.com/';

    public function __construct()
    {
        $this->enabled            = config('services.whatsapp.enabled', false);
        $this->defaultCountryCode = config('services.whatsapp.default_country_code', '226');
        $this->apiKey             = config('services.zavu.api_key', '');
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
                    'to'      => $phone,
                    'channel' => 'whatsapp',
                    'text'    => $body,
                ]);

            if ($response->successful()) {
                Log::info('Zavu: message envoyé', ['to' => $phone]);
                return true;
            }

            Log::warning('Zavu: envoi échoué', [
                'to'       => $phone,
                'status'   => $response->status(),
                'body'     => $response->body(),
            ]);

            return false;

        } catch (\Exception $e) {
            Log::error('Zavu: exception', [
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
        $statut   = $approuve ? '✅ Approuvée' : '❌ Refusée';

        $lines   = ["Bonjour {$personnel->prenoms},", '', 'Votre demande de congé a été traitée.', ''];
        $lines[] = "*Période :* {$conge->date_debut->format('d/m/Y')} au {$conge->date_fin->format('d/m/Y')}";
        $lines[] = "*Durée :* {$conge->nombre_jours} jour(s)";
        $lines[] = "*Décision :* {$statut}";

        if (!$approuve && $conge->motif_refus) {
            $lines[] = '';
            $lines[] = "*Motif :* {$conge->motif_refus}";
        }

        return $this->sendToPersonnel($personnel, $this->buildMessage('Décision sur votre congé', $lines));
    }

    public function notifyAbsenceValidation($absence, Personnel $personnel): bool
    {
        $approuvee = $absence->statut === 'approuvee';
        $statut    = $approuvee ? '✅ Approuvée' : '❌ Refusée';
        $typeNom   = $absence->typeAbsence->nom ?? 'Absence';

        $lines   = ["Bonjour {$personnel->prenoms},", '', 'Votre déclaration d\'absence a été traitée.', ''];
        $lines[] = "*Type :* {$typeNom}";
        $lines[] = "*Date :* {$absence->date_absence->format('d/m/Y')}";
        $lines[] = "*Décision :* {$statut}";

        if (!$approuvee && $absence->motif_refus) {
            $lines[] = '';
            $lines[] = "*Motif :* {$absence->motif_refus}";
        }

        return $this->sendToPersonnel($personnel, $this->buildMessage('Décision sur votre absence', $lines));
    }

    public function notifyNewConge($conge, Personnel $adminPersonnel): bool
    {
        $employe = $conge->personnel->nom . ' ' . $conge->personnel->prenoms;
        $typeNom = $conge->typeConge->nom ?? 'Congé';

        $lines = [
            "Bonjour {$adminPersonnel->prenoms},",
            '',
            'Une nouvelle demande de congé attend votre validation.',
            '',
            "*Employé :* {$employe}",
            "*Type :* {$typeNom}",
            "*Période :* {$conge->date_debut->format('d/m/Y')} au {$conge->date_fin->format('d/m/Y')}",
            "*Durée :* {$conge->nombre_jours} jour(s)",
        ];

        return $this->sendToPersonnel($adminPersonnel, $this->buildMessage('Demande à traiter', $lines));
    }

    public function notifyNewAbsence($absence, Personnel $adminPersonnel): bool
    {
        $employe = $absence->personnel->nom . ' ' . $absence->personnel->prenoms;
        $typeNom = $absence->typeAbsence->nom ?? 'Absence';

        $lines = [
            "Bonjour {$adminPersonnel->prenoms},",
            '',
            'Une nouvelle absence attend votre validation.',
            '',
            "*Employé :* {$employe}",
            "*Type :* {$typeNom}",
            "*Date :* {$absence->date_absence->format('d/m/Y')}",
        ];

        return $this->sendToPersonnel($adminPersonnel, $this->buildMessage('Absence à traiter', $lines));
    }

    public function notifyBulletinPaie($bulletin, Personnel $personnel): bool
    {
        $moisNom = $bulletin->mois_nom ?? $bulletin->mois;

        $lines = [
            "Bonjour {$personnel->prenoms},",
            '',
            'Votre bulletin de paie est disponible sur le portail.',
            '',
            "*Période :* {$moisNom} {$bulletin->annee}",
            '',
            'Rubrique : Mon Espace → Bulletins de paie',
        ];

        return $this->sendToPersonnel($personnel, $this->buildMessage('Bulletin de paie disponible', $lines));
    }

    public function notifyDocumentAgent($document, Personnel $personnel): bool
    {
        $titre     = $document->titre ?? $document->nom_original;
        $categorie = $document->categorie->nom ?? 'Document';

        $lines = [
            "Bonjour {$personnel->prenoms},",
            '',
            'Un nouveau document a été ajouté à votre dossier personnel.',
            '',
            "*Document :* {$titre}",
            "*Catégorie :* {$categorie}",
        ];

        return $this->sendToPersonnel($personnel, $this->buildMessage('Nouveau document', $lines));
    }

    public function notifyAccountCreation($user, Personnel $personnel, string $temporaryPassword): bool
    {
        $lines = [
            "Bonjour {$personnel->prenoms},",
            '',
            'Votre accès au Portail RH+ a été créé.',
            '',
            "*Email :* {$user->email}",
            "*Mot de passe temporaire :* {$temporaryPassword}",
            '',
            'Merci de le modifier dès votre première connexion.',
        ];

        return $this->sendToPersonnel($personnel, $this->buildMessage('Création de votre compte', $lines));
    }

    public function notifyCustom(Personnel $personnel, string $title, string $content): bool
    {
        return $this->sendToPersonnel($personnel, $this->buildMessage($title, [$content]));
    }

    /**
     * Assemble un message dans un gabarit cohérent : en-tête, corps, pied de page.
     *
     * @param string[] $lines
     */
    protected function buildMessage(string $title, array $lines): string
    {
        $header = "*Portail RH+*\n{$title}\n" . str_repeat('─', 28);
        $footer = "\n\n" . self::PORTAL_URL . "\nService des Ressources Humaines";

        return $header . "\n\n" . implode("\n", $lines) . $footer;
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

    /**
     * Zavu attend les numéros au format E.164 (ex: +22670123456).
     */
    protected function formatPhone(string $phone): string
    {
        return '+' . preg_replace('/[^0-9]/', '', $phone);
    }
}
