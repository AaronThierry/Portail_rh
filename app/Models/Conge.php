<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Conge extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'entreprise_id',
        'personnel_id',
        'type_conge_id',
        'user_id',
        'date_debut',
        'date_fin',
        'nombre_jours',
        'demi_journee_debut',
        'demi_journee_fin',
        'motif',
        'piece_jointe',
        'document_officiel',
        'statut',
        'traite_par',
        'motif_refus',
        'commentaire_admin',
        'traite_at',
        'annee',
        'conge_parent_id',
    ];

    protected $casts = [
        'date_debut' => 'date',
        'date_fin' => 'date',
        'traite_at' => 'datetime',
        'nombre_jours' => 'integer',
        'demi_journee_debut' => 'boolean',
        'demi_journee_fin' => 'boolean',
        'annee' => 'integer',
    ];

    protected $appends = ['duree_formatee', 'statut_label', 'statut_couleur'];

    public const STATUTS = [
        'en_attente' => 'En attente',
        'approuve' => 'Approuvé',
        'refuse' => 'Refusé',
        'annule' => 'Annulé',
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

    public function typeConge()
    {
        return $this->belongsTo(TypeConge::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function traitePar()
    {
        return $this->belongsTo(User::class, 'traite_par');
    }

    public function congeParent()
    {
        return $this->belongsTo(self::class, 'conge_parent_id');
    }

    public function prolongations()
    {
        return $this->hasMany(self::class, 'conge_parent_id');
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

    public function scopeEnAttente($query)
    {
        return $query->where('statut', 'en_attente');
    }

    public function scopeApprouve($query)
    {
        return $query->where('statut', 'approuve');
    }

    public function scopeRefuse($query)
    {
        return $query->where('statut', 'refuse');
    }

    public function scopeAnnee($query, $annee)
    {
        return $query->where('annee', $annee);
    }

    public function scopeStatut($query, $statut)
    {
        return $query->where('statut', $statut);
    }

    // =========================================================================
    // ACCESSEURS
    // =========================================================================

    public function getDureeFormateeAttribute()
    {
        if ($this->nombre_jours <= 1) {
            return $this->nombre_jours . ' jour';
        }
        return $this->nombre_jours . ' jours';
    }

    public function getStatutLabelAttribute()
    {
        return self::STATUTS[$this->statut] ?? $this->statut;
    }

    public function getStatutCouleurAttribute()
    {
        return match ($this->statut) {
            'en_attente' => '#f59e0b',
            'approuve' => '#10b981',
            'refuse' => '#ef4444',
            'annule' => '#6b7280',
            default => '#6b7280',
        };
    }

    // =========================================================================
    // METHODES STATIQUES
    // =========================================================================

    /**
     * Calculer le solde de conges pour un employe sur une annee
     */
    public static function getSolde($personnelId, $annee, $entrepriseId): array
    {
        // Allocation annuelle totale (depuis les types deductibles)
        $allocation = TypeConge::forEntreprise($entrepriseId)
            ->actif()
            ->where('deductible', true)
            ->sum('jours_par_an');

        // Jours pris (approuves + deductibles)
        $pris = self::forPersonnel($personnelId)
            ->annee($annee)
            ->approuve()
            ->whereHas('typeConge', fn($q) => $q->where('deductible', true))
            ->sum('nombre_jours');

        // Jours en attente (deductibles)
        $enAttente = self::forPersonnel($personnelId)
            ->annee($annee)
            ->enAttente()
            ->whereHas('typeConge', fn($q) => $q->where('deductible', true))
            ->sum('nombre_jours');

        return [
            'annuels' => (int) $allocation,
            'pris' => (int) $pris,
            'en_attente' => (int) $enAttente,
            'restants' => (int) ($allocation - $pris),
        ];
    }

    /**
     * Calculer le nombre de jours ouvres entre deux dates (hors weekends)
     */
    public static function calculerNombreJours($dateDebut, $dateFin, $demiJourneeDebut = false, $demiJourneeFin = false): int
    {
        $debut = Carbon::parse($dateDebut);
        $fin = Carbon::parse($dateFin);

        $jours = 0;
        $current = $debut->copy();

        while ($current->lte($fin)) {
            // Exclure samedi (6) et dimanche (0)
            if (!$current->isWeekend()) {
                $jours++;
            }
            $current->addDay();
        }

        // Ajustements demi-journees
        if ($demiJourneeDebut && $jours > 0) {
            $jours = max(1, $jours); // Au minimum 1 jour
        }
        if ($demiJourneeFin && $jours > 0) {
            // Demi-journee = on ne retire pas, c'est juste informatif
        }

        return max(1, $jours);
    }

    /**
     * Obtenir les annees disponibles pour un employe
     */
    public static function getAnneesDisponibles($personnelId = null, $entrepriseId = null)
    {
        $query = self::query();
        if ($personnelId) $query->forPersonnel($personnelId);
        if ($entrepriseId) $query->forEntreprise($entrepriseId);

        $annees = $query->distinct()
            ->orderBy('annee', 'desc')
            ->pluck('annee');

        if ($annees->isEmpty()) {
            return collect([now()->year]);
        }

        // S'assurer que l'annee courante est incluse
        if (!$annees->contains(now()->year)) {
            $annees->prepend(now()->year);
        }

        return $annees->sortDesc()->values();
    }

    /**
     * Statistiques pour le tableau de bord admin
     */
    public static function getStatistiques($entrepriseId = null, $annee = null): array
    {
        $query = self::query();
        if ($entrepriseId) $query->forEntreprise($entrepriseId);
        if ($annee) $query->annee($annee);

        return [
            'total' => (clone $query)->count(),
            'en_attente' => (clone $query)->enAttente()->count(),
            'approuve' => (clone $query)->approuve()->count(),
            'refuse' => (clone $query)->refuse()->count(),
        ];
    }
}
