<?php

namespace App\Services;

use App\Models\Personnel;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * SMS Notification Service — Orange SMS Burkina Faso (2.0)
 * https://developer.orange.com/apis/sms-bf
 *
 * Authentification OAuth2 client_credentials (le token est mis en cache
 * ~55 min, sa durée de vie réelle étant d'environ 1h), puis POST vers
 * /smsmessaging/v1/outbound/{senderAddress}/requests.
 *
 * Configuration requise dans .env :
 *   SMS_ENABLED=true
 *   SMS_DEFAULT_COUNTRY_CODE=226
 *   ORANGE_SMS_CLIENT_ID=...
 *   ORANGE_SMS_CLIENT_SECRET=...
 *   ORANGE_SMS_SENDER_ADDRESS=+226XXXXXXXX   (numéro assigné par Orange à l'application)
 *   ORANGE_SMS_SENDER_NAME=PortailRH
 */
class SmsService
{
    const TOKEN_URL = 'https://api.orange.com/oauth/v3/token';
    const API_URL = 'https://api.orange.com/smsmessaging/v1/outbound';

    protected bool $enabled;
    protected string $defaultCountryCode;
    protected string $clientId;
    protected string $clientSecret;
    protected string $senderAddress;
    protected string $senderName;

    public function __construct()
    {
        $this->enabled = config('services.sms.enabled', false);
        $this->defaultCountryCode = config('services.sms.default_country_code', '226');
        $this->clientId = config('services.orange_sms.client_id', '');
        $this->clientSecret = config('services.orange_sms.client_secret', '');
        $this->senderAddress = config('services.orange_sms.sender_address', '');
        $this->senderName = config('services.orange_sms.sender_name', 'PortailRH');
    }

    public function isEnabled(): bool
    {
        return $this->enabled
            && !empty($this->clientId)
            && !empty($this->clientSecret)
            && !empty($this->senderAddress);
    }

    public function sendMessage(string $phone, string $body): bool
    {
        if (!$this->isEnabled()) {
            Log::info('SMS désactivé — message non envoyé', ['to' => $phone]);
            return false;
        }

        $token = $this->getAccessToken();
        if (!$token) {
            return false;
        }

        $to = $this->formatPhone($phone);
        $sender = $this->formatPhone($this->senderAddress);

        try {
            $response = Http::withToken($token)
                ->acceptJson()
                ->post(self::API_URL . '/' . rawurlencode($sender) . '/requests', [
                    'outboundSMSMessageRequest' => [
                        'address' => $to,
                        'senderAddress' => $sender,
                        'senderName' => $this->senderName,
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

    protected function getAccessToken(): ?string
    {
        return Cache::remember('orange_sms_access_token', 3300, function () {
            try {
                $response = Http::asForm()
                    ->withBasicAuth($this->clientId, $this->clientSecret)
                    ->post(self::TOKEN_URL, ['grant_type' => 'client_credentials']);

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

    protected function formatPhone(string $phone): string
    {
        return 'tel:+' . preg_replace('/[^0-9]/', '', $phone);
    }
}
