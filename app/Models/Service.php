<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'entreprise_id',
        'departement_id',
        'nom',
        'code',
        'description',
        'is_global',
        'is_active',
    ];

    protected $casts = [
        'is_global' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Relation avec l'entreprise
     */
    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class);
    }

    /**
     * Relation avec le département
     */
    public function departement()
    {
        return $this->belongsTo(Departement::class);
    }

    /**
     * Relation avec le personnel (employés du service)
     */
    public function personnels()
    {
        return $this->hasMany(Personnel::class);
    }

    /**
     * Scope pour récupérer les services globaux
     */
    public function scopeGlobal($query)
    {
        return $query->where('is_global', true);
    }

    /**
     * Scope pour récupérer les services d'une entreprise + globaux
     */
    public function scopeForEntreprise($query, $entrepriseId)
    {
        return $query->where(function($q) use ($entrepriseId) {
            $q->where('entreprise_id', $entrepriseId)
              ->orWhere('is_global', true);
        });
    }
}
