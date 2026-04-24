<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssistantDocument extends Model
{
    protected $fillable = [
        'nom', 'fichier_path', 'gemini_file_uri', 'gemini_file_name',
        'actif', 'entreprise_id', 'taille', 'uploaded_by', 'uri_expires_at',
    ];

    protected $casts = [
        'actif'          => 'boolean',
        'uri_expires_at' => 'datetime',
        'taille'         => 'integer',
    ];

    public function entreprise(): BelongsTo
    {
        return $this->belongsTo(Entreprise::class);
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function isUriExpired(): bool
    {
        return $this->uri_expires_at && $this->uri_expires_at->isPast();
    }

    public function tailleFormatee(): string
    {
        $bytes = $this->taille ?? 0;
        if ($bytes >= 1048576) return round($bytes / 1048576, 1) . ' Mo';
        if ($bytes >= 1024)    return round($bytes / 1024, 0) . ' Ko';
        return $bytes . ' o';
    }
}
