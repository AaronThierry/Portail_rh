<?php

namespace App\Notifications;

use App\Models\DocumentAgent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class NouveauDocumentAgentNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected DocumentAgent $document;

    public function __construct(DocumentAgent $document)
    {
        $this->document = $document;
    }

    public function via(object $notifiable): array
    {
        return ['database', \App\Channels\FcmChannel::class];
    }

    public function toArray(object $notifiable): array
    {
        $categorie = $this->document->categorie->nom ?? 'Document';

        return [
            'type' => 'nouveau_document',
            'document_id' => $this->document->id,
            'categorie' => $categorie,
            'titre' => $this->document->titre,
            'message' => 'Un nouveau document (' . $categorie . ') a été ajouté à votre dossier : ' . $this->document->titre . '.',
        ];
    }
}
