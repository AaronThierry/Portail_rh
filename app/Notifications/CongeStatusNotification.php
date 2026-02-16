<?php

namespace App\Notifications;

use App\Channels\WhatsAppChannel;
use App\Services\WhatsAppService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class CongeStatusNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $conge;
    protected $status;

    public function __construct($conge, string $status)
    {
        $this->conge = $conge;
        $this->status = $status;
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
            'type' => 'statut_conge',
            'conge_id' => $this->conge->id,
            'status' => $this->status,
            'type_conge' => $this->conge->typeConge->nom ?? 'Conge',
            'date_debut' => $this->conge->date_debut->format('d/m/Y'),
            'date_fin' => $this->conge->date_fin->format('d/m/Y'),
            'nombre_jours' => $this->conge->nombre_jours,
            'message' => $this->getMessage(),
        ];
    }

    public function toWhatsApp(object $notifiable): void
    {
        if (!$notifiable->personnel) {
            return;
        }

        $whatsapp = app(WhatsAppService::class);
        $whatsapp->notifyCongeValidation($this->conge, $notifiable->personnel);
    }

    protected function getMessage(): string
    {
        $statusText = $this->status === 'approuve' ? 'approuvee' : 'refusee';

        return "Votre demande de conge du {$this->conge->date_debut->format('d/m/Y')} "
            . "au {$this->conge->date_fin->format('d/m/Y')} a ete {$statusText}.";
    }
}
