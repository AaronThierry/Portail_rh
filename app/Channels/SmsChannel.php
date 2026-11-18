<?php

namespace App\Channels;

use App\Services\SmsService;
use Illuminate\Notifications\Notification;

class SmsChannel
{
    protected SmsService $sms;

    public function __construct(SmsService $sms)
    {
        $this->sms = $sms;
    }

    public function send(object $notifiable, Notification $notification): void
    {
        if (!$this->sms->isEnabled()) {
            return;
        }

        if (method_exists($notification, 'toSms')) {
            $notification->toSms($notifiable);
        }
    }
}
