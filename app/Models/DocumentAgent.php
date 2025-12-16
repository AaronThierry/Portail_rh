<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class DocumentAgent extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'documents_agent';

    protected $fillable = [
        'personnel_id',
        'categorie_id',
        'uploaded_by',
        'nom_original',
        'nom_fichier',
        'chemin',
        'extension',
        'mime_type',
        'taille',
        'titre',
        'description',
        'date_document',
        'date_expiration',
        'reference',
        'statut',
        'confidentiel',
        'visible_employe',
        'version',
        'parent_id',
    ];

    protected $casts = [
        'date_document' => 'date',
        'date_expiration' => 'date',
        'confidentiel' => 'boolean',
        'visible_employe' => 'boolean',
        'taille' => 'integer',
        'version' => 'integer',
    ];

    protected $appends = ['taille_formatee', 'est_expire', 'url_telechargement'];

    /**
     * Extensions autorisées
     */
    public const EXTENSIONS_AUTORISEES = [
        'pdf', 'doc', 'docx', 'xls', 'xlsx', 'jpg', 'jpeg', 'png', 'gif', 'webp'
    ];

    /**
     * Taille maximale en Mo
     */
    public const TAILLE_MAX_MO = 10;

    /**
     * Statuts disponibles
     */
    public const STATUTS = [
        'actif' => 'Actif',
        'archive' => 'Archivé',
        'expire' => 'Expiré',
    ];

    /**
     * Boot du modèle
     */
    protected static function boot()
    {
        parent::boot();

        // Mettre à jour le statut si expiré
        static::retrieved(function ($document) {
            if ($document->date_expiration && $document->date_expiration->isPast() && $document->statut === 'actif') {
                $document->update(['statut' => 'expire']);
            }
        });

        // Supprimer le fichier physique lors de la suppression définitive
        static::forceDeleted(function ($document) {
            if (Storage::disk('dossiers_agents')->exists($document->chemin)) {
                Storage::disk('dossiers_agents')->delete($document->chemin);
            }
        });
    }

    /**
     * Relation avec le personnel
     */
    public function personnel()
    {
        return $this->belongsTo(Personnel::class);
    }

    /**
     * Relation avec la catégorie
     */
    public function categorie()
    {
        return $this->belongsTo(CategorieDocument::class, 'categorie_id');
    }

    /**
     * Relation avec l'utilisateur qui a uploadé
     */
    public function uploadeur()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    /**
     * Relation avec le document parent (versioning)
     */
    public function parent()
    {
        return $this->belongsTo(DocumentAgent::class, 'parent_id');
    }

    /**
     * Relation avec les versions enfants
     */
    public function versions()
    {
        return $this->hasMany(DocumentAgent::class, 'parent_id');
    }

    /**
     * Relation avec les logs
     */
    public function logs()
    {
        return $this->hasMany(DocumentAgentLog::class, 'document_id');
    }

    /**
     * Scope pour les documents actifs
     */
    public function scopeActifs($query)
    {
        return $query->where('statut', 'actif');
    }

    /**
     * Scope pour les documents expirés
     */
    public function scopeExpires($query)
    {
        return $query->where('statut', 'expire')
            ->orWhere(function ($q) {
                $q->whereNotNull('date_expiration')
                    ->where('date_expiration', '<', now());
            });
    }

    /**
     * Scope pour les documents qui expirent bientôt
     */
    public function scopeExpirentBientot($query, int $jours = 30)
    {
        return $query->whereNotNull('date_expiration')
            ->where('date_expiration', '>', now())
            ->where('date_expiration', '<=', now()->addDays($jours))
            ->where('statut', 'actif');
    }

    /**
     * Scope pour les documents d'un personnel
     */
    public function scopeForPersonnel($query, $personnelId)
    {
        return $query->where('personnel_id', $personnelId);
    }

    /**
     * Scope pour les documents d'une catégorie
     */
    public function scopeInCategorie($query, $categorieId)
    {
        return $query->where('categorie_id', $categorieId);
    }

    /**
     * Scope pour les documents visibles par l'employé
     */
    public function scopeVisiblesParEmploye($query)
    {
        return $query->where('visible_employe', true)
            ->where('confidentiel', false);
    }

    /**
     * Scope pour les documents non confidentiels
     */
    public function scopeNonConfidentiels($query)
    {
        return $query->where('confidentiel', false);
    }

    /**
     * Obtenir la taille formatée
     */
    public function getTailleFormateeAttribute(): string
    {
        $bytes = $this->taille;

        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' Go';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' Mo';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' Ko';
        } else {
            return $bytes . ' octets';
        }
    }

    /**
     * Vérifier si le document est expiré
     */
    public function getEstExpireAttribute(): bool
    {
        return $this->date_expiration && $this->date_expiration->isPast();
    }

    /**
     * Obtenir l'URL de téléchargement sécurisée
     */
    public function getUrlTelechargementAttribute(): string
    {
        return route('dossier-agent.download', $this->id);
    }

    /**
     * Obtenir le chemin complet du fichier
     */
    public function getCheminCompletAttribute(): string
    {
        return Storage::disk('dossiers_agents')->path($this->chemin);
    }

    /**
     * Vérifier si le fichier existe
     */
    public function fichierExiste(): bool
    {
        return Storage::disk('dossiers_agents')->exists($this->chemin);
    }

    /**
     * Obtenir l'icône selon l'extension
     */
    public function getIconeAttribute(): string
    {
        $icones = [
            'pdf' => 'file-pdf',
            'doc' => 'file-word',
            'docx' => 'file-word',
            'xls' => 'file-excel',
            'xlsx' => 'file-excel',
            'jpg' => 'file-image',
            'jpeg' => 'file-image',
            'png' => 'file-image',
            'gif' => 'file-image',
            'webp' => 'file-image',
        ];

        return $icones[$this->extension] ?? 'file';
    }

    /**
     * Vérifier si c'est une image
     */
    public function estImage(): bool
    {
        return in_array($this->extension, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
    }

    /**
     * Vérifier si c'est un PDF
     */
    public function estPdf(): bool
    {
        return $this->extension === 'pdf';
    }

    /**
     * Logger une action sur le document
     */
    public function logAction(string $action, ?int $userId = null, ?array $details = null): void
    {
        DocumentAgentLog::create([
            'document_id' => $this->id,
            'user_id' => $userId ?? auth()->id(),
            'action' => $action,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'details' => $details,
        ]);
    }

    /**
     * Créer une nouvelle version du document
     */
    public function creerNouvelleVersion(array $data): self
    {
        $nouvelleVersion = $this->replicate();
        $nouvelleVersion->fill($data);
        $nouvelleVersion->parent_id = $this->parent_id ?? $this->id;
        $nouvelleVersion->version = $this->getMaxVersion() + 1;
        $nouvelleVersion->save();

        // Archiver l'ancienne version
        $this->update(['statut' => 'archive']);

        return $nouvelleVersion;
    }

    /**
     * Obtenir la version maximale
     */
    protected function getMaxVersion(): int
    {
        $parentId = $this->parent_id ?? $this->id;

        return self::where(function ($query) use ($parentId) {
            $query->where('id', $parentId)
                ->orWhere('parent_id', $parentId);
        })->max('version') ?? 1;
    }

    /**
     * Générer le chemin de stockage pour un personnel
     */
    public static function genererCheminStockage(Personnel $personnel, string $nomFichier): string
    {
        $entrepriseId = $personnel->entreprise_id;
        $personnelId = $personnel->id;
        $annee = now()->format('Y');
        $mois = now()->format('m');

        return "{$entrepriseId}/{$personnelId}/{$annee}/{$mois}/{$nomFichier}";
    }
}
