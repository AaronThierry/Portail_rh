<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Personnel;
use App\Models\DocumentAgent;

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
     * Affiche les documents de l'employé
     */
    public function documents()
    {
        $user = Auth::user();
        $personnel = $user->personnel;

        $documents = $personnel ? $personnel->documents()->with('categorie')->orderBy('created_at', 'desc')->get() : collect([]);

        return view('espace-employe.documents', compact('personnel', 'documents'));
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
            ->firstOrFail();

        if (empty($document->fichier)) {
            abort(404, 'Aucun fichier associé à ce document');
        }

        $path = storage_path('app/public/' . $document->fichier);

        if (!file_exists($path)) {
            abort(404, 'Fichier non trouvé sur le serveur');
        }

        $mimeType = mime_content_type($path);

        return response()->file($path, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="' . $document->nom . '"'
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
            ->firstOrFail();

        if (empty($document->fichier)) {
            abort(404, 'Aucun fichier associé à ce document');
        }

        $path = storage_path('app/public/' . $document->fichier);

        if (!file_exists($path)) {
            abort(404, 'Fichier non trouvé sur le serveur');
        }

        $extension = pathinfo($document->fichier, PATHINFO_EXTENSION);
        $filename = $document->nom . '.' . $extension;

        return response()->download($path, $filename);
    }
}
