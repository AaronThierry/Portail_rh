<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Service;
use App\Models\Departement;
use App\Models\Entreprise;

class ServiceController extends Controller
{
    /**
     * Affiche la liste des services
     */
    public function index()
    {
        $query = Service::with(['entreprise', 'departement']);

        // Si l'utilisateur est super_admin, afficher tous les services
        // Sinon, filtrer par entreprise
        if (auth()->user()->role !== 'super_admin' && auth()->user()->entreprise_id) {
            $query->forEntreprise(auth()->user()->entreprise_id);
        }

        $services = $query->orderBy('created_at', 'desc')->get();
        return view('services.index', compact('services'));
    }

    /**
     * Affiche le formulaire de création
     */
    public function create()
    {
        $entreprises = [];
        $departements = [];

        if (auth()->user()->role === 'super_admin') {
            $entreprises = Entreprise::where('is_active', true)->orderBy('nom')->get();
            $departements = Departement::where('is_active', true)->orderBy('nom')->get();
        } else {
            $departements = Departement::forEntreprise(auth()->user()->entreprise_id)
                ->where('is_active', true)
                ->orderBy('nom')
                ->get();
        }

        return view('services.create', compact('entreprises', 'departements'));
    }

    /**
     * Enregistre un nouveau service
     */
    public function store(Request $request)
    {
        $rules = [
            'departement_id' => 'required|exists:departements,id',
            'nom' => 'required|string|max:255',
            'code' => 'nullable|string|max:50|unique:services,code',
            'description' => 'nullable|string',
            'is_global' => 'boolean',
        ];

        if (auth()->user()->role === 'super_admin') {
            $rules['entreprise_id'] = 'nullable|exists:entreprises,id';
        }

        $validator = Validator::make($request->all(), $rules, [
            'departement_id.required' => 'Le département est requis',
            'departement_id.exists' => 'Le département sélectionné n\'existe pas',
            'nom.required' => 'Le nom du service est requis',
            'code.unique' => 'Ce code est déjà utilisé',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $data = $request->only(['departement_id', 'nom', 'code', 'description']);

            // Déterminer l'entreprise_id
            if (auth()->user()->role === 'super_admin') {
                $data['entreprise_id'] = $request->entreprise_id;
                $data['is_global'] = $request->has('is_global') && $request->is_global;
            } else {
                $data['entreprise_id'] = auth()->user()->entreprise_id;
                $data['is_global'] = false;
            }

            $data['is_active'] = true;

            Service::create($data);

            return redirect()->route('services.index')
                ->with('success', 'Service créé avec succès');
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de la création du service: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Affiche les détails d'un service
     */
    public function show($id)
    {
        $service = Service::with(['entreprise', 'departement'])->findOrFail($id);

        // Vérifier les permissions
        if (auth()->user()->role !== 'super_admin' &&
            $service->entreprise_id &&
            $service->entreprise_id !== auth()->user()->entreprise_id) {
            abort(403, 'Accès non autorisé');
        }

        return view('services.show', compact('service'));
    }

    /**
     * Affiche le formulaire d'édition
     */
    public function edit($id)
    {
        $service = Service::findOrFail($id);

        // Vérifier les permissions
        if (auth()->user()->role !== 'super_admin' &&
            $service->entreprise_id &&
            $service->entreprise_id !== auth()->user()->entreprise_id) {
            abort(403, 'Accès non autorisé');
        }

        $entreprises = [];
        $departements = [];

        if (auth()->user()->role === 'super_admin') {
            $entreprises = Entreprise::where('is_active', true)->orderBy('nom')->get();
            $departements = Departement::where('is_active', true)->orderBy('nom')->get();
        } else {
            $departements = Departement::forEntreprise(auth()->user()->entreprise_id)
                ->where('is_active', true)
                ->orderBy('nom')
                ->get();
        }

        return view('services.edit', compact('service', 'entreprises', 'departements'));
    }

    /**
     * Met à jour un service
     */
    public function update(Request $request, $id)
    {
        $service = Service::findOrFail($id);

        // Vérifier les permissions
        if (auth()->user()->role !== 'super_admin' &&
            $service->entreprise_id &&
            $service->entreprise_id !== auth()->user()->entreprise_id) {
            abort(403, 'Accès non autorisé');
        }

        $rules = [
            'departement_id' => 'required|exists:departements,id',
            'nom' => 'required|string|max:255',
            'code' => 'nullable|string|max:50|unique:services,code,' . $id,
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ];

        if (auth()->user()->role === 'super_admin') {
            $rules['entreprise_id'] = 'nullable|exists:entreprises,id';
            $rules['is_global'] = 'boolean';
        }

        $validator = Validator::make($request->all(), $rules, [
            'departement_id.required' => 'Le département est requis',
            'nom.required' => 'Le nom du service est requis',
            'code.unique' => 'Ce code est déjà utilisé',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $data = $request->only(['departement_id', 'nom', 'code', 'description']);
            $data['is_active'] = $request->has('is_active');

            if (auth()->user()->role === 'super_admin') {
                $data['entreprise_id'] = $request->entreprise_id;
                $data['is_global'] = $request->has('is_global');
            }

            $service->update($data);

            return redirect()->route('services.index')
                ->with('success', 'Service mis à jour avec succès');
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de la mise à jour: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Supprime un service
     */
    public function destroy($id)
    {
        try {
            $service = Service::findOrFail($id);

            // Vérifier les permissions
            if (auth()->user()->role !== 'super_admin' &&
                $service->entreprise_id &&
                $service->entreprise_id !== auth()->user()->entreprise_id) {
                abort(403, 'Accès non autorisé');
            }

            $service->delete();

            return redirect()->route('services.index')
                ->with('success', 'Service supprimé avec succès');
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de la suppression: ' . $e->getMessage());
        }
    }

    /**
     * API: Récupère les départements d'une entreprise (pour les selects dynamiques)
     */
    public function getDepartementsByEntreprise($entrepriseId)
    {
        $departements = Departement::forEntreprise($entrepriseId)
            ->where('is_active', true)
            ->orderBy('nom')
            ->get(['id', 'nom', 'code']);

        return response()->json($departements);
    }
}
