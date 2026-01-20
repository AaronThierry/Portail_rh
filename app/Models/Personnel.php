<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Personnel extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Boot du modèle - Événements automatiques
     */
    protected static function boot()
    {
        parent::boot();

        // Créer automatiquement le dossier agent lors de la création d'un personnel
        static::created(function ($personnel) {
            $personnel->creerDossierAgent();
        });
    }

    /**
     * Créer le dossier agent pour ce personnel
     * Structure: {entreprise_id}/{personnel_id}/
     * Avec sous-dossiers par année
     */
    public function creerDossierAgent(): bool
    {
        try {
            $basePath = $this->getCheminDossierAgent();

            // Créer le dossier principal du personnel
            if (!Storage::disk('dossiers_agents')->exists($basePath)) {
                Storage::disk('dossiers_agents')->makeDirectory($basePath);
            }

            // Créer le sous-dossier pour l'année en cours
            $annee = now()->format('Y');
            $pathAnnee = "{$basePath}/{$annee}";
            if (!Storage::disk('dossiers_agents')->exists($pathAnnee)) {
                Storage::disk('dossiers_agents')->makeDirectory($pathAnnee);
            }

            // Créer un fichier .gitkeep pour préserver le dossier
            $gitkeepPath = "{$basePath}/.gitkeep";
            if (!Storage::disk('dossiers_agents')->exists($gitkeepPath)) {
                Storage::disk('dossiers_agents')->put($gitkeepPath, '');
            }

            return true;
        } catch (\Exception $e) {
            \Log::error("Erreur création dossier agent pour personnel {$this->id}: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Obtenir le chemin du dossier agent
     */
    public function getCheminDossierAgent(): string
    {
        return "{$this->entreprise_id}/{$this->id}";
    }

    /**
     * Vérifier si le dossier agent existe
     */
    public function dossierAgentExiste(): bool
    {
        return Storage::disk('dossiers_agents')->exists($this->getCheminDossierAgent());
    }

    /**
     * Obtenir le chemin complet du dossier agent sur le système de fichiers
     */
    public function getCheminCompletDossierAgent(): string
    {
        return storage_path('app/dossiers_agents/' . $this->getCheminDossierAgent());
    }

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
        'email',
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

    protected $appends = ['telephone_complet', 'nom_complet', 'statut_contrat', 'photo_url'];

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
     * Relation avec les documents du dossier agent
     */
    public function documents()
    {
        return $this->hasMany(DocumentAgent::class, 'personnel_id');
    }

    /**
     * Relation avec les bulletins de paie
     */
    public function bulletinsPaie()
    {
        return $this->hasMany(BulletinPaie::class, 'personnel_id');
    }

    /**
     * Obtenir les bulletins de paie visibles par l'employé
     */
    public function bulletinsPaieVisibles()
    {
        return $this->bulletinsPaie()
            ->where('visible_employe', true)
            ->where('statut', 'publie')
            ->orderBy('annee', 'desc')
            ->orderBy('mois', 'desc');
    }

    /**
     * Obtenir les documents actifs
     */
    public function documentsActifs()
    {
        return $this->documents()->where('statut', 'actif');
    }

    /**
     * Obtenir les documents expirés
     */
    public function documentsExpires()
    {
        return $this->documents()->where('statut', 'expire')
            ->orWhere(function ($query) {
                $query->whereNotNull('date_expiration')
                    ->where('date_expiration', '<', now());
            });
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
     * Générer un matricule unique professionnel
     * Format: [SIGLE]-[ANNÉE]-[NUMÉRO]
     * Exemple: ACME-25-00001
     * Similaire aux standards: IBM, Microsoft, Google, Total, Orange
     */
    public static function genererMatricule($entrepriseId)
    {
        $entreprise = Entreprise::find($entrepriseId);

        // 1. Code entreprise (2-4 lettres)
        if ($entreprise && $entreprise->sigle) {
            $codeEntreprise = strtoupper(substr($entreprise->sigle, 0, 4));
        } else {
            $nom = $entreprise->nom ?? 'ENT';
            $mots = preg_split('/\s+/', $nom);
            $motsSignificatifs = array_filter($mots, function($mot) {
                return strlen($mot) > 2 && !in_array(strtolower($mot), ['les', 'des', 'une', 'the', 'and', 'société', 'company']);
            });

            if (count($motsSignificatifs) >= 2) {
                $codeEntreprise = '';
                foreach (array_slice($motsSignificatifs, 0, 3) as $mot) {
                    $codeEntreprise .= strtoupper($mot[0]);
                }
            } else {
                $codeEntreprise = strtoupper(substr($nom, 0, 3));
            }
        }

        // 2. Année d'embauche (2 derniers chiffres)
        $annee = date('y');

        // 3. Construire le préfixe
        $prefix = "{$codeEntreprise}-{$annee}-";

        do {
            // Récupérer le dernier matricule de cette année pour cette entreprise
            $lastPersonnel = static::where('entreprise_id', $entrepriseId)
                ->where('matricule', 'like', $prefix . '%')
                ->orderBy('matricule', 'desc')
                ->first();

            // Numéro séquentiel sur 5 chiffres
            $number = $lastPersonnel ? (intval(substr($lastPersonnel->matricule, -5)) + 1) : 1;
            $matricule = sprintf('%s%05d', $prefix, $number);

        } while (static::where('matricule', $matricule)->exists());

        return $matricule;
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

    /**
     * Accesseur pour obtenir l'URL complète de la photo
     * Retourne l'URL de la photo stockée ou une image par défaut (avatar généré)
     */
    public function getPhotoUrlAttribute()
    {
        if ($this->photo) {
            // Si une photo existe, retourner l'URL via le storage public
            return asset('storage/' . $this->photo);
        }

        // Image par défaut générée avec UI Avatars
        // Utilise les initiales du nom complet sur fond violet
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->nom_complet) . '&size=200&background=667eea&color=fff&font-size=0.4&bold=true';
    }
}
