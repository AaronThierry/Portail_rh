<?php

namespace App\Notifications;

use App\Models\Absence;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class AbsenceAnnuleeNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected Absence $absence;

    public function __construct(Absence $absence)
    {
        $this->absence = $absence;
    }

    public function via(object $notifiable): array
    {
        return ['database', \App\Channels\FcmChannel::class];
    }

    public function toArray(object $notifiable): array
    {
        $employe = $this->absence->personnel->nom . ' ' . $this->absence->personnel->prenoms;
        $typeNom = $this->absence->typeAbsence->nom ?? 'Absence';

        return [
            'type' => 'absence_annulee',
            'absence_id' => $this->absence->id,
            'employe' => $employe,
            'type_absence' => $typeNom,
            'date_absence' => $this->absence->date_absence->format('d/m/Y'),
            'message' => $employe . ' a annulé sa déclaration d\'absence (' . $typeNom . ') du ' . $this->absence->date_absence->format('d/m/Y') . '.',
        ];
    }
}
