<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TypeConge extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'type_conges';

    protected $fillable = [
        'entreprise_id',
        'nom',
        'code',
        'description',
        'jours_par_an',
        'couleur',
        'icone',
        'deductible',
        'is_active',
        'ordre',
    ];

    protected $casts = [
        'jours_par_an' => 'integer',
        'deductible' => 'boolean',
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

    public function conges()
    {
        return $this->hasMany(Conge::class);
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
                'nom' => 'Congé annuel',
                'code' => 'annuel',
                'description' => 'Congé annuel payé',
                'jours_par_an' => 30,
                'couleur' => '#3b7dd8',
                'icone' => 'calendar',
                'deductible' => true,
                'ordre' => 1,
            ],
            [
                'nom' => 'Congé maladie',
                'code' => 'maladie',
                'description' => 'Congé pour raison médicale',
                'jours_par_an' => 15,
                'couleur' => '#ef4444',
                'icone' => 'heart',
                'deductible' => false,
                'ordre' => 2,
            ],
            [
                'nom' => 'Congé spécial',
                'code' => 'special',
                'description' => 'Congé pour événement familial (mariage, naissance, décès)',
                'jours_par_an' => 5,
                'couleur' => '#8b5cf6',
                'icone' => 'star',
                'deductible' => false,
                'ordre' => 3,
            ],
            [
                'nom' => 'Congé sans solde',
                'code' => 'sans_solde',
                'description' => 'Congé non rémunéré',
                'jours_par_an' => 0,
                'couleur' => '#6b7280',
                'icone' => 'pause',
                'deductible' => false,
                'ordre' => 4,
            ],
            [
                'nom' => 'Congé maternité',
                'code' => 'maternite',
                'description' => 'Congé de maternité légal',
                'jours_par_an' => 98,
                'couleur' => '#ec4899',
                'icone' => 'baby',
                'deductible' => false,
                'ordre' => 5,
            ],
        ];
    }
}
