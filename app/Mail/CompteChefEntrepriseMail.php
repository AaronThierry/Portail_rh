<?php

namespace App\Mail;

use App\Models\Entreprise;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CompteChefEntrepriseMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public readonly User $user,
        public readonly Entreprise $entreprise,
        public readonly string $motDePasseTemporaire
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Vos identifiants Portail RH — ' . $this->entreprise->nom,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.compte-chef-entreprise',
        );
    }
}
