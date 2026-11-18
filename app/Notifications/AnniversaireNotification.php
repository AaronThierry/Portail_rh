<?php

namespace App\Notifications;

use App\Models\Personnel;
use App\Services\SmsService;
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
        $channels = ['database', \App\Channels\FcmChannel::class];

        try {
            $sms = app(SmsService::class);
            if ($sms->isEnabled() && $this->personnel->telephone) {
                $channels[] = \App\Channels\SmsChannel::class;
            }
        } catch (\Throwable $e) {
            // SMS non configuré
        }

        return $channels;
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'anniversaire',
            'message' => $this->getMessage(),
        ];
    }

    public function toSms(object $notifiable): void
    {
        app(SmsService::class)->sendToPersonnel($this->personnel, $this->getSmsMessage());
    }

    protected function getMessage(): string
    {
        $prenom = $this->personnel->prenoms ?: $this->personnel->nom;
        $entreprise = $this->personnel->entreprise->nom ?? null;

        $equipe = $entreprise ? "Toute l'équipe {$entreprise}" : "Toute l'équipe de Portail RH+";

        return "🎉 Joyeux anniversaire {$prenom} ! {$equipe} vous souhaite une merveilleuse journée, pleine de bonheur et de réussite.";
    }

    protected function getSmsMessage(): string
    {
        $prenom = $this->personnel->prenoms ?: $this->personnel->nom;
        $entreprise = $this->personnel->entreprise->nom ?? null;

        $equipe = $entreprise ? "Toute l'equipe {$entreprise}" : "Toute l'equipe Portail RH+";

        return "Joyeux anniversaire {$prenom} ! {$equipe} vous souhaite une merveilleuse journee, pleine de bonheur et de reussite.";
    }
}
