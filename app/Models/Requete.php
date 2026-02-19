<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Requete extends Model
{
    protected $fillable = [
        'entreprise_id',
        'user_id',
        'sujet',
        'categorie',
        'priorite',
        'message',
        'statut',
        'reponse',
        'repondu_par',
        'repondu_le',
        'lu_par_admin',
        'lu_par_chef',
    ];

    protected $casts = [
        'repondu_le'    => 'datetime',
        'lu_par_admin'  => 'boolean',
        'lu_par_chef'   => 'boolean',
    ];

    public const CATEGORIES = [
        'question'    => 'Question',
        'facturation' => 'Facturation',
        'support'     => 'Support technique',
        'autre'       => 'Autre',
    ];

    public const STATUTS = [
        'en_attente' => 'En attente',
        'en_cours'   => 'En cours',
        'repondue'   => 'Répondue',
        'fermee'     => 'Fermée',
    ];

    public const PRIORITES = [
        'normale'  => 'Normale',
        'urgente'  => 'Urgente',
    ];

    /* ── Relations ─────────────────────────────────────── */

    public function entreprise(): BelongsTo
    {
        return $this->belongsTo(Entreprise::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reponduPar(): BelongsTo
    {
        return $this->belongsTo(User::class, 'repondu_par');
    }

    /* ── Scopes ─────────────────────────────────────────── */

    public function scopeNonLuesAdmin($query)
    {
        return $query->where('lu_par_admin', false)
                     ->whereIn('statut', ['en_attente', 'en_cours']);
    }

    public function scopeEnAttente($query)
    {
        return $query->where('statut', 'en_attente');
    }

    /* ── Helpers ─────────────────────────────────────────── */

    public function getCategorieLibelleAttribute(): string
    {
        return self::CATEGORIES[$this->categorie] ?? $this->categorie;
    }

    public function getStatutLibelleAttribute(): string
    {
        return self::STATUTS[$this->statut] ?? $this->statut;
    }

    public function isUrgente(): bool
    {
        return $this->priorite === 'urgente';
    }

    public function isRepondue(): bool
    {
        return $this->statut === 'repondue';
    }

    public function isFermee(): bool
    {
        return $this->statut === 'fermee';
    }
}
