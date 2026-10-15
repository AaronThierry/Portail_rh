<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

/**
 * Notification générique pour les événements de sécurité du compte
 * (activation/désactivation du 2FA, changement de mot de passe...).
 */
class SecuriteCompteNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public readonly string $type,
        public readonly string $message,
    ) {}

    public function via(object $notifiable): array
    {
        return ['database', \App\Channels\FcmChannel::class];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => $this->type,
            'message' => $this->message,
        ];
    }
}
