<?php

namespace App\Notifications;

use App\Models\Requete;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class ReponseRequeteNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public readonly Requete $requete) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type'        => 'reponse_requete',
            'requete_id'  => $this->requete->id,
            'sujet'       => $this->requete->sujet,
            'message'     => 'Votre requête a reçu une réponse : ' . \Str::limit($this->requete->reponse, 80),
        ];
    }
}
