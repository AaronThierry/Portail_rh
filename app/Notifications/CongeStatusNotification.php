<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use App\Services\WhatsAppService;

/**
 * Notification de changement de statut de congé
 *
 * Envoie une notification WhatsApp lorsqu'un congé est approuvé ou refusé
 */
class CongeStatusNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $conge;
    protected $status;

    /**
     * Create a new notification instance.
     */
    public function __construct($conge, string $status)
    {
        $this->conge = $conge;
        $this->status = $status;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        $channels = ['database'];

        // Ajouter WhatsApp seulement si le service est activé et numéro disponible
        try {
            $whatsapp = app(WhatsAppService::class);
            if ($whatsapp->isEnabled() && $notifiable->personnel && $notifiable->personnel->telephone) {
                $channels[] = 'whatsapp';
            }
        } catch (\Throwable $e) {
            // WhatsApp non configuré, on continue avec database uniquement
        }

        return $channels;
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'statut_conge',
            'conge_id' => $this->conge->id,
            'status' => $this->status,
            'type_conge' => $this->conge->typeConge->nom ?? 'Congé',
            'date_debut' => $this->conge->date_debut->format('d/m/Y'),
            'date_fin' => $this->conge->date_fin->format('d/m/Y'),
            'nombre_jours' => $this->conge->nombre_jours,
            'message' => $this->getMessage(),
        ];
    }

    /**
     * Envoyer la notification via WhatsApp
     *
     * @param object $notifiable
     * @return void
     */
    public function toWhatsApp(object $notifiable)
    {
        $whatsapp = app(WhatsAppService::class);

        if (!$whatsapp->isEnabled()) {
            return;
        }

        $phoneNumber = $notifiable->personnel->telephone_code_pays . $notifiable->personnel->telephone;

        $whatsapp->notifyCongeValidation($this->conge, $phoneNumber);
    }

    /**
     * Get the notification message
     *
     * @return string
     */
    protected function getMessage(): string
    {
        $statusText = $this->status === 'approuve' ? 'approuvée' : 'refusée';

        return "Votre demande de congé du {$this->conge->date_debut->format('d/m/Y')} "
            . "au {$this->conge->date_fin->format('d/m/Y')} a été {$statusText}.";
    }
}
