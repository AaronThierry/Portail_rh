<?php

namespace App\Notifications;

use App\Models\Absence;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class AbsenceStatusNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected Absence $absence;
    protected string $status;

    public function __construct(Absence $absence, string $status)
    {
        $this->absence = $absence;
        $this->status = $status;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $typeNom = $this->absence->typeAbsence->nom ?? 'Absence';
        $statusText = $this->status === 'approuvee' ? 'approuvée' : 'refusée';

        return [
            'type' => 'statut_absence',
            'absence_id' => $this->absence->id,
            'status' => $this->status,
            'type_absence' => $typeNom,
            'date_absence' => $this->absence->date_absence->format('d/m/Y'),
            'message' => 'Votre déclaration d\'absence (' . $typeNom . ') du '
                . $this->absence->date_absence->format('d/m/Y') . ' a été ' . $statusText . '.',
        ];
    }
}
