<?php

namespace App\Notifications;

use App\Channels\WhatsAppChannel;
use App\Models\Absence;
use App\Services\WhatsAppService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class AbsenceStatusNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected Absence $absence;
    protected string $status;

    public function __construct(Absence $absence, string $status)
    {
        $this->absence = $absence;
        $this->status = $status;
    }

    public function via(object $notifiable): array
    {
        $channels = ['database'];

        try {
            $whatsapp = app(WhatsAppService::class);
            if ($whatsapp->isEnabled() && $notifiable->personnel && $notifiable->personnel->callmebot_apikey) {
                $channels[] = WhatsAppChannel::class;
            }
        } catch (\Throwable $e) {
            // WhatsApp non configure
        }

        return $channels;
    }

    public function toArray(object $notifiable): array
    {
        $typeNom = $this->absence->typeAbsence->nom ?? 'Absence';
        $statusText = $this->status === 'approuvee' ? 'approuvee' : 'refusee';

        return [
            'type' => 'statut_absence',
            'absence_id' => $this->absence->id,
            'status' => $this->status,
            'type_absence' => $typeNom,
            'date_absence' => $this->absence->date_absence->format('d/m/Y'),
            'message' => 'Votre declaration d\'absence (' . $typeNom . ') du '
                . $this->absence->date_absence->format('d/m/Y') . ' a ete ' . $statusText . '.',
        ];
    }

    public function toWhatsApp(object $notifiable): void
    {
        if (!$notifiable->personnel) {
            return;
        }

        $whatsapp = app(WhatsAppService::class);
        $whatsapp->notifyAbsenceValidation($this->absence, $notifiable->personnel);
    }
}
