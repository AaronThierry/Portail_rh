<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CategorieDocument extends Model
{
    use HasFactory;

    protected $table = 'categories_documents';

    protected $fillable = [
        'entreprise_id',
        'nom',
        'slug',
        'description',
        'icone',
        'couleur',
        'ordre',
        'obligatoire',
        'actif',
    ];

    protected $casts = [
        'obligatoire' => 'boolean',
        'actif' => 'boolean',
        'ordre' => 'integer',
    ];

    /**
     * Icônes disponibles pour les catégories
     */
    public const ICONES = [
        'folder' => 'Dossier',
        'file-text' => 'Document texte',
        'file-check' => 'Document validé',
        'id-card' => 'Carte d\'identité',
        'graduation-cap' => 'Diplôme',
        'briefcase' => 'Contrat',
        'heart-pulse' => 'Médical',
        'car' => 'Permis de conduire',
        'home' => 'Domicile',
        'shield-check' => 'Certification',
        'award' => 'Récompense',
        'file-signature' => 'Signature',
        'clipboard-list' => 'Liste',
        'receipt' => 'Reçu',
        'calculator' => 'Finance',
    ];

    /**
     * Couleurs disponibles
     */
    public const COULEURS = [
        '#667eea' => 'Violet',
        '#3b82f6' => 'Bleu',
        '#10b981' => 'Vert',
        '#f59e0b' => 'Orange',
        '#ef4444' => 'Rouge',
        '#8b5cf6' => 'Pourpre',
        '#ec4899' => 'Rose',
        '#06b6d4' => 'Cyan',
        '#84cc16' => 'Lime',
        '#6366f1' => 'Indigo',
    ];

    /**
     * Boot du modèle
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($categorie) {
            if (empty($categorie->slug)) {
                $categorie->slug = Str::slug($categorie->nom);
            }
        });

        static::updating(function ($categorie) {
            if ($categorie->isDirty('nom')) {
                $categorie->slug = Str::slug($categorie->nom);
            }
        });
    }

    /**
     * Relation avec l'entreprise
     */
    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class);
    }

    /**
     * Relation avec les documents
     */
    public function documents()
    {
        return $this->hasMany(DocumentAgent::class, 'categorie_id');
    }

    /**
     * Scope pour les catégories actives
     */
    public function scopeActives($query)
    {
        return $query->where('actif', true);
    }

    /**
     * Scope par entreprise
     */
    public function scopeForEntreprise($query, $entrepriseId)
    {
        return $query->where('entreprise_id', $entrepriseId);
    }

    /**
     * Scope tri par ordre
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('ordre')->orderBy('nom');
    }

    /**
     * Obtenir le nombre de documents dans cette catégorie
     */
    public function getDocumentsCountAttribute()
    {
        return $this->documents()->count();
    }

    /**
     * Répertoires par défaut à créer pour une nouvelle entreprise
     * Ces répertoires s'appliquent globalement à tous les employés
     */
    public static function getDefaultCategories(): array
    {
        return [
            [
                'nom' => 'Contrats',
                'slug' => 'contrats',
                'description' => 'Contrats de travail, avenants, conventions collectives',
                'icone' => 'briefcase',
                'couleur' => '#667eea',
                'ordre' => 1,
                'obligatoire' => true,
            ],
            [
                'nom' => 'Fiches de poste',
                'slug' => 'fiches-de-poste',
                'description' => 'Descriptions de poste, missions, objectifs',
                'icone' => 'clipboard-list',
                'couleur' => '#8b5cf6',
                'ordre' => 2,
                'obligatoire' => true,
            ],
            [
                'nom' => 'Pièces d\'identité',
                'slug' => 'pieces-identite',
                'description' => 'CNI, passeport, carte de séjour, permis de conduire',
                'icone' => 'id-card',
                'couleur' => '#3b82f6',
                'ordre' => 3,
                'obligatoire' => true,
            ],
            [
                'nom' => 'Diplômes et Certificats',
                'slug' => 'diplomes-certificats',
                'description' => 'Diplômes, attestations de réussite, certifications professionnelles',
                'icone' => 'graduation-cap',
                'couleur' => '#10b981',
                'ordre' => 4,
                'obligatoire' => false,
            ],
            [
                'nom' => 'CV et Lettres',
                'slug' => 'cv-lettres',
                'description' => 'Curriculum vitae, lettres de motivation, lettres de recommandation',
                'icone' => 'file-text',
                'couleur' => '#06b6d4',
                'ordre' => 5,
                'obligatoire' => false,
            ],
            [
                'nom' => 'Documents médicaux',
                'slug' => 'documents-medicaux',
                'description' => 'Certificats médicaux, visites médicales, aptitude au travail',
                'icone' => 'heart-pulse',
                'couleur' => '#ef4444',
                'ordre' => 6,
                'obligatoire' => false,
            ],
            [
                'nom' => 'Bulletins de paie',
                'slug' => 'bulletins-paie',
                'description' => 'Fiches de paie mensuelles, attestations de salaire',
                'icone' => 'calculator',
                'couleur' => '#f59e0b',
                'ordre' => 7,
                'obligatoire' => false,
            ],
            [
                'nom' => 'Formations',
                'slug' => 'formations',
                'description' => 'Attestations de formation, certificats de compétences',
                'icone' => 'award',
                'couleur' => '#ec4899',
                'ordre' => 8,
                'obligatoire' => false,
            ],
            [
                'nom' => 'Évaluations',
                'slug' => 'evaluations',
                'description' => 'Entretiens annuels, évaluations de performance, objectifs',
                'icone' => 'chart-bar',
                'couleur' => '#14b8a6',
                'ordre' => 9,
                'obligatoire' => false,
            ],
            [
                'nom' => 'Documents administratifs',
                'slug' => 'documents-administratifs',
                'description' => 'RIB, attestations diverses, justificatifs de domicile',
                'icone' => 'folder',
                'couleur' => '#64748b',
                'ordre' => 10,
                'obligatoire' => false,
            ],
        ];
    }

    /**
     * Créer les catégories par défaut pour une entreprise
     */
    public static function createDefaultForEntreprise(int $entrepriseId): void
    {
        foreach (self::getDefaultCategories() as $categorie) {
            self::firstOrCreate(
                [
                    'entreprise_id' => $entrepriseId,
                    'slug' => $categorie['slug'],
                ],
                array_merge($categorie, ['entreprise_id' => $entrepriseId])
            );
        }
    }
}
