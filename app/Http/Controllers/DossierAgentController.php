<?php

namespace App\Http\Controllers;

use App\Models\Personnel;
use App\Models\DocumentAgent;
use App\Models\CategorieDocument;
use App\Http\Requests\StoreDocumentAgentRequest;
use App\Http\Requests\UpdateDocumentAgentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class DossierAgentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Obtenir l'ID de l'entreprise de l'utilisateur connecté
     * Pour les Super Admin sans entreprise, utilise la première entreprise disponible
     */
    protected function getEntrepriseId(): ?int
    {
        $user = auth()->user();
        $entrepriseId = $user->entreprise_id;

        if (!$entrepriseId) {
            $entreprise = \App\Models\Entreprise::first();
            return $entreprise ? $entreprise->id : null;
        }

        return $entrepriseId;
    }

    /**
     * Affiche la liste des dossiers agents (vue globale)
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $isSuperAdmin = $user->hasRole('Super Admin');

        // Récupérer les personnels avec compteur de documents
        $query = Personnel::with(['departement', 'service'])
            ->withCount('documents');

        // Filtrer par entreprise sauf pour Super Admin
        if (!$isSuperAdmin) {
            $query->where('entreprise_id', $user->entreprise_id);
        }

        // Filtres
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                    ->orWhere('prenoms', 'like', "%{$search}%")
                    ->orWhere('matricule', 'like', "%{$search}%");
            });
        }

        if ($request->filled('departement')) {
            $query->where('departement_id', $request->departement);
        }

        if ($request->filled('service')) {
            $query->where('service_id', $request->service);
        }

        $personnels = $query->orderBy('nom')->paginate(20);

        // Statistiques globales
        if ($isSuperAdmin) {
            $stats = [
                'total_personnels' => Personnel::count(),
                'total_documents' => DocumentAgent::count(),
                'documents_expires' => DocumentAgent::expires()->count(),
                'documents_expirent_bientot' => DocumentAgent::expirentBientot(30)->count(),
            ];
            // Catégories de toutes les entreprises pour Super Admin
            $categories = CategorieDocument::actives()->ordered()->get();
        } else {
            $entrepriseId = $user->entreprise_id;
            $stats = [
                'total_personnels' => Personnel::where('entreprise_id', $entrepriseId)->count(),
                'total_documents' => DocumentAgent::whereHas('personnel', function ($q) use ($entrepriseId) {
                    $q->where('entreprise_id', $entrepriseId);
                })->count(),
                'documents_expires' => DocumentAgent::whereHas('personnel', function ($q) use ($entrepriseId) {
                    $q->where('entreprise_id', $entrepriseId);
                })->expires()->count(),
                'documents_expirent_bientot' => DocumentAgent::whereHas('personnel', function ($q) use ($entrepriseId) {
                    $q->where('entreprise_id', $entrepriseId);
                })->expirentBientot(30)->count(),
            ];
            // Catégories disponibles
            $categories = CategorieDocument::forEntreprise($entrepriseId)
                ->actives()
                ->ordered()
                ->get();
        }

        return view('dossier-agent.index', compact('personnels', 'stats', 'categories'));
    }

    /**
     * Affiche le dossier d'un agent spécifique
     */
    public function show(Personnel $personnel)
    {
        $this->authorizeAccess($personnel);

        $personnel->load(['departement', 'service', 'entreprise']);

        // Catégories avec documents
        $categories = CategorieDocument::forEntreprise($personnel->entreprise_id)
            ->actives()
            ->ordered()
            ->withCount(['documents' => function ($query) use ($personnel) {
                $query->where('personnel_id', $personnel->id)->where('statut', '!=', 'archive');
            }])
            ->get();

        // Documents par catégorie
        $documentsByCategory = [];
        foreach ($categories as $categorie) {
            $documentsByCategory[$categorie->id] = DocumentAgent::forPersonnel($personnel->id)
                ->inCategorie($categorie->id)
                ->where('statut', '!=', 'archive')
                ->orderBy('created_at', 'desc')
                ->get();
        }

        // Documents sans catégorie
        $documentsSansCategorie = DocumentAgent::forPersonnel($personnel->id)
            ->whereNull('categorie_id')
            ->where('statut', '!=', 'archive')
            ->orderBy('created_at', 'desc')
            ->get();

        // Statistiques du dossier
        $stats = [
            'total' => DocumentAgent::forPersonnel($personnel->id)->count(),
            'actifs' => DocumentAgent::forPersonnel($personnel->id)->actifs()->count(),
            'expires' => DocumentAgent::forPersonnel($personnel->id)->expires()->count(),
            'expirent_bientot' => DocumentAgent::forPersonnel($personnel->id)->expirentBientot(30)->count(),
            'taille_totale' => DocumentAgent::forPersonnel($personnel->id)->sum('taille'),
        ];

        return view('dossier-agent.show', compact(
            'personnel',
            'categories',
            'documentsByCategory',
            'documentsSansCategorie',
            'stats'
        ));
    }

    /**
     * Upload d'un nouveau document
     */
    public function store(StoreDocumentAgentRequest $request, Personnel $personnel)
    {
        $this->authorizeAccess($personnel);

        DB::beginTransaction();

        try {
            $file = $request->file('document');
            $extension = strtolower($file->getClientOriginalExtension());
            $nomOriginal = $file->getClientOriginalName();
            $nomFichier = Str::uuid() . '.' . $extension;

            // Chemin de stockage organisé
            $chemin = DocumentAgent::genererCheminStockage($personnel, $nomFichier);

            // Stockage du fichier
            Storage::disk('dossiers_agents')->put($chemin, file_get_contents($file));

            // Création du document en base
            $document = DocumentAgent::create([
                'personnel_id' => $personnel->id,
                'categorie_id' => $request->categorie_id,
                'uploaded_by' => auth()->id(),
                'nom_original' => $nomOriginal,
                'nom_fichier' => $nomFichier,
                'chemin' => $chemin,
                'extension' => $extension,
                'mime_type' => $file->getMimeType(),
                'taille' => $file->getSize(),
                'titre' => $request->titre ?? pathinfo($nomOriginal, PATHINFO_FILENAME),
                'description' => $request->description,
                'date_document' => $request->date_document,
                'date_expiration' => $request->date_expiration,
                'reference' => $request->reference,
                'confidentiel' => $request->boolean('confidentiel'),
                'visible_employe' => $request->boolean('visible_employe', true),
            ]);

            // Log de l'action
            $document->logAction('upload', auth()->id(), [
                'nom_fichier' => $nomOriginal,
                'taille' => $file->getSize(),
            ]);

            DB::commit();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Document uploadé avec succès',
                    'document' => $document->load('categorie'),
                ]);
            }

            return redirect()
                ->route('dossier-agent.show', $personnel)
                ->with('success', 'Document uploadé avec succès');

        } catch (\Exception $e) {
            DB::rollBack();

            // Nettoyer le fichier si uploadé
            if (isset($chemin) && Storage::disk('dossiers_agents')->exists($chemin)) {
                Storage::disk('dossiers_agents')->delete($chemin);
            }

            \Log::error('Erreur upload document agent', [
                'error' => $e->getMessage(),
                'personnel_id' => $personnel->id,
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur lors de l\'upload: ' . $e->getMessage(),
                ], 500);
            }

            return back()->with('error', 'Erreur lors de l\'upload: ' . $e->getMessage());
        }
    }

    /**
     * Mettre à jour un document
     */
    public function update(UpdateDocumentAgentRequest $request, DocumentAgent $document)
    {
        $this->authorizeAccess($document->personnel);

        DB::beginTransaction();

        try {
            $oldData = $document->toArray();

            // Si un nouveau fichier est uploadé, créer une nouvelle version
            if ($request->hasFile('document')) {
                $file = $request->file('document');
                $extension = strtolower($file->getClientOriginalExtension());
                $nomFichier = Str::uuid() . '.' . $extension;
                $chemin = DocumentAgent::genererCheminStockage($document->personnel, $nomFichier);

                Storage::disk('dossiers_agents')->put($chemin, file_get_contents($file));

                $document = $document->creerNouvelleVersion([
                    'nom_original' => $file->getClientOriginalName(),
                    'nom_fichier' => $nomFichier,
                    'chemin' => $chemin,
                    'extension' => $extension,
                    'mime_type' => $file->getMimeType(),
                    'taille' => $file->getSize(),
                    'titre' => $request->titre ?? $document->titre,
                    'description' => $request->description,
                    'date_document' => $request->date_document,
                    'date_expiration' => $request->date_expiration,
                    'reference' => $request->reference,
                    'categorie_id' => $request->categorie_id ?? $document->categorie_id,
                    'confidentiel' => $request->boolean('confidentiel'),
                    'visible_employe' => $request->boolean('visible_employe', true),
                    'statut' => 'actif',
                    'uploaded_by' => auth()->id(),
                ]);
            } else {
                // Mise à jour des métadonnées uniquement
                $document->update([
                    'titre' => $request->titre ?? $document->titre,
                    'description' => $request->description,
                    'date_document' => $request->date_document,
                    'date_expiration' => $request->date_expiration,
                    'reference' => $request->reference,
                    'categorie_id' => $request->categorie_id ?? $document->categorie_id,
                    'confidentiel' => $request->boolean('confidentiel'),
                    'visible_employe' => $request->boolean('visible_employe', true),
                ]);
            }

            // Log de l'action
            $document->logAction('update', auth()->id(), [
                'old_data' => $oldData,
                'new_data' => $document->toArray(),
            ]);

            DB::commit();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Document mis à jour avec succès',
                    'document' => $document->load('categorie'),
                ]);
            }

            return redirect()
                ->route('dossier-agent.show', $document->personnel_id)
                ->with('success', 'Document mis à jour avec succès');

        } catch (\Exception $e) {
            DB::rollBack();

            \Log::error('Erreur mise à jour document', [
                'error' => $e->getMessage(),
                'document_id' => $document->id,
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur lors de la mise à jour',
                ], 500);
            }

            return back()->with('error', 'Erreur lors de la mise à jour');
        }
    }

    /**
     * Télécharger un document
     */
    public function download(DocumentAgent $document)
    {
        $this->authorizeAccess($document->personnel);

        if (!$document->fichierExiste()) {
            abort(404, 'Fichier non trouvé');
        }

        // Log du téléchargement
        $document->logAction('download');

        return Storage::disk('dossiers_agents')->download(
            $document->chemin,
            $document->nom_original
        );
    }

    /**
     * Prévisualiser un document (pour images et PDF)
     */
    public function preview(DocumentAgent $document)
    {
        $this->authorizeAccess($document->personnel);

        if (!$document->fichierExiste()) {
            abort(404, 'Fichier non trouvé');
        }

        // Log de la consultation
        $document->logAction('view');

        $file = Storage::disk('dossiers_agents')->get($document->chemin);

        return response($file)
            ->header('Content-Type', $document->mime_type)
            ->header('Content-Disposition', 'inline; filename="' . $document->nom_original . '"');
    }

    /**
     * Supprimer un document (soft delete)
     */
    public function destroy(DocumentAgent $document)
    {
        $this->authorizeAccess($document->personnel);

        $personnelId = $document->personnel_id;

        // Log avant suppression
        $document->logAction('delete', auth()->id(), [
            'nom_fichier' => $document->nom_original,
        ]);

        $document->delete();

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Document supprimé avec succès',
            ]);
        }

        return redirect()
            ->route('dossier-agent.show', $personnelId)
            ->with('success', 'Document supprimé avec succès');
    }

    /**
     * Archiver un document
     */
    public function archive(DocumentAgent $document)
    {
        $this->authorizeAccess($document->personnel);

        $document->update(['statut' => 'archive']);
        $document->logAction('update', auth()->id(), ['action' => 'archive']);

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Document archivé avec succès',
            ]);
        }

        return back()->with('success', 'Document archivé avec succès');
    }

    /**
     * Restaurer un document supprimé
     */
    public function restore($id)
    {
        $document = DocumentAgent::withTrashed()->findOrFail($id);
        $this->authorizeAccess($document->personnel);

        $document->restore();
        $document->logAction('restore');

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Document restauré avec succès',
            ]);
        }

        return back()->with('success', 'Document restauré avec succès');
    }

    /**
     * Upload multiple de documents
     */
    public function uploadMultiple(Request $request, Personnel $personnel)
    {
        $this->authorizeAccess($personnel);

        $request->validate([
            'documents' => 'required|array|max:10',
            'documents.*' => 'file|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png,gif,webp|max:' . (DocumentAgent::TAILLE_MAX_MO * 1024),
            'categorie_id' => 'nullable|exists:categories_documents,id',
        ]);

        $uploaded = [];
        $errors = [];

        foreach ($request->file('documents') as $index => $file) {
            try {
                $extension = strtolower($file->getClientOriginalExtension());
                $nomOriginal = $file->getClientOriginalName();
                $nomFichier = Str::uuid() . '.' . $extension;
                $chemin = DocumentAgent::genererCheminStockage($personnel, $nomFichier);

                Storage::disk('dossiers_agents')->put($chemin, file_get_contents($file));

                $document = DocumentAgent::create([
                    'personnel_id' => $personnel->id,
                    'categorie_id' => $request->categorie_id,
                    'uploaded_by' => auth()->id(),
                    'nom_original' => $nomOriginal,
                    'nom_fichier' => $nomFichier,
                    'chemin' => $chemin,
                    'extension' => $extension,
                    'mime_type' => $file->getMimeType(),
                    'taille' => $file->getSize(),
                    'titre' => pathinfo($nomOriginal, PATHINFO_FILENAME),
                ]);

                $document->logAction('upload');
                $uploaded[] = $document;

            } catch (\Exception $e) {
                $errors[] = [
                    'file' => $nomOriginal ?? "Fichier {$index}",
                    'error' => $e->getMessage(),
                ];
            }
        }

        return response()->json([
            'success' => count($errors) === 0,
            'message' => count($uploaded) . ' document(s) uploadé(s)',
            'uploaded' => $uploaded,
            'errors' => $errors,
        ]);
    }

    /**
     * Recherche de documents
     */
    public function search(Request $request)
    {
        $entrepriseId = $this->getEntrepriseId();

        $query = DocumentAgent::with(['personnel', 'categorie', 'uploadeur'])
            ->whereHas('personnel', function ($q) use ($entrepriseId) {
                $q->where('entreprise_id', $entrepriseId);
            });

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('titre', 'like', "%{$search}%")
                    ->orWhere('nom_original', 'like', "%{$search}%")
                    ->orWhere('reference', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('categorie_id')) {
            $query->where('categorie_id', $request->categorie_id);
        }

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        if ($request->filled('personnel_id')) {
            $query->where('personnel_id', $request->personnel_id);
        }

        $documents = $query->orderBy('created_at', 'desc')
            ->paginate(20);

        return response()->json($documents);
    }

    /**
     * Documents expirant bientôt (alertes)
     */
    public function alertes()
    {
        $entrepriseId = $this->getEntrepriseId();

        $documentsExpires = DocumentAgent::with(['personnel', 'categorie'])
            ->whereHas('personnel', function ($q) use ($entrepriseId) {
                $q->where('entreprise_id', $entrepriseId);
            })
            ->expires()
            ->orderBy('date_expiration')
            ->get();

        $documentsExpirentBientot = DocumentAgent::with(['personnel', 'categorie'])
            ->whereHas('personnel', function ($q) use ($entrepriseId) {
                $q->where('entreprise_id', $entrepriseId);
            })
            ->expirentBientot(30)
            ->orderBy('date_expiration')
            ->get();

        return response()->json([
            'expires' => $documentsExpires,
            'expirent_bientot' => $documentsExpirentBientot,
        ]);
    }

    /**
     * Gestion des catégories
     */
    public function categories()
    {
        $entrepriseId = $this->getEntrepriseId();

        $categories = CategorieDocument::forEntreprise($entrepriseId)
            ->ordered()
            ->withCount('documents')
            ->get();

        return view('dossier-agent.categories', compact('categories'));
    }

    /**
     * Créer une catégorie
     */
    public function storeCategorie(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'icone' => 'nullable|string|max:50',
            'couleur' => 'nullable|string|max:20',
            'obligatoire' => 'boolean',
        ]);

        $entrepriseId = $this->getEntrepriseId();

        $categorie = CategorieDocument::create([
            'entreprise_id' => $entrepriseId,
            'nom' => $request->nom,
            'slug' => Str::slug($request->nom),
            'description' => $request->description,
            'icone' => $request->icone ?? 'folder',
            'couleur' => $request->couleur ?? '#667eea',
            'obligatoire' => $request->boolean('obligatoire'),
            'ordre' => CategorieDocument::forEntreprise($entrepriseId)->max('ordre') + 1,
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Catégorie créée avec succès',
                'categorie' => $categorie,
            ]);
        }

        return back()->with('success', 'Catégorie créée avec succès');
    }

    /**
     * Mettre à jour une catégorie
     */
    public function updateCategorie(Request $request, CategorieDocument $categorie)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'icone' => 'nullable|string|max:50',
            'couleur' => 'nullable|string|max:20',
            'obligatoire' => 'boolean',
            'actif' => 'boolean',
        ]);

        $categorie->update([
            'nom' => $request->nom,
            'description' => $request->description,
            'icone' => $request->icone ?? $categorie->icone,
            'couleur' => $request->couleur ?? $categorie->couleur,
            'obligatoire' => $request->boolean('obligatoire'),
            'actif' => $request->boolean('actif', true),
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Catégorie mise à jour avec succès',
                'categorie' => $categorie,
            ]);
        }

        return back()->with('success', 'Catégorie mise à jour avec succès');
    }

    /**
     * Supprimer une catégorie
     */
    public function destroyCategorie(CategorieDocument $categorie)
    {
        // Vérifier qu'il n'y a pas de documents dans cette catégorie
        if ($categorie->documents()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Impossible de supprimer une catégorie contenant des documents',
            ], 400);
        }

        $categorie->delete();

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Catégorie supprimée avec succès',
            ]);
        }

        return back()->with('success', 'Catégorie supprimée avec succès');
    }

    /**
     * Initialiser les catégories par défaut
     */
    public function initCategories()
    {
        $entrepriseId = $this->getEntrepriseId();

        if (!$entrepriseId) {
            return response()->json([
                'success' => false,
                'message' => 'Aucune entreprise disponible. Veuillez d\'abord créer une entreprise.',
            ], 400);
        }

        CategorieDocument::createDefaultForEntreprise($entrepriseId);

        return response()->json([
            'success' => true,
            'message' => 'Catégories par défaut créées avec succès',
        ]);
    }

    /**
     * Vue employé - Mon dossier personnel
     */
    public function monDossier()
    {
        $user = auth()->user();

        // Trouver le personnel lié à cet utilisateur
        $personnel = Personnel::where('user_id', $user->id)->first();

        if (!$personnel) {
            // Chercher par email si pas de lien direct
            $personnel = Personnel::where('email', $user->email)->first();
        }

        if (!$personnel) {
            return view('dossier-agent.mon-dossier-vide');
        }

        $personnel->load(['departement', 'service', 'entreprise']);

        // Catégories avec documents visibles pour l'employé
        $categories = CategorieDocument::forEntreprise($personnel->entreprise_id)
            ->actives()
            ->ordered()
            ->get();

        // Documents visibles par l'employé uniquement
        $documentsByCategory = [];
        foreach ($categories as $categorie) {
            $documentsByCategory[$categorie->id] = DocumentAgent::forPersonnel($personnel->id)
                ->inCategorie($categorie->id)
                ->where('statut', '!=', 'archive')
                ->where('visible_employe', true)
                ->orderBy('created_at', 'desc')
                ->get();
        }

        // Documents sans catégorie visibles
        $documentsSansCategorie = DocumentAgent::forPersonnel($personnel->id)
            ->whereNull('categorie_id')
            ->where('statut', '!=', 'archive')
            ->where('visible_employe', true)
            ->orderBy('created_at', 'desc')
            ->get();

        // Statistiques (documents visibles uniquement)
        $stats = [
            'total' => DocumentAgent::forPersonnel($personnel->id)->where('visible_employe', true)->count(),
            'actifs' => DocumentAgent::forPersonnel($personnel->id)->where('visible_employe', true)->actifs()->count(),
            'expires' => DocumentAgent::forPersonnel($personnel->id)->where('visible_employe', true)->expires()->count(),
            'expirent_bientot' => DocumentAgent::forPersonnel($personnel->id)->where('visible_employe', true)->expirentBientot(30)->count(),
        ];

        return view('dossier-agent.mon-dossier', compact(
            'personnel',
            'categories',
            'documentsByCategory',
            'documentsSansCategorie',
            'stats'
        ));
    }

    /**
     * Vérifier l'accès au personnel
     */
    protected function authorizeAccess(Personnel $personnel): void
    {
        $user = auth()->user();

        // Super Admin a accès à tout
        if ($user->hasRole('Super Admin')) {
            return;
        }

        // Vérifier que le personnel appartient à la même entreprise
        if ($user->entreprise_id !== $personnel->entreprise_id) {
            abort(403, 'Accès non autorisé');
        }
    }
}
