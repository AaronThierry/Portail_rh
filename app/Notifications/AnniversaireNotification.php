<?php

namespace App\Notifications;

use App\Models\Personnel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class AnniversaireNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected Personnel $personnel;

    public function __construct(Personnel $personnel)
    {
        $this->personnel = $personnel;
    }

    public function via(object $notifiable): array
    {
        return ['database', \App\Channels\FcmChannel::class];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'anniversaire',
            'message' => $this->getMessage(),
        ];
    }

    protected function getMessage(): string
    {
        $prenom = $this->personnel->prenoms ?: $this->personnel->nom;

        return "🎉 Joyeux anniversaire {$prenom} ! Toute l'équipe de Portail RH+ vous souhaite une excellente journée.";
    }
}
