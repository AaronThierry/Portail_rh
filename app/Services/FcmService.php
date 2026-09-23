<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Notifications push (Firebase Cloud Messaging — HTTP v1 API)
 *
 * Implémenté sans dépendance Composer supplémentaire (JWT signé "à la main"
 * via openssl, déjà inclus dans PHP) : uniquement le fichier de compte de
 * service Firebase, à placer hors du dépôt.
 *
 * Configuration requise dans .env :
 *   FCM_PROJECT_ID=mon-projet-firebase
 *   FCM_CREDENTIALS_PATH=/chemin/vers/firebase-service-account.json
 *   (par défaut : storage/app/firebase-service-account.json)
 */
class FcmService
{
    public function isEnabled(): bool
    {
        $projectId = config('services.fcm.project_id');
        $credentials = config('services.fcm.credentials');

        return (bool) $projectId && $credentials && file_exists($credentials);
    }

    protected function getAccessToken(): ?string
    {
        return Cache::remember('fcm_access_token', 3300, function () {
            $credentialsPath = config('services.fcm.credentials');
            $credentials = json_decode(file_get_contents($credentialsPath), true);

            if (!$credentials || empty($credentials['private_key']) || empty($credentials['client_email'])) {
                Log::warning('FCM: fichier de compte de service invalide.');
                return null;
            }

            $now = time();
            $header = $this->base64UrlEncode(json_encode(['alg' => 'RS256', 'typ' => 'JWT']));
            $claims = $this->base64UrlEncode(json_encode([
                'iss' => $credentials['client_email'],
                'scope' => 'https://www.googleapis.com/auth/firebase.messaging',
                'aud' => 'https://oauth2.googleapis.com/token',
                'iat' => $now,
                'exp' => $now + 3600,
            ]));

            $unsigned = $header . '.' . $claims;
            $signed = openssl_sign($unsigned, $signature, $credentials['private_key'], 'sha256WithRSAEncryption');

            if (!$signed) {
                Log::warning('FCM: échec de la signature du JWT.');
                return null;
            }

            $jwt = $unsigned . '.' . $this->base64UrlEncode($signature);

            $response = Http::asForm()->post('https://oauth2.googleapis.com/token', [
                'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
                'assertion' => $jwt,
            ]);

            if (!$response->successful()) {
                Log::warning('FCM: échec de l\'échange du jeton OAuth2', ['body' => $response->body()]);
                return null;
            }

            return $response->json('access_token');
        });
    }

    protected function base64UrlEncode(string $data): string
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    /**
     * Envoie une notification push à un jeton d'appareil précis.
     * Retourne false (et supprime le jeton s'il est mort) en cas d'échec.
     */
    public function sendToToken(string $token, string $title, string $body, array $data = []): bool
    {
        if (!$this->isEnabled()) {
            return false;
        }

        $accessToken = $this->getAccessToken();
        if (!$accessToken) {
            return false;
        }

        $projectId = config('services.fcm.project_id');

        $response = Http::withToken($accessToken)
            ->post("https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send", [
                'message' => [
                    'token' => $token,
                    'notification' => [
                        'title' => $title,
                        'body' => $body,
                    ],
                    'data' => array_map('strval', $data),
                    'android' => [
                        'notification' => ['sound' => 'default'],
                    ],
                ],
            ]);

        if ($response->successful()) {
            return true;
        }

        $errorBody = $response->body();
        if (str_contains($errorBody, 'UNREGISTERED') || str_contains($errorBody, 'NOT_FOUND') || str_contains($errorBody, 'INVALID_ARGUMENT')) {
            // Jeton mort ou invalide (app désinstallée, etc.) — on le retire.
            \App\Models\DeviceToken::where('token', $token)->delete();
        } else {
            Log::warning('FCM: échec de l\'envoi', ['status' => $response->status(), 'body' => $errorBody]);
        }

        return false;
    }

    /**
     * Envoie une notification push à tous les appareils enregistrés d'un utilisateur.
     */
    public function sendToUser(object $user, string $title, string $body, array $data = []): void
    {
        if (!$this->isEnabled() || !method_exists($user, 'deviceTokens')) {
            return;
        }

        foreach ($user->deviceTokens as $deviceToken) {
            $this->sendToToken($deviceToken->token, $title, $body, $data);
        }
    }
}
