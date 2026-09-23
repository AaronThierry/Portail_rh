<?php

namespace App\Channels;

use App\Services\FcmService;
use Illuminate\Notifications\Notification;

class FcmChannel
{
    protected FcmService $fcm;

    /** Titre affiché dans la notification push, selon le type déjà utilisé par toArray(). */
    protected static array $titles = [
        'statut_conge' => 'Congé',
        'statut_absence' => 'Absence',
        'bulletin_paie' => 'Bulletin de paie',
        'nouvelle_demande_conge' => 'Nouvelle demande de congé',
        'nouvelle_demande_absence' => 'Nouvelle déclaration d\'absence',
        'requete' => 'Nouvelle requête',
        'reponse_requete' => 'Réponse à votre requête',
    ];

    public function __construct(FcmService $fcm)
    {
        $this->fcm = $fcm;
    }

    public function send(object $notifiable, Notification $notification): void
    {
        if (!$this->fcm->isEnabled() || !method_exists($notifiable, 'deviceTokens')) {
            return;
        }

        if (!method_exists($notification, 'toArray')) {
            return;
        }

        $payload = $notification->toArray($notifiable);
        $message = $payload['message'] ?? null;
        if (!$message) {
            return;
        }

        $type = $payload['type'] ?? 'info';
        $title = self::$titles[$type] ?? 'Portail RH+';

        $data = ['type' => $type];
        if (!empty($payload['requete_id'])) {
            $data['requete_id'] = $payload['requete_id'];
        }
        if (!empty($payload['conge_id'])) {
            $data['conge_id'] = $payload['conge_id'];
        }

        $this->fcm->sendToUser($notifiable, $title, $message, $data);
    }
}
