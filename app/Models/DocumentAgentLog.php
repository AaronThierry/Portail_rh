<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentAgentLog extends Model
{
    protected $table = 'documents_agent_logs';

    public $timestamps = false;

    protected $fillable = [
        'document_id',
        'user_id',
        'action',
        'ip_address',
        'user_agent',
        'details',
        'created_at',
    ];

    protected $casts = [
        'details' => 'array',
        'created_at' => 'datetime',
    ];

    /**
     * Actions disponibles
     */
    public const ACTIONS = [
        'view' => 'Consultation',
        'download' => 'Téléchargement',
        'upload' => 'Upload',
        'update' => 'Modification',
        'delete' => 'Suppression',
        'restore' => 'Restauration',
    ];

    /**
     * Boot du modèle
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($log) {
            $log->created_at = now();
        });
    }

    /**
     * Relation avec le document
     */
    public function document()
    {
        return $this->belongsTo(DocumentAgent::class, 'document_id');
    }

    /**
     * Relation avec l'utilisateur
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Obtenir le libellé de l'action
     */
    public function getActionLibelleAttribute(): string
    {
        return self::ACTIONS[$this->action] ?? $this->action;
    }
}
