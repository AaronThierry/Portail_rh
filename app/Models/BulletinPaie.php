<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class BulletinPaie extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'bulletins_paie';

    protected $fillable = [
        'personnel_id',
        'entreprise_id',
        'uploaded_by',
        'mois',
        'annee',
        'fichier_path',
        'fichier_nom_original',
        'fichier_type',
        'fichier_taille',
        'salaire_brut',
        'salaire_net',
        'reference',
        'statut',
        'visible_employe',
        'notifier_employe',
        'notifie_at',
        'commentaire',
    ];

    protected $casts = [
        'mois' => 'integer',
        'annee' => 'integer',
        'salaire_brut' => 'decimal:2',
        'salaire_net' => 'decimal:2',
        'fichier_taille' => 'integer',
        'visible_employe' => 'boolean',
        'notifier_employe' => 'boolean',
        'notifie_at' => 'datetime',
    ];

    protected $appends = ['periode_formatee', 'mois_nom', 'fichier_taille_formatee'];

    /**
     * Noms des mois en français
     */
    public const MOIS_NOMS = [
        1 => 'Janvier',
        2 => 'Février',
        3 => 'Mars',
        4 => 'Avril',
        5 => 'Mai',
        6 => 'Juin',
        7 => 'Juillet',
        8 => 'Août',
        9 => 'Septembre',
        10 => 'Octobre',
        11 => 'Novembre',
        12 => 'Décembre',
    ];

    /**
     * Noms courts des mois
     */
    public const MOIS_COURTS = [
        1 => 'Jan', 2 => 'Fév', 3 => 'Mar', 4 => 'Avr',
        5 => 'Mai', 6 => 'Juin', 7 => 'Juil', 8 => 'Août',
        9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Déc',
    ];

    // =========================================================================
    // RELATIONS
    // =========================================================================

    public function personnel()
    {
        return $this->belongsTo(Personnel::class);
    }

    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class);
    }

    public function uploadedBy()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    // =========================================================================
    // ACCESSEURS
    // =========================================================================

    public function getMoisNomAttribute()
    {
        return self::MOIS_NOMS[$this->mois] ?? '';
    }

    public function getMoisCourtAttribute()
    {
        return self::MOIS_COURTS[$this->mois] ?? '';
    }

    public function getPeriodeFormateeAttribute()
    {
        return $this->mois_nom . ' ' . $this->annee;
    }

    public function getPeriodeCodeAttribute()
    {
        return sprintf('%d-%02d', $this->annee, $this->mois);
    }

    public function getFichierTailleFormateeAttribute()
    {
        $bytes = $this->fichier_taille;
        if ($bytes === 0) return '0 Ko';

        $k = 1024;
        $sizes = ['octets', 'Ko', 'Mo', 'Go'];
        $i = floor(log($bytes) / log($k));

        return round($bytes / pow($k, $i), 2) . ' ' . $sizes[$i];
    }

    public function getFichierUrlAttribute()
    {
        return $this->fichier_path ? Storage::url($this->fichier_path) : null;
    }

    // =========================================================================
    // SCOPES
    // =========================================================================

    public function scopeAnnee($query, $annee)
    {
        return $query->where('annee', $annee);
    }

    public function scopeMois($query, $mois)
    {
        return $query->where('mois', $mois);
    }

    public function scopePeriode($query, $annee, $mois)
    {
        return $query->where('annee', $annee)->where('mois', $mois);
    }

    public function scopePublie($query)
    {
        return $query->where('statut', 'publie');
    }

    public function scopeVisibleEmploye($query)
    {
        return $query->where('visible_employe', true)->where('statut', 'publie');
    }

    public function scopeForPersonnel($query, $personnelId)
    {
        return $query->where('personnel_id', $personnelId);
    }

    public function scopeForEntreprise($query, $entrepriseId)
    {
        return $query->where('entreprise_id', $entrepriseId);
    }

    // =========================================================================
    // MÉTHODES STATIQUES
    // =========================================================================

    /**
     * Obtenir les années disponibles
     */
    public static function getAnneesDisponibles($personnelId = null, $entrepriseId = null)
    {
        $query = self::query();
        if ($personnelId) $query->forPersonnel($personnelId);
        if ($entrepriseId) $query->forEntreprise($entrepriseId);

        return $query->distinct()
            ->orderBy('annee', 'desc')
            ->pluck('annee');
    }

    /**
     * Obtenir les bulletins groupés par année puis par mois
     */
    public static function getBulletinsGroupes($personnelId = null, $entrepriseId = null)
    {
        $query = self::with('personnel')
            ->orderBy('annee', 'desc')
            ->orderBy('mois', 'desc');

        if ($personnelId) $query->forPersonnel($personnelId);
        if ($entrepriseId) $query->forEntreprise($entrepriseId);

        $bulletins = $query->get();

        // Grouper par année
        return $bulletins->groupBy('annee')->map(function ($anneeGroup) {
            return $anneeGroup->groupBy('mois');
        });
    }

    /**
     * Générer une référence unique pour le bulletin
     */
    public static function genererReference($entrepriseId, $personnelId, $annee, $mois)
    {
        $personnel = Personnel::find($personnelId);
        $matricule = $personnel ? $personnel->matricule : 'EMP';

        return sprintf('BP-%s-%d%02d', $matricule, $annee, $mois);
    }

    /**
     * Obtenir le chemin de stockage organisé par répertoires
     * Structure: bulletins-paie/{entreprise_id}/{annee}/{mois}/
     */
    public static function getStoragePath($entrepriseId, $annee, $mois)
    {
        return sprintf('bulletins-paie/%d/%d/%02d', $entrepriseId, $annee, $mois);
    }

    /**
     * Vérifier si un bulletin existe déjà pour cette période
     */
    public static function existePourPeriode($personnelId, $annee, $mois)
    {
        return self::where('personnel_id', $personnelId)
            ->where('annee', $annee)
            ->where('mois', $mois)
            ->exists();
    }

    /**
     * Statistiques globales pour le tableau de bord admin
     */
    public static function getStatistiques($entrepriseId = null, $annee = null)
    {
        $query = self::query();
        if ($entrepriseId) $query->forEntreprise($entrepriseId);
        if ($annee) $query->annee($annee);

        $bulletins = $query->get();

        return [
            'total_bulletins' => $bulletins->count(),
            'total_employes' => $bulletins->pluck('personnel_id')->unique()->count(),
            'masse_salariale_nette' => $bulletins->sum('salaire_net'),
            'masse_salariale_brute' => $bulletins->sum('salaire_brut'),
            'par_mois' => $bulletins->groupBy('mois')->map->count(),
            'derniere_periode' => $bulletins->sortByDesc(function ($b) {
                return $b->annee * 100 + $b->mois;
            })->first(),
        ];
    }

    /**
     * Obtenir le récapitulatif par mois pour une année (timeline)
     */
    public static function getTimelineAnnee($annee, $entrepriseId = null)
    {
        $query = self::annee($annee);
        if ($entrepriseId) $query->forEntreprise($entrepriseId);

        $bulletins = $query->get();
        $timeline = [];

        for ($mois = 1; $mois <= 12; $mois++) {
            $bulletinsMois = $bulletins->where('mois', $mois);
            $timeline[$mois] = [
                'mois' => $mois,
                'mois_nom' => self::MOIS_NOMS[$mois],
                'mois_court' => self::MOIS_COURTS[$mois],
                'total' => $bulletinsMois->count(),
                'masse_nette' => $bulletinsMois->sum('salaire_net'),
                'masse_brute' => $bulletinsMois->sum('salaire_brut'),
                'complet' => $mois <= now()->month || $annee < now()->year,
            ];
        }

        return $timeline;
    }
}
