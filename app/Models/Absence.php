<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Absence extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'entreprise_id',
        'personnel_id',
        'type_absence_id',
        'enregistre_par',
        'date_absence',
        'heure_debut',
        'heure_fin',
        'duree_type',
        'minutes_retard',
        'motif',
        'commentaire_admin',
        'justificatif',
        'justifiee',
        'source',
        'statut',
        'motif_refus',
        'traite_par',
        'traite_at',
        'annee',
    ];

    protected $casts = [
        'date_absence' => 'date',
        'justifiee' => 'boolean',
        'minutes_retard' => 'integer',
        'annee' => 'integer',
        'traite_at' => 'datetime',
    ];

    protected $appends = ['duree_label', 'justifiee_label'];

    public const DUREE_TYPES = [
        'journee' => 'Journée complète',
        'demi_journee' => 'Demi-journée',
        'retard' => 'Retard',
        'depart_anticipe' => 'Départ anticipé',
    ];

    // =========================================================================
    // RELATIONS
    // =========================================================================

    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class);
    }

    public function personnel()
    {
        return $this->belongsTo(Personnel::class);
    }

    public function typeAbsence()
    {
        return $this->belongsTo(TypeAbsence::class);
    }

    public function enregistrePar()
    {
        return $this->belongsTo(User::class, 'enregistre_par');
    }

    public function traitePar()
    {
        return $this->belongsTo(User::class, 'traite_par');
    }

    // =========================================================================
    // SCOPES
    // =========================================================================

    public function scopeForEntreprise($query, $entrepriseId)
    {
        return $query->where('entreprise_id', $entrepriseId);
    }

    public function scopeForPersonnel($query, $personnelId)
    {
        return $query->where('personnel_id', $personnelId);
    }

    public function scopeAnnee($query, $annee)
    {
        return $query->where('annee', $annee);
    }

    public function scopeJustifiee($query)
    {
        return $query->where('justifiee', true);
    }

    public function scopeInjustifiee($query)
    {
        return $query->where('justifiee', false);
    }

    public function scopeEnAttente($query)
    {
        return $query->where('statut', 'en_attente');
    }

    public function scopeApprouvee($query)
    {
        return $query->where('statut', 'approuvee');
    }

    public function scopeFromEmploye($query)
    {
        return $query->where('source', 'employe');
    }

    public function scopeFromAdmin($query)
    {
        return $query->where('source', 'admin');
    }

    // =========================================================================
    // ACCESSEURS
    // =========================================================================

    public function getDureeLabelAttribute()
    {
        if ($this->duree_type === 'retard' && $this->minutes_retard) {
            return $this->minutes_retard . ' min de retard';
        }
        return self::DUREE_TYPES[$this->duree_type] ?? $this->duree_type;
    }

    public function getJustifieeLabelAttribute()
    {
        return $this->justifiee ? 'Justifiée' : 'Non justifiée';
    }

    // =========================================================================
    // METHODES STATIQUES
    // =========================================================================

    public static function getStatistiques($entrepriseId = null, $annee = null): array
    {
        $query = self::query();
        if ($entrepriseId) $query->forEntreprise($entrepriseId);
        if ($annee) $query->annee($annee);

        $baseApprouvee = (clone $query)->approuvee();

        return [
            'total' => (clone $baseApprouvee)->count(),
            'justifiees' => (clone $baseApprouvee)->justifiee()->count(),
            'injustifiees' => (clone $baseApprouvee)->injustifiee()->count(),
            'retards' => (clone $baseApprouvee)->where('duree_type', 'retard')->count(),
            'en_attente' => (clone $query)->enAttente()->count(),
        ];
    }

    public static function getStatistiquesPersonnel($personnelId, $annee = null): array
    {
        $query = self::forPersonnel($personnelId);
        if ($annee) $query->annee($annee);

        $baseApprouvee = (clone $query)->approuvee();

        return [
            'total' => (clone $baseApprouvee)->count(),
            'justifiees' => (clone $baseApprouvee)->justifiee()->count(),
            'injustifiees' => (clone $baseApprouvee)->injustifiee()->count(),
            'retards' => (clone $baseApprouvee)->where('duree_type', 'retard')->count(),
            'en_attente' => (clone $query)->enAttente()->count(),
        ];
    }

    public static function getAnneesDisponibles($personnelId = null, $entrepriseId = null)
    {
        $query = self::query();
        if ($personnelId) $query->forPersonnel($personnelId);
        if ($entrepriseId) $query->forEntreprise($entrepriseId);

        $annees = $query->distinct()->orderBy('annee', 'desc')->pluck('annee');

        if ($annees->isEmpty()) {
            return collect([now()->year]);
        }

        if (!$annees->contains(now()->year)) {
            $annees->prepend(now()->year);
        }

        return $annees->sortDesc()->values();
    }
}
