<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\Entreprise;

class EntrepriseController extends Controller
{
    /**
     * Affiche la liste des entreprises
     */
    public function index()
    {
        $entreprises = Entreprise::orderBy('created_at', 'desc')->get();
        return view('entreprises.index', compact('entreprises'));
    }

    /**
     * Affiche le formulaire de création
     */
    public function create()
    {
        return view('entreprises.create');
    }

    /**
     * Enregistre une nouvelle entreprise
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255',
            'sigle' => 'nullable|string|max:50',
            'email' => 'required|email|unique:entreprises,email',
            'telephone' => 'nullable|string|max:20',
            'adresse' => 'nullable|string|max:255',
            'ville' => 'nullable|string|max:100',
            'pays' => 'required|string|max:100',
            'code_postal' => 'nullable|string|max:20',
            'site_web' => 'nullable|url|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
            'secteur_activite' => 'nullable|string|max:100',
            'nombre_employes' => 'nullable|integer|min:1',
            'numero_registre' => 'nullable|string|max:100',
            'numero_fiscal' => 'nullable|string|max:100',
        ], [
            'nom.required' => 'Le nom de l\'entreprise est requis',
            'email.required' => 'L\'adresse e-mail est requise',
            'email.email' => 'L\'adresse e-mail doit être valide',
            'email.unique' => 'Cette adresse e-mail est déjà utilisée',
            'pays.required' => 'Le pays est requis',
            'logo.image' => 'Le fichier doit être une image',
            'logo.max' => 'Le logo ne doit pas dépasser 2 Mo',
            'site_web.url' => 'L\'URL du site web n\'est pas valide',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $data = $request->except('logo');

            // Gestion du logo
            if ($request->hasFile('logo')) {
                $logo = $request->file('logo');
                $filename = 'logo_' . time() . '.' . $logo->getClientOriginalExtension();

                if (!file_exists(public_path('storage/logos'))) {
                    mkdir(public_path('storage/logos'), 0755, true);
                }

                $logo->move(public_path('storage/logos'), $filename);
                $data['logo'] = 'storage/logos/' . $filename;
            }

            Entreprise::create($data);

            return redirect()->route('entreprises.index')
                ->with('success', 'Entreprise créée avec succès');
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de la création de l\'entreprise: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Affiche les détails d'une entreprise
     */
    public function show($id)
    {
        $entreprise = Entreprise::with(['utilisateurs', 'departements', 'services'])->findOrFail($id);
        return view('entreprises.show', compact('entreprise'));
    }

    /**
     * Affiche le formulaire d'édition
     */
    public function edit($id)
    {
        $entreprise = Entreprise::findOrFail($id);
        return view('entreprises.edit', compact('entreprise'));
    }

    /**
     * Met à jour une entreprise
     */
    public function update(Request $request, $id)
    {
        $entreprise = Entreprise::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255',
            'sigle' => 'nullable|string|max:50',
            'email' => 'required|email|unique:entreprises,email,' . $id,
            'telephone' => 'nullable|string|max:20',
            'adresse' => 'nullable|string|max:255',
            'ville' => 'nullable|string|max:100',
            'pays' => 'required|string|max:100',
            'code_postal' => 'nullable|string|max:20',
            'site_web' => 'nullable|url|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
            'secteur_activite' => 'nullable|string|max:100',
            'nombre_employes' => 'nullable|integer|min:1',
            'numero_registre' => 'nullable|string|max:100',
            'numero_fiscal' => 'nullable|string|max:100',
            'is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $data = $request->except('logo');

            // Gestion du logo
            if ($request->hasFile('logo')) {
                // Supprimer l'ancien logo
                if ($entreprise->logo && file_exists(public_path($entreprise->logo))) {
                    unlink(public_path($entreprise->logo));
                }

                $logo = $request->file('logo');
                $filename = 'logo_' . time() . '.' . $logo->getClientOriginalExtension();

                if (!file_exists(public_path('storage/logos'))) {
                    mkdir(public_path('storage/logos'), 0755, true);
                }

                $logo->move(public_path('storage/logos'), $filename);
                $data['logo'] = 'storage/logos/' . $filename;
            }

            $entreprise->update($data);

            return redirect()->route('entreprises.index')
                ->with('success', 'Entreprise mise à jour avec succès');
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de la mise à jour: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Supprime une entreprise
     */
    public function destroy($id)
    {
        try {
            $entreprise = Entreprise::findOrFail($id);

            // Vérifier s'il y a des utilisateurs associés
            if ($entreprise->utilisateurs()->count() > 0) {
                return back()->with('error', 'Impossible de supprimer cette entreprise car elle a des utilisateurs associés');
            }

            // Supprimer le logo
            if ($entreprise->logo && file_exists(public_path($entreprise->logo))) {
                unlink(public_path($entreprise->logo));
            }

            $entreprise->delete();

            return redirect()->route('entreprises.index')
                ->with('success', 'Entreprise supprimée avec succès');
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de la suppression: ' . $e->getMessage());
        }
    }

    /**
     * Toggle l'état actif/inactif d'une entreprise
     */
    public function toggleStatus($id)
    {
        try {
            $entreprise = Entreprise::findOrFail($id);
            $entreprise->update(['is_active' => !$entreprise->is_active]);

            $status = $entreprise->is_active ? 'activée' : 'désactivée';
            return back()->with('success', "Entreprise {$status} avec succès");
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors du changement de statut');
        }
    }
}
