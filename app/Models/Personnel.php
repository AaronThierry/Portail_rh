<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Personnel extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'entreprise_id',
        'departement_id',
        'service_id',
        'user_id',
        'matricule',
        'nom',
        'prenoms',
        'sexe',
        'civilite',
        'adresse',
        'telephone',
        'telephone_code_pays',
        'telephone_whatsapp',
        'numero_identification',
        'poste',
        'date_naissance',
        'type_contrat',
        'date_embauche',
        'date_fin_contrat',
        'photo',
        'is_active',
    ];

    protected $casts = [
        'date_naissance' => 'date',
        'date_embauche' => 'date',
        'date_fin_contrat' => 'date',
        'is_active' => 'boolean',
        'telephone_whatsapp' => 'boolean',
    ];

    protected $appends = ['telephone_complet', 'nom_complet', 'statut_contrat'];

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
     * Relation avec le service
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Relation avec l'utilisateur (compte système)
     * Un personnel peut avoir un compte utilisateur
     */
    public function user()
    {
        return $this->hasOne(User::class, 'personnel_id');
    }

    /**
     * Accesseur pour le téléphone complet avec code pays
     */
    public function getTelephoneCompletAttribute()
    {
        if (!$this->telephone) {
            return null;
        }
        return $this->telephone_code_pays
            ? "{$this->telephone_code_pays} {$this->telephone}"
            : $this->telephone;
    }

    /**
     * Accesseur pour le nom complet
     */
    public function getNomCompletAttribute()
    {
        return trim("{$this->civilite} {$this->nom} {$this->prenoms}");
    }

    /**
     * Accesseur pour le statut du contrat
     */
    public function getStatutContratAttribute()
    {
        if ($this->type_contrat === 'CDI') {
            return 'Contrat à Durée Indéterminée';
        }

        if ($this->type_contrat === 'CDD') {
            if ($this->date_fin_contrat && $this->date_fin_contrat->isPast()) {
                return 'Contrat Expiré';
            }
            return 'Contrat à Durée Déterminée';
        }

        return $this->type_contrat;
    }

    /**
     * Scope pour récupérer le personnel actif
     */
    public function scopeActif($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope pour récupérer le personnel d'une entreprise
     */
    public function scopeForEntreprise($query, $entrepriseId)
    {
        return $query->where('entreprise_id', $entrepriseId);
    }

    /**
     * Scope pour récupérer le personnel sans compte utilisateur
     */
    public function scopeSansCompte($query)
    {
        return $query->whereNull('user_id');
    }

    /**
     * Scope pour récupérer le personnel avec compte utilisateur
     */
    public function scopeAvecCompte($query)
    {
        return $query->whereNotNull('user_id');
    }

    /**
     * Vérifier si le personnel a un compte utilisateur
     */
    public function hasUser()
    {
        return !is_null($this->user_id);
    }

    /**
     * Générer un matricule unique
     */
    public static function genererMatricule($entrepriseId)
    {
        $prefix = 'PER';
        $year = date('Y');
        $lastPersonnel = static::where('entreprise_id', $entrepriseId)
            ->whereYear('created_at', $year)
            ->orderBy('id', 'desc')
            ->first();

        $number = $lastPersonnel ? (intval(substr($lastPersonnel->matricule, -4)) + 1) : 1;

        return sprintf('%s%s%04d', $prefix, $year, $number);
    }

    /**
     * Calculer l'âge du personnel
     */
    public function getAgeAttribute()
    {
        if (!$this->date_naissance) {
            return null;
        }
        return $this->date_naissance->age;
    }

    /**
     * Calculer l'ancienneté en années
     */
    public function getAncienneteAttribute()
    {
        if (!$this->date_embauche) {
            return null;
        }
        return $this->date_embauche->diffInYears(now());
    }
}
