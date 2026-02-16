<?php

namespace App\Channels;

use App\Services\WhatsAppService;
use Illuminate\Notifications\Notification;

class WhatsAppChannel
{
    protected WhatsAppService $whatsapp;

    public function __construct(WhatsAppService $whatsapp)
    {
        $this->whatsapp = $whatsapp;
    }

    public function send(object $notifiable, Notification $notification): void
    {
        if (!$this->whatsapp->isEnabled()) {
            return;
        }

        if (method_exists($notification, 'toWhatsApp')) {
            $notification->toWhatsApp($notifiable);
        }
    }
}
