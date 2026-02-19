<?php

namespace App\Notifications;

use App\Channels\WhatsAppChannel;
use App\Models\Requete;
use App\Services\WhatsAppService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class NouvelleRequeteNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public readonly Requete $requete) {}

    public function via(object $notifiable): array
    {
        $channels = ['database'];

        try {
            $whatsapp = app(WhatsAppService::class);
            if ($whatsapp->isEnabled() && $notifiable->phone) {
                $channels[] = WhatsAppChannel::class;
            }
        } catch (\Throwable) {
            // WhatsApp non configuré
        }

        return $channels;
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type'       => 'requete',
            'requete_id' => $this->requete->id,
            'sujet'      => $this->requete->sujet,
            'categorie'  => $this->requete->categorie_libelle,
            'priorite'   => $this->requete->priorite,
            'entreprise' => $this->requete->entreprise->nom ?? '—',
            'message'    => \Str::limit($this->requete->message, 100),
        ];
    }

    public function toWhatsApp(object $notifiable): void
    {
        if (!$notifiable->phone) {
            return;
        }

        $urgence   = $this->requete->isUrgente() ? '🔴 URGENT — ' : '';
        $entreprise = $this->requete->entreprise->nom ?? 'N/A';
        $categorie  = $this->requete->categorie_libelle;

        $message = "📩 *{$urgence}Nouvelle requête client*\n\n"
            . "🏢 Entreprise : *{$entreprise}*\n"
            . "📂 Catégorie : {$categorie}\n"
            . "📋 Sujet : {$this->requete->sujet}\n\n"
            . "💬 " . \Str::limit($this->requete->message, 200) . "\n\n"
            . "👉 Connectez-vous au Portail RH+ pour répondre.";

        try {
            app(WhatsAppService::class)->sendMessage($notifiable->phone, $message);
        } catch (\Throwable) {
            // Silently fail
        }
    }
}
