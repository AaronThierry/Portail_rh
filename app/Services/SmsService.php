<?php

namespace App\Services;

use App\Models\Personnel;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * SMS Notification Service — deux fournisseurs possibles, choisis via
 * SMS_PROVIDER dans .env ("zavu" par défaut, ou "orange") :
 *
 * - Zavu (https://zavu.dev) : crédit prépayé sans expiration, même compte/clé
 *   que WhatsAppService (api.zavu.dev/v1/messages), channel "sms".
 * - Orange SMS Burkina Faso (2.0, https://developer.orange.com/apis/sms-bf) :
 *   opérateur local, moins cher, mais forfaits prépayés à validité limitée
 *   (en attente d'un accord postpaid avec Orange).
 *
 * Configuration requise dans .env :
 *   SMS_ENABLED=true
 *   SMS_PROVIDER=zavu   (ou "orange")
 *   SMS_DEFAULT_COUNTRY_CODE=226
 *   ZAVU_API_KEY=...                         (fournisseur zavu)
 *   ORANGE_SMS_CLIENT_ID=...                 (fournisseur orange)
 *   ORANGE_SMS_CLIENT_SECRET=...
 *   ORANGE_SMS_SENDER_ADDRESS=+226XXXXXXXX
 *   ORANGE_SMS_SENDER_NAME=PortailRH
 */
class SmsService
{
    const ZAVU_API_URL = 'https://api.zavu.dev/v1/messages';
    const ORANGE_TOKEN_URL = 'https://api.orange.com/oauth/v3/token';
    const ORANGE_API_URL = 'https://api.orange.com/smsmessaging/v1/outbound';

    protected bool $enabled;
    protected string $provider;
    protected string $defaultCountryCode;

    protected string $zavuApiKey;

    protected string $orangeClientId;
    protected string $orangeClientSecret;
    protected string $orangeSenderAddress;
    protected string $orangeSenderName;

    public function __construct()
    {
        $this->enabled = config('services.sms.enabled', false);
        $this->provider = config('services.sms.provider', 'zavu');
        $this->defaultCountryCode = config('services.sms.default_country_code', '226');

        $this->zavuApiKey = config('services.zavu.api_key', '');

        $this->orangeClientId = config('services.orange_sms.client_id', '');
        $this->orangeClientSecret = config('services.orange_sms.client_secret', '');
        $this->orangeSenderAddress = config('services.orange_sms.sender_address', '');
        $this->orangeSenderName = config('services.orange_sms.sender_name', 'PortailRH');
    }

    public function isEnabled(): bool
    {
        if (!$this->enabled) {
            return false;
        }

        return $this->provider === 'orange'
            ? (!empty($this->orangeClientId) && !empty($this->orangeClientSecret) && !empty($this->orangeSenderAddress))
            : !empty($this->zavuApiKey);
    }

    public function sendMessage(string $phone, string $body): bool
    {
        if (!$this->isEnabled()) {
            Log::info('SMS désactivé — message non envoyé', ['to' => $phone]);
            return false;
        }

        return $this->provider === 'orange'
            ? $this->sendViaOrange($phone, $body)
            : $this->sendViaZavu($phone, $body);
    }

    public function sendToPersonnel(Personnel $personnel, string $body): bool
    {
        if (!$personnel->telephone) {
            return false;
        }

        $code = $personnel->telephone_code_pays
            ? preg_replace('/[^0-9]/', '', $personnel->telephone_code_pays)
            : $this->defaultCountryCode;

        $phone = $code . preg_replace('/[^0-9]/', '', $personnel->telephone);

        return $this->sendMessage($phone, $body);
    }

    // ─────────────────────────────────────────────────────────────────────
    // Zavu
    // ─────────────────────────────────────────────────────────────────────

    protected function sendViaZavu(string $phone, string $body): bool
    {
        try {
            $response = Http::withToken($this->zavuApiKey)
                ->post(self::ZAVU_API_URL, [
                    'to' => '+' . preg_replace('/[^0-9]/', '', $phone),
                    'channel' => 'sms',
                    'text' => $body,
                ]);

            if (!$response->successful()) {
                Log::warning('Échec envoi SMS (Zavu)', [
                    'to' => $phone,
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
                return false;
            }

            return true;
        } catch (\Throwable $e) {
            Log::error('Erreur envoi SMS (Zavu)', ['to' => $phone, 'error' => $e->getMessage()]);
            return false;
        }
    }

    // ─────────────────────────────────────────────────────────────────────
    // Orange SMS Burkina Faso
    // ─────────────────────────────────────────────────────────────────────

    protected function sendViaOrange(string $phone, string $body): bool
    {
        $token = $this->getOrangeAccessToken();
        if (!$token) {
            return false;
        }

        $to = $this->formatOrangePhone($phone);
        $sender = $this->formatOrangePhone($this->orangeSenderAddress);

        try {
            $response = Http::withToken($token)
                ->acceptJson()
                ->post(self::ORANGE_API_URL . '/' . rawurlencode($sender) . '/requests', [
                    'outboundSMSMessageRequest' => [
                        'address' => $to,
                        'senderAddress' => $sender,
                        'senderName' => $this->orangeSenderName,
                        'outboundSMSTextMessage' => [
                            'message' => $body,
                        ],
                    ],
                ]);

            if (!$response->successful()) {
                Log::warning('Échec envoi SMS (Orange)', [
                    'to' => $phone,
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
                return false;
            }

            return true;
        } catch (\Throwable $e) {
            Log::error('Erreur envoi SMS (Orange)', ['to' => $phone, 'error' => $e->getMessage()]);
            return false;
        }
    }

    protected function getOrangeAccessToken(): ?string
    {
        return Cache::remember('orange_sms_access_token', 3300, function () {
            try {
                $response = Http::asForm()
                    ->withBasicAuth($this->orangeClientId, $this->orangeClientSecret)
                    ->post(self::ORANGE_TOKEN_URL, ['grant_type' => 'client_credentials']);

                if (!$response->successful()) {
                    Log::warning('Orange SMS : échec récupération du token', [
                        'status' => $response->status(),
                        'body' => $response->body(),
                    ]);
                    return null;
                }

                return $response->json('access_token');
            } catch (\Throwable $e) {
                Log::error('Orange SMS : erreur récupération du token', ['error' => $e->getMessage()]);
                return null;
            }
        });
    }

    protected function formatOrangePhone(string $phone): string
    {
        return 'tel:+' . preg_replace('/[^0-9]/', '', $phone);
    }
}
