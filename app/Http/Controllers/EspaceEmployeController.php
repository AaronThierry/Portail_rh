<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Personnel;
use App\Models\DocumentAgent;
use App\Models\CategorieDocument;

class EspaceEmployeController extends Controller
{
    /**
     * Affiche le tableau de bord de l'employé
     */
    public function dashboard()
    {
        $user = Auth::user();
        $personnel = $user->personnel;

        // Statistiques pour le dashboard
        $stats = [
            'documents' => $personnel ? $personnel->documents()->count() : 0,
            'conges_restants' => 25, // À personnaliser selon votre système
            'demandes_en_cours' => 0,
            'anciennete' => $personnel ? $personnel->anciennete : 0,
        ];

        // Dernières activités (à personnaliser)
        $activities = collect([
            [
                'type' => 'document',
                'title' => 'Contrat de travail ajouté',
                'date' => now()->subDays(2),
                'icon' => 'file'
            ],
            [
                'type' => 'conge',
                'title' => 'Demande de congé approuvée',
                'date' => now()->subDays(5),
                'icon' => 'calendar'
            ],
            [
                'type' => 'profil',
                'title' => 'Photo de profil mise à jour',
                'date' => now()->subWeek(),
                'icon' => 'user'
            ],
        ]);

        return view('espace-employe.dashboard', compact('personnel', 'stats', 'activities'));
    }

    /**
     * Affiche le profil de l'employé
     */
    public function profil()
    {
        $user = Auth::user();
        $personnel = $user->personnel;

        if (!$personnel) {
            return redirect()->route('espace-employe.dashboard')
                ->with('error', 'Profil non trouvé. Veuillez contacter l\'administrateur.');
        }

        $personnel->load(['entreprise', 'departement', 'service']);

        return view('espace-employe.profil', compact('personnel'));
    }

    /**
     * Met à jour le profil de l'employé
     */
    public function updateProfil(Request $request)
    {
        $user = Auth::user();
        $personnel = $user->personnel;

        if (!$personnel) {
            return back()->with('error', 'Profil non trouvé.');
        }

        $request->validate([
            'telephone' => 'nullable|string|max:20',
            'adresse' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->only(['telephone', 'adresse']);

        // Gestion de la photo
        if ($request->hasFile('photo')) {
            // Supprimer l'ancienne photo
            if ($personnel->photo) {
                Storage::disk('public')->delete($personnel->photo);
            }

            $photo = $request->file('photo');
            $filename = 'personnel_' . $personnel->id . '_' . time() . '.' . $photo->getClientOriginalExtension();
            $path = $photo->storeAs('photos/personnel', $filename, 'public');
            $data['photo'] = $path;
        }

        $personnel->update($data);

        return back()->with('success', 'Profil mis à jour avec succès.');
    }

    /**
     * Met à jour le mot de passe
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Le mot de passe actuel est incorrect.']);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Mot de passe modifié avec succès.');
    }

    /**
     * Affiche les documents de l'employé organisés par catégorie
     */
    public function documents(Request $request)
    {
        $user = Auth::user();
        $personnel = $user->personnel;

        // Récupérer tous les documents visibles par l'employé
        $allDocuments = $personnel
            ? $personnel->documents()
                ->where('visible_employe', true)
                ->with('categorie')
                ->orderBy('created_at', 'desc')
                ->get()
            : collect([]);

        // Grouper les documents par catégorie
        $documentsByCategory = $allDocuments->groupBy(function($doc) {
            return $doc->categorie_id ?? 0;
        });

        // Récupérer toutes les catégories qui ont des documents
        $categoriesWithDocs = CategorieDocument::whereIn('id', $documentsByCategory->keys()->filter())
            ->ordered()
            ->get()
            ->keyBy('id');

        // Catégorie sélectionnée (null = vue d'ensemble des dossiers)
        $selectedCategory = $request->get('categorie');
        $currentCategory = null;
        $documents = collect([]);

        if ($selectedCategory) {
            $currentCategory = CategorieDocument::find($selectedCategory);
            $documents = $documentsByCategory->get((int)$selectedCategory, collect([]));
        }

        // Statistiques
        $stats = [
            'total' => $allDocuments->count(),
            'categories' => $categoriesWithDocs->count(),
            'recent' => $allDocuments->where('created_at', '>=', now()->subDays(30))->count(),
            'this_year' => $allDocuments->where('created_at', '>=', now()->startOfYear())->count(),
        ];

        // Documents sans catégorie
        $uncategorizedDocs = $documentsByCategory->get(0, collect([]));

        return view('espace-employe.documents', compact(
            'personnel',
            'allDocuments',
            'documents',
            'documentsByCategory',
            'categoriesWithDocs',
            'currentCategory',
            'selectedCategory',
            'uncategorizedDocs',
            'stats'
        ));
    }

    /**
     * Affiche les bulletins de paie
     */
    public function bulletins()
    {
        $user = Auth::user();
        $personnel = $user->personnel;

        // À personnaliser selon votre système de bulletins
        $bulletins = collect([]);

        return view('espace-employe.bulletins', compact('personnel', 'bulletins'));
    }

    /**
     * Affiche les attestations
     */
    public function attestations()
    {
        $user = Auth::user();
        $personnel = $user->personnel;

        return view('espace-employe.attestations', compact('personnel'));
    }

    /**
     * Affiche la page des congés
     */
    public function conges()
    {
        $user = Auth::user();
        $personnel = $user->personnel;

        // À personnaliser selon votre système de congés
        $conges = collect([]);
        $soldeConges = [
            'annuels' => 25,
            'pris' => 5,
            'restants' => 20,
        ];

        return view('espace-employe.conges', compact('personnel', 'conges', 'soldeConges'));
    }

    /**
     * Affiche les demandes de l'employé
     */
    public function demandes()
    {
        $user = Auth::user();
        $personnel = $user->personnel;

        // À personnaliser selon votre système de demandes
        $demandes = collect([]);

        return view('espace-employe.demandes', compact('personnel', 'demandes'));
    }

    /**
     * Affiche les paramètres
     */
    public function parametres()
    {
        $user = Auth::user();
        $personnel = $user->personnel;

        return view('espace-employe.parametres', compact('personnel', 'user'));
    }

    /**
     * Prévisualise un document
     */
    public function previewDocument($id)
    {
        $user = Auth::user();
        $personnel = $user->personnel;

        if (!$personnel) {
            abort(403, 'Accès non autorisé');
        }

        $document = DocumentAgent::where('id', $id)
            ->where('personnel_id', $personnel->id)
            ->where('visible_employe', true)
            ->firstOrFail();

        if (empty($document->chemin)) {
            abort(404, 'Aucun fichier associé à ce document');
        }

        // Essayer plusieurs chemins possibles (dossiers_agents est le disk utilisé)
        $possiblePaths = [
            storage_path('app/dossiers_agents/' . $document->chemin),
            storage_path('app/public/dossiers_agents/' . $document->chemin),
            storage_path('app/' . $document->chemin),
        ];

        $path = null;
        foreach ($possiblePaths as $possiblePath) {
            if (file_exists($possiblePath)) {
                $path = $possiblePath;
                break;
            }
        }

        if (!$path) {
            abort(404, 'Fichier non trouvé sur le serveur');
        }

        $mimeType = $document->mime_type ?? mime_content_type($path);

        return response()->file($path, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="' . $document->titre . '.' . $document->extension . '"'
        ]);
    }

    /**
     * Télécharge un document
     */
    public function downloadDocument($id)
    {
        $user = Auth::user();
        $personnel = $user->personnel;

        if (!$personnel) {
            abort(403, 'Accès non autorisé');
        }

        $document = DocumentAgent::where('id', $id)
            ->where('personnel_id', $personnel->id)
            ->where('visible_employe', true)
            ->firstOrFail();

        if (empty($document->chemin)) {
            abort(404, 'Aucun fichier associé à ce document');
        }

        // Essayer plusieurs chemins possibles (dossiers_agents est le disk utilisé)
        $possiblePaths = [
            storage_path('app/dossiers_agents/' . $document->chemin),
            storage_path('app/public/dossiers_agents/' . $document->chemin),
            storage_path('app/' . $document->chemin),
        ];

        $path = null;
        foreach ($possiblePaths as $possiblePath) {
            if (file_exists($possiblePath)) {
                $path = $possiblePath;
                break;
            }
        }

        if (!$path) {
            abort(404, 'Fichier non trouvé sur le serveur');
        }

        $filename = $document->titre . '.' . $document->extension;

        return response()->download($path, $filename);
    }
}
