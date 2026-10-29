<?php

namespace App\Channels;

use App\Services\FcmService;
use App\Services\WebPushService;
use Illuminate\Notifications\Notification;

/**
 * Canal push unifié : relaie vers l'app mobile (FCM/Capacitor) ET vers les
 * navigateurs abonnés en Web Push (notamment la PWA installée sur iPhone).
 */
class FcmChannel
{
    protected FcmService $fcm;
    protected WebPushService $webPush;

    /** Titre affiché dans la notification push, selon le type déjà utilisé par toArray(). */
    protected static array $titles = [
        'statut_conge' => 'Congé',
        'statut_absence' => 'Absence',
        'bulletin_paie' => 'Bulletin de paie',
        'nouvelle_demande_conge' => 'Nouvelle demande de congé',
        'nouvelle_demande_absence' => 'Nouvelle déclaration d\'absence',
        'requete' => 'Nouvelle requête',
        'reponse_requete' => 'Réponse à votre requête',
        'conge_annule' => 'Congé annulé',
        'absence_annulee' => 'Absence annulée',
        'nouveau_document' => 'Nouveau document',
        'requete_fermee' => 'Requête fermée',
        '2fa_active' => 'Sécurité du compte',
        '2fa_desactive' => 'Sécurité du compte',
        'mot_de_passe_modifie' => 'Sécurité du compte',
    ];

    public function __construct(FcmService $fcm, WebPushService $webPush)
    {
        $this->fcm = $fcm;
        $this->webPush = $webPush;
    }

    public function send(object $notifiable, Notification $notification): void
    {
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

        if ($this->fcm->isEnabled() && method_exists($notifiable, 'deviceTokens')) {
            $this->fcm->sendToUser($notifiable, $title, $message, $data);
        }

        if ($this->webPush->isEnabled() && method_exists($notifiable, 'webPushSubscriptions')) {
            $this->webPush->sendToUser($notifiable, $title, $message, $data);
        }
    }
}
