<?php

namespace App\Notifications;

use App\Models\Requete;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class RequeteFermeeNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public readonly Requete $requete) {}

    public function via(object $notifiable): array
    {
        return ['database', \App\Channels\FcmChannel::class];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type'       => 'requete_fermee',
            'requete_id' => $this->requete->id,
            'sujet'      => $this->requete->sujet,
            'message'    => 'Votre requête « ' . $this->requete->sujet . ' » a été fermée.',
        ];
    }
}
