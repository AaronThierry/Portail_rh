<?php

namespace App\Services;

use App\Models\WebPushSubscription;
use Illuminate\Support\Facades\Log;
use Minishlink\WebPush\WebPush;
use Minishlink\WebPush\Subscription;

/**
 * Notifications push via le protocole Web Push standard (VAPID).
 *
 * Contrairement à FcmService (app mobile Capacitor), ce canal s'adresse aux
 * navigateurs — en particulier Safari sur iPhone, qui ne supporte les push
 * que pour une PWA installée ("Ajouter à l'écran d'accueil"), pas pour un
 * onglet classique.
 *
 * Configuration requise dans .env : VAPID_PUBLIC_KEY, VAPID_PRIVATE_KEY,
 * VAPID_SUBJECT (générables via `npx web-push generate-vapid-keys`).
 */
class WebPushService
{
    public function isEnabled(): bool
    {
        return (bool) config('services.web_push.public_key') && (bool) config('services.web_push.private_key');
    }

    public function publicKey(): string
    {
        return (string) config('services.web_push.public_key');
    }

    protected function client(): WebPush
    {
        return new WebPush([
            'VAPID' => [
                'subject'    => config('services.web_push.subject'),
                'publicKey'  => config('services.web_push.public_key'),
                'privateKey' => config('services.web_push.private_key'),
            ],
        ]);
    }

    /**
     * Envoie une notification à un abonnement précis.
     * Retourne false (et supprime l'abonnement s'il est mort) en cas d'échec.
     */
    public function sendToSubscription(WebPushSubscription $sub, string $title, string $body, array $data = []): bool
    {
        if (!$this->isEnabled()) {
            return false;
        }

        $webPush = $this->client();
        $subscription = Subscription::create([
            'endpoint' => $sub->endpoint,
            'keys' => [
                'p256dh' => $sub->p256dh,
                'auth' => $sub->auth,
            ],
        ]);

        $payload = json_encode([
            'title' => $title,
            'body' => $body,
            'data' => $data,
        ]);

        $report = $webPush->sendOneNotification($subscription, $payload);

        if ($report->isSuccess()) {
            return true;
        }

        if ($report->isSubscriptionExpired()) {
            $sub->delete();
        } else {
            Log::warning('WebPush: échec de l\'envoi', ['reason' => $report->getReason()]);
        }

        return false;
    }

    /**
     * Envoie une notification push à tous les abonnements Web Push d'un utilisateur.
     */
    public function sendToUser(object $user, string $title, string $body, array $data = []): void
    {
        if (!$this->isEnabled() || !method_exists($user, 'webPushSubscriptions')) {
            return;
        }

        foreach ($user->webPushSubscriptions as $sub) {
            $this->sendToSubscription($sub, $title, $body, $data);
        }
    }
}
