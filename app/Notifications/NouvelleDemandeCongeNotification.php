<?php

namespace App\Notifications;

use App\Channels\WhatsAppChannel;
use App\Models\Conge;
use App\Services\WhatsAppService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class NouvelleDemandeCongeNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected Conge $conge;

    public function __construct(Conge $conge)
    {
        $this->conge = $conge;
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
        $employe = $this->conge->personnel->nom . ' ' . $this->conge->personnel->prenoms;
        $typeNom = $this->conge->typeConge->nom;

        return [
            'type' => 'nouvelle_demande_conge',
            'conge_id' => $this->conge->id,
            'employe' => $employe,
            'type_conge' => $typeNom,
            'date_debut' => $this->conge->date_debut->format('d/m/Y'),
            'date_fin' => $this->conge->date_fin->format('d/m/Y'),
            'nombre_jours' => $this->conge->nombre_jours,
            'message' => $employe . ' a soumis une demande de ' . $typeNom
                . ' du ' . $this->conge->date_debut->format('d/m/Y')
                . ' au ' . $this->conge->date_fin->format('d/m/Y')
                . ' (' . $this->conge->nombre_jours . ' jours)',
        ];
    }

    public function toWhatsApp(object $notifiable): void
    {
        if (!$notifiable->personnel) {
            return;
        }

        $whatsapp = app(WhatsAppService::class);
        $whatsapp->notifyNewConge($this->conge, $notifiable->personnel);
    }
}
