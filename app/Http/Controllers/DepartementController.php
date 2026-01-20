<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Departement;
use App\Models\Entreprise;

class DepartementController extends Controller
{
    /**
     * Affiche la liste des départements
     */
    public function index()
    {
        $query = Departement::with(['entreprise', 'services']);

        // Si l'utilisateur est super_admin, afficher tous les départements
        // Sinon, filtrer par entreprise
        if (auth()->user()->role !== 'super_admin' && auth()->user()->entreprise_id) {
            $query->forEntreprise(auth()->user()->entreprise_id);
        }

        $departements = $query->orderBy('created_at', 'desc')->get();
        return view('departements.index', compact('departements'));
    }

    /**
     * Affiche le formulaire de création
     */
    public function create()
    {
        $entreprises = [];

        // Si super_admin, peut créer pour n'importe quelle entreprise
        if (auth()->user()->role === 'super_admin') {
            $entreprises = Entreprise::where('is_active', true)->orderBy('nom')->get();
        }

        return view('departements.create', compact('entreprises'));
    }

    /**
     * Enregistre un nouveau département
     */
    public function store(Request $request)
    {
        $rules = [
            'nom' => 'required|string|max:255',
            'code' => 'nullable|string|max:50|unique:departements,code',
            'description' => 'nullable|string',
            'is_global' => 'boolean',
        ];

        // Si super_admin, peut choisir l'entreprise
        if (auth()->user()->role === 'super_admin') {
            $rules['entreprise_id'] = 'nullable|exists:entreprises,id';
        }

        $validator = Validator::make($request->all(), $rules, [
            'nom.required' => 'Le nom du département est requis',
            'code.unique' => 'Ce code est déjà utilisé',
            'entreprise_id.exists' => 'L\'entreprise sélectionnée n\'existe pas',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $data = $request->only(['nom', 'code', 'description']);

            // Déterminer l'entreprise_id
            if (auth()->user()->role === 'super_admin') {
                $data['entreprise_id'] = $request->entreprise_id;
                $data['is_global'] = $request->has('is_global') && $request->is_global;
            } else {
                $data['entreprise_id'] = auth()->user()->entreprise_id;
                $data['is_global'] = false;
            }

            $data['is_active'] = true;

            Departement::create($data);

            return redirect()->route('admin.departements.index')
                ->with('success', 'Département créé avec succès');
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de la création du département: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Affiche les détails d'un département
     */
    public function show($id)
    {
        $departement = Departement::with(['entreprise', 'services.personnels'])->findOrFail($id);

        // Vérifier les permissions
        if (auth()->user()->role !== 'super_admin' &&
            $departement->entreprise_id &&
            $departement->entreprise_id !== auth()->user()->entreprise_id) {
            abort(403, 'Accès non autorisé');
        }

        return view('departements.show', compact('departement'));
    }

    /**
     * Affiche le formulaire d'édition
     */
    public function edit($id)
    {
        $departement = Departement::findOrFail($id);

        // Vérifier les permissions
        if (auth()->user()->role !== 'super_admin' &&
            $departement->entreprise_id &&
            $departement->entreprise_id !== auth()->user()->entreprise_id) {
            abort(403, 'Accès non autorisé');
        }

        $entreprises = [];
        if (auth()->user()->role === 'super_admin') {
            $entreprises = Entreprise::where('is_active', true)->orderBy('nom')->get();
        }

        return view('departements.edit', compact('departement', 'entreprises'));
    }

    /**
     * Met à jour un département
     */
    public function update(Request $request, $id)
    {
        $departement = Departement::findOrFail($id);

        // Vérifier les permissions
        if (auth()->user()->role !== 'super_admin' &&
            $departement->entreprise_id &&
            $departement->entreprise_id !== auth()->user()->entreprise_id) {
            abort(403, 'Accès non autorisé');
        }

        $rules = [
            'nom' => 'required|string|max:255',
            'code' => 'nullable|string|max:50|unique:departements,code,' . $id,
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ];

        if (auth()->user()->role === 'super_admin') {
            $rules['entreprise_id'] = 'nullable|exists:entreprises,id';
            $rules['is_global'] = 'boolean';
        }

        $validator = Validator::make($request->all(), $rules, [
            'nom.required' => 'Le nom du département est requis',
            'code.unique' => 'Ce code est déjà utilisé',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $data = $request->only(['nom', 'code', 'description']);
            $data['is_active'] = $request->has('is_active');

            if (auth()->user()->role === 'super_admin') {
                $data['entreprise_id'] = $request->entreprise_id;
                $data['is_global'] = $request->has('is_global');
            }

            $departement->update($data);

            return redirect()->route('admin.departements.index')
                ->with('success', 'Département mis à jour avec succès');
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de la mise à jour: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Supprime un département
     */
    public function destroy($id)
    {
        try {
            $departement = Departement::findOrFail($id);

            // Vérifier les permissions
            if (auth()->user()->role !== 'super_admin' &&
                $departement->entreprise_id &&
                $departement->entreprise_id !== auth()->user()->entreprise_id) {
                abort(403, 'Accès non autorisé');
            }

            // Vérifier s'il y a des services associés
            if ($departement->services()->count() > 0) {
                return back()->with('error', 'Impossible de supprimer ce département car il a des services associés');
            }

            $departement->delete();

            return redirect()->route('admin.departements.index')
                ->with('success', 'Département supprimé avec succès');
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de la suppression: ' . $e->getMessage());
        }
    }
}
