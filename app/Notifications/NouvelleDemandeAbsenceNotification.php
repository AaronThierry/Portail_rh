<?php

namespace App\Notifications;

use App\Channels\WhatsAppChannel;
use App\Models\Absence;
use App\Services\WhatsAppService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class NouvelleDemandeAbsenceNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected Absence $absence;

    public function __construct(Absence $absence)
    {
        $this->absence = $absence;
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
        $employe = $this->absence->personnel->nom . ' ' . $this->absence->personnel->prenoms;
        $typeNom = $this->absence->typeAbsence->nom ?? 'Absence';

        return [
            'type' => 'nouvelle_demande_absence',
            'absence_id' => $this->absence->id,
            'employe' => $employe,
            'type_absence' => $typeNom,
            'date_absence' => $this->absence->date_absence->format('d/m/Y'),
            'message' => $employe . ' a soumis une declaration d\'absence (' . $typeNom . ') pour le ' . $this->absence->date_absence->format('d/m/Y'),
        ];
    }

    public function toWhatsApp(object $notifiable): void
    {
        if (!$notifiable->personnel) {
            return;
        }

        $whatsapp = app(WhatsAppService::class);
        $whatsapp->notifyNewAbsence($this->absence, $notifiable->personnel);
    }
}
