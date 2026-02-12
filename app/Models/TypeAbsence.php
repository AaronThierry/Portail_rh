<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TypeAbsence extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'type_absences';

    protected $fillable = [
        'entreprise_id',
        'nom',
        'code',
        'description',
        'couleur',
        'icone',
        'is_active',
        'ordre',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'ordre' => 'integer',
    ];

    // =========================================================================
    // RELATIONS
    // =========================================================================

    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class);
    }

    public function absences()
    {
        return $this->hasMany(Absence::class);
    }

    // =========================================================================
    // SCOPES
    // =========================================================================

    public function scopeActif($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeForEntreprise($query, $entrepriseId)
    {
        return $query->where('entreprise_id', $entrepriseId);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('ordre')->orderBy('nom');
    }

    // =========================================================================
    // METHODES STATIQUES
    // =========================================================================

    public static function getDefaultTypes(): array
    {
        return [
            [
                'nom' => 'Absence injustifiée',
                'code' => 'injustifiee',
                'description' => 'Absence sans justificatif ni autorisation préalable',
                'couleur' => '#ef4444',
                'icone' => 'x-circle',
                'ordre' => 1,
            ],
            [
                'nom' => 'Retard',
                'code' => 'retard',
                'description' => 'Arrivée en retard au poste de travail',
                'couleur' => '#f59e0b',
                'icone' => 'clock',
                'ordre' => 2,
            ],
            [
                'nom' => 'Absence maladie',
                'code' => 'maladie',
                'description' => 'Absence pour raison médicale (hors congé maladie)',
                'couleur' => '#8b5cf6',
                'icone' => 'heart',
                'ordre' => 3,
            ],
            [
                'nom' => 'Absence autorisée',
                'code' => 'autorisee',
                'description' => 'Absence avec autorisation préalable du supérieur',
                'couleur' => '#3b82f6',
                'icone' => 'check-circle',
                'ordre' => 4,
            ],
            [
                'nom' => 'Départ anticipé',
                'code' => 'depart_anticipe',
                'description' => 'Départ avant la fin de la journée de travail',
                'couleur' => '#f97316',
                'icone' => 'log-out',
                'ordre' => 5,
            ],
        ];
    }
}
