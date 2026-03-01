<?php

namespace App\Services;

use App\Models\Personnel;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

/**
 * WhatsApp Cloud API Service (Meta officiel)
 *
 * Utilise l'API Graph de Meta pour envoyer des notifications WhatsApp
 * via des templates approuvés (actif 24h/24, sans téléphone branché).
 *
 * Configuration requise dans .env :
 *   WHATSAPP_ENABLED=true
 *   WHATSAPP_TOKEN=<system_user_access_token>
 *   WHATSAPP_PHONE_ID=<phone_number_id>
 *   WHATSAPP_DEFAULT_COUNTRY_CODE=226
 */
class WhatsAppService
{
    protected bool $enabled;
    protected string $token;
    protected string $phoneId;
    protected string $defaultCountryCode;
    protected string $apiVersion = 'v19.0';

    public function __construct()
    {
        $this->enabled            = config('services.whatsapp.enabled', false);
        $this->token              = config('services.whatsapp.token', '');
        $this->phoneId            = config('services.whatsapp.phone_id', '');
        $this->defaultCountryCode = config('services.whatsapp.default_country_code', '226');
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Méthodes publiques d'envoi
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * Envoyer un message via template approuvé (pour notifications proactives)
     *
     * @param string $phone     Numéro complet avec indicatif (ex: 22607123456)
     * @param string $template  Nom du template dans Meta Business Manager
     * @param array  $vars      Variables du corps du template ({{1}}, {{2}}, ...)
     * @param string $lang      Code langue du template (ex: fr, fr_FR)
     */
    public function sendTemplate(string $phone, string $template, array $vars = [], string $lang = 'fr'): bool
    {
        $payload = [
            'messaging_product' => 'whatsapp',
            'to'                => $this->formatPhone($phone),
            'type'              => 'template',
            'template'          => [
                'name'     => $template,
                'language' => ['code' => $lang],
            ],
        ];

        if (!empty($vars)) {
            $payload['template']['components'] = [
                [
                    'type'       => 'body',
                    'parameters' => array_map(fn($v) => ['type' => 'text', 'text' => (string) $v], $vars),
                ],
            ];
        }

        return $this->send($payload);
    }

    /**
     * Envoyer un message texte libre
     * Fonctionne uniquement dans la fenêtre de 24h après un message de l'utilisateur.
     * À utiliser pour les tests ou les réponses.
     */
    public function sendText(string $phone, string $message): bool
    {
        return $this->send([
            'messaging_product' => 'whatsapp',
            'to'                => $this->formatPhone($phone),
            'type'              => 'text',
            'text'              => ['body' => $message, 'preview_url' => false],
        ]);
    }

    /**
     * Envoyer un message texte à un personnel (via son profil)
     */
    public function sendToPersonnel(Personnel $personnel, string $message): bool
    {
        if (!$personnel->telephone) {
            return false;
        }

        return $this->sendText($this->buildPhone($personnel), $message);
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Notifications métier (toutes via template)
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * Notification statut congé (approuvé ou refusé)
     */
    public function notifyCongeValidation($conge, Personnel $personnel): bool
    {
        $statut = $conge->statut === 'approuve' ? 'approuvée ✅' : 'refusée ❌';
        $detail = "Du {$conge->date_debut->format('d/m/Y')} au {$conge->date_fin->format('d/m/Y')} "
                . "({$conge->nombre_jours} jour(s)) — statut : {$statut}";

        if ($conge->statut === 'refuse' && $conge->motif_refus) {
            $detail .= "\nMotif : {$conge->motif_refus}";
        }

        return $this->sendTemplate(
            $this->buildPhone($personnel),
            config('services.whatsapp.templates.conge', 'notification_rh'),
            [$personnel->prenoms, $detail]
        );
    }

    /**
     * Notification statut absence (approuvée ou refusée)
     */
    public function notifyAbsenceValidation($absence, Personnel $personnel): bool
    {
        $statut  = $absence->statut === 'approuvee' ? 'approuvée ✅' : 'refusée ❌';
        $typeNom = $absence->typeAbsence->nom ?? 'Absence';
        $detail  = "Absence ({$typeNom}) du {$absence->date_absence->format('d/m/Y')} — statut : {$statut}";

        if ($absence->statut === 'refusee' && $absence->motif_refus) {
            $detail .= "\nMotif : {$absence->motif_refus}";
        }

        return $this->sendTemplate(
            $this->buildPhone($personnel),
            config('services.whatsapp.templates.absence', 'notification_rh'),
            [$personnel->prenoms, $detail]
        );
    }

    /**
     * Notification nouvelle demande de congé (pour les admins)
     */
    public function notifyNewConge($conge, Personnel $adminPersonnel): bool
    {
        $employe = $conge->personnel->nom . ' ' . $conge->personnel->prenoms;
        $typeNom = $conge->typeConge->nom ?? 'Congé';
        $detail  = "Nouvelle demande de {$typeNom} de {$employe} — "
                 . "du {$conge->date_debut->format('d/m/Y')} au {$conge->date_fin->format('d/m/Y')} "
                 . "({$conge->nombre_jours} jours). Connectez-vous au portail pour traiter.";

        return $this->sendTemplate(
            $this->buildPhone($adminPersonnel),
            config('services.whatsapp.templates.conge', 'notification_rh'),
            [$adminPersonnel->prenoms, $detail]
        );
    }

    /**
     * Notification nouvelle absence déclarée (pour les admins)
     */
    public function notifyNewAbsence($absence, Personnel $adminPersonnel): bool
    {
        $employe = $absence->personnel->nom . ' ' . $absence->personnel->prenoms;
        $typeNom = $absence->typeAbsence->nom ?? 'Absence';
        $detail  = "Nouvelle absence déclarée par {$employe} ({$typeNom}) "
                 . "le {$absence->date_absence->format('d/m/Y')}. Connectez-vous au portail.";

        return $this->sendTemplate(
            $this->buildPhone($adminPersonnel),
            config('services.whatsapp.templates.absence', 'notification_rh'),
            [$adminPersonnel->prenoms, $detail]
        );
    }

    /**
     * Notification bulletin de paie disponible
     */
    public function notifyBulletinPaie($bulletin, Personnel $personnel): bool
    {
        $moisNom = $bulletin->mois_nom ?? $bulletin->mois;
        $detail  = "Votre bulletin de paie de {$moisNom} {$bulletin->annee} est disponible. "
                 . "Connectez-vous sur le portail RH+ pour le consulter et le télécharger.";

        return $this->sendTemplate(
            $this->buildPhone($personnel),
            config('services.whatsapp.templates.bulletin', 'notification_rh'),
            [$personnel->prenoms, $detail]
        );
    }

    /**
     * Notification nouveau document dans le dossier agent
     */
    public function notifyDocumentAgent($document, Personnel $personnel): bool
    {
        $titre     = $document->titre ?? $document->nom_original;
        $categorie = $document->categorie->nom ?? 'Document';
        $detail    = "Un nouveau document a été ajouté à votre dossier :\n"
                   . "• {$titre} ({$categorie})\n"
                   . "Connectez-vous sur le portail RH+ pour le consulter.";

        return $this->sendTemplate(
            $this->buildPhone($personnel),
            config('services.whatsapp.templates.document', 'notification_rh'),
            [$personnel->prenoms, $detail]
        );
    }

    /**
     * Notification de création de compte
     */
    public function notifyAccountCreation($user, Personnel $personnel, string $temporaryPassword): bool
    {
        $detail = "Votre compte Portail RH+ a été créé.\n"
                . "Email : {$user->email}\n"
                . "Mot de passe temporaire : {$temporaryPassword}\n"
                . "Changez votre mot de passe à la première connexion : " . config('app.url');

        return $this->sendTemplate(
            $this->buildPhone($personnel),
            config('services.whatsapp.templates.compte', 'notification_rh'),
            [$personnel->prenoms, $detail]
        );
    }

    /**
     * Notification personnalisée
     */
    public function notifyCustom(Personnel $personnel, string $title, string $content): bool
    {
        return $this->sendTemplate(
            $this->buildPhone($personnel),
            config('services.whatsapp.templates.custom', 'notification_rh'),
            [$personnel->prenoms, "{$title}\n{$content}"]
        );
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
            $success = $this->sendToPersonnel($personnel, $message);
            $success ? $results['sent']++ : $results['failed']++;
            usleep(300_000); // 300 ms entre chaque envoi (rate limit)
        }

        $results['skipped'] = count($personnelIds) - $personnels->count();

        return $results;
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Utilitaires
    // ─────────────────────────────────────────────────────────────────────────

    public function isEnabled(): bool
    {
        return $this->enabled && !empty($this->token) && !empty($this->phoneId);
    }

    public function isValidPhoneNumber(string $phone): bool
    {
        $cleaned = preg_replace('/[^0-9]/', '', $phone);
        return strlen($cleaned) >= 8 && strlen($cleaned) <= 15;
    }

    /**
     * Construire le numéro complet pour un personnel
     */
    protected function buildPhone(Personnel $personnel): string
    {
        $code = $personnel->telephone_code_pays
            ? preg_replace('/[^0-9]/', '', $personnel->telephone_code_pays)
            : $this->defaultCountryCode;

        return $code . preg_replace('/[^0-9]/', '', $personnel->telephone);
    }

    /**
     * Nettoyer un numéro de téléphone (chiffres uniquement)
     * Format attendu par Meta : indicatif + numéro sans le 0 initial (ex: 22607123456)
     */
    protected function formatPhone(string $phone): string
    {
        return preg_replace('/[^0-9]/', '', $phone);
    }

    /**
     * Appel HTTP vers l'API Graph de Meta
     */
    protected function send(array $payload): bool
    {
        if (!$this->isEnabled()) {
            Log::info('WhatsApp désactivé — message non envoyé', ['to' => $payload['to'] ?? '']);
            return false;
        }

        try {
            $url = "https://graph.facebook.com/{$this->apiVersion}/{$this->phoneId}/messages";

            $response = Http::timeout(15)
                ->withToken($this->token)
                ->acceptJson()
                ->post($url, $payload);

            if ($response->successful()) {
                Log::info('WhatsApp envoyé avec succès', [
                    'to'       => $payload['to'] ?? '',
                    'type'     => $payload['type'] ?? '',
                    'template' => $payload['template']['name'] ?? null,
                    'wamid'    => $response->json('messages.0.id'),
                ]);
                return true;
            }

            $error = $response->json('error');
            Log::error('WhatsApp: erreur API Meta', [
                'to'     => $payload['to'] ?? '',
                'status' => $response->status(),
                'code'   => $error['code'] ?? null,
                'msg'    => $error['message'] ?? $response->body(),
            ]);

            return false;

        } catch (Exception $e) {
            Log::error('WhatsApp: exception lors de l\'envoi', [
                'to'    => $payload['to'] ?? '',
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }
}
