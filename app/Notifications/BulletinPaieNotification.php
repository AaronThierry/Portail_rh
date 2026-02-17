<?php

namespace App\Notifications;

use App\Channels\WhatsAppChannel;
use App\Models\BulletinPaie;
use App\Services\WhatsAppService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class BulletinPaieNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected BulletinPaie $bulletin;

    public function __construct(BulletinPaie $bulletin)
    {
        $this->bulletin = $bulletin;
    }

    public function via(object $notifiable): array
    {
        $channels = ['database'];

        try {
            $whatsapp = app(WhatsAppService::class);
            if ($whatsapp->isEnabled() && $notifiable->personnel && $notifiable->personnel->telephone) {
                $channels[] = WhatsAppChannel::class;
            }
        } catch (\Throwable $e) {
            // WhatsApp non configure
        }

        return $channels;
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'bulletin_paie',
            'bulletin_id' => $this->bulletin->id,
            'mois' => $this->bulletin->mois_nom,
            'annee' => $this->bulletin->annee,
            'message' => 'Votre bulletin de paie de ' . $this->bulletin->mois_nom . ' ' . $this->bulletin->annee . ' est disponible.',
        ];
    }

    public function toWhatsApp(object $notifiable): void
    {
        if (!$notifiable->personnel) {
            return;
        }

        $whatsapp = app(WhatsAppService::class);
        $whatsapp->notifyBulletinPaie($this->bulletin, $notifiable->personnel);
    }
}
