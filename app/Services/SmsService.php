<?php

namespace App\Services;

use App\Models\Personnel;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * SMS Notification Service — Zavu (https://zavu.dev)
 *
 * Réutilise le même compte/API que WhatsAppService (api.zavu.dev/v1/messages,
 * même clé ZAVU_API_KEY), avec channel "sms" au lieu de "whatsapp".
 *
 * Configuration requise dans .env :
 *   ZAVU_API_KEY=your_api_key_here
 *   SMS_ENABLED=true
 *   SMS_DEFAULT_COUNTRY_CODE=226
 */
class SmsService
{
    protected bool $enabled;
    protected string $defaultCountryCode;
    protected string $apiKey;

    const API_URL = 'https://api.zavu.dev/v1/messages';

    public function __construct()
    {
        $this->enabled = config('services.sms.enabled', false);
        $this->defaultCountryCode = config('services.sms.default_country_code', '226');
        $this->apiKey = config('services.zavu.api_key', '');
    }

    public function isEnabled(): bool
    {
        return $this->enabled && !empty($this->apiKey);
    }

    public function sendMessage(string $phone, string $body): bool
    {
        if (!$this->isEnabled()) {
            Log::info('SMS désactivé — message non envoyé', ['to' => $phone]);
            return false;
        }

        try {
            $response = Http::withToken($this->apiKey)
                ->post(self::API_URL, [
                    'to' => $this->formatPhone($phone),
                    'channel' => 'sms',
                    'text' => $body,
                ]);

            if (!$response->successful()) {
                Log::warning('Échec envoi SMS', [
                    'to' => $phone,
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
                return false;
            }

            return true;
        } catch (\Throwable $e) {
            Log::error('Erreur envoi SMS', ['to' => $phone, 'error' => $e->getMessage()]);
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

    protected function formatPhone(string $phone): string
    {
        return '+' . preg_replace('/[^0-9]/', '', $phone);
    }
}
