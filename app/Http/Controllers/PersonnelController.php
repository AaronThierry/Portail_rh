<?php

namespace App\Http\Controllers;

use App\Models\Personnel;
use App\Models\User;
use App\Models\Entreprise;
use App\Models\Departement;
use App\Models\Service;
use App\Http\Requests\StorePersonnelRequest;
use App\Http\Requests\UpdatePersonnelRequest;
use App\Http\Requests\AssignUserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class PersonnelController extends Controller
{
    /**
     * Afficher la liste du personnel
     */
    public function index(Request $request)
    {
        $query = Personnel::with(['entreprise', 'departement', 'service', 'user']);

        // Filtrer par entreprise sauf pour Super Admin
        if (!auth()->user()->hasRole('Super Admin')) {
            $query->forEntreprise(auth()->user()->entreprise_id);
        }

        // Recherche
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('matricule', 'like', "%{$search}%")
                    ->orWhere('nom', 'like', "%{$search}%")
                    ->orWhere('prenoms', 'like', "%{$search}%")
                    ->orWhere('telephone', 'like', "%{$search}%")
                    ->orWhere('poste', 'like', "%{$search}%");
            });
        }

        // Filtre par département
        if ($request->has('departement_id') && $request->departement_id) {
            $query->where('departement_id', $request->departement_id);
        }

        // Filtre par service
        if ($request->has('service_id') && $request->service_id) {
            $query->where('service_id', $request->service_id);
        }

        // Filtre par type de contrat
        if ($request->has('type_contrat') && $request->type_contrat) {
            $query->where('type_contrat', $request->type_contrat);
        }

        // Filtre par statut compte utilisateur
        if ($request->has('has_user')) {
            if ($request->has_user === 'yes') {
                $query->avecCompte();
            } elseif ($request->has_user === 'no') {
                $query->sansCompte();
            }
        }

        $personnels = $query->orderBy('created_at', 'desc')->paginate(15);

        $entreprises = Entreprise::where('is_active', true)->get();

        // Charger départements et services selon le rôle
        if (auth()->user()->hasRole('Super Admin')) {
            $departements = Departement::where('is_active', true)->get();
            $services = Service::where('is_active', true)->get();
        } else {
            $departements = Departement::forEntreprise(auth()->user()->entreprise_id)
                ->where('is_active', true)
                ->get();
            $services = Service::forEntreprise(auth()->user()->entreprise_id)
                ->where('is_active', true)
                ->get();
        }

        return view('personnels.index', compact('personnels', 'entreprises', 'departements', 'services'));
    }

    /**
     * Afficher les détails d'un personnel
     */
    public function show($id)
    {
        $personnel = Personnel::with([
                'entreprise',
                'departement',
                'service',
                'user.roles'
            ])
            ->findOrFail($id);

        // Vérifier que l'utilisateur peut voir ce personnel
        if ($personnel->entreprise_id !== auth()->user()->entreprise_id && !auth()->user()->hasRole('Super Admin')) {
            abort(403, 'Accès non autorisé');
        }

        $roles = Role::all();

        // Charger les départements actifs de l'entreprise du personnel
        // Inclure les départements globaux (is_global = true) ET les départements spécifiques à l'entreprise
        $departements = Departement::where('is_active', true)
            ->where(function ($query) use ($personnel) {
                $query->where('is_global', true)
                      ->orWhere('entreprise_id', $personnel->entreprise_id);
            })
            ->orderBy('nom')
            ->get();

        return view('personnels.show', compact('personnel', 'roles', 'departements'));
    }

    /**
     * Enregistrer un nouveau personnel
     */
    public function store(StorePersonnelRequest $request)
    {
        try {
            DB::beginTransaction();

            $data = $request->validated();

            // Générer le matricule si non fourni
            if (empty($data['matricule'])) {
                $data['matricule'] = Personnel::genererMatricule($data['entreprise_id']);
            }

            // Upload de la photo si fournie
            if ($request->hasFile('photo')) {
                $data['photo'] = $request->file('photo')->store('personnels/photos', 'public');
            }

            // Assurer que l'entreprise_id est celui de l'utilisateur connecté (sauf Super Admin)
            if (!auth()->user()->hasRole('Super Admin')) {
                $data['entreprise_id'] = auth()->user()->entreprise_id;
            }

            $personnel = Personnel::create($data);

            DB::commit();

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Personnel enregistré avec succès',
                    'data' => $personnel->load(['entreprise', 'departement', 'service'])
                ], 201);
            }

            return redirect()->route('personnels.show', $personnel->id)
                ->with('success', 'Personnel enregistré avec succès');
        } catch (\Exception $e) {
            DB::rollBack();

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur lors de l\'enregistrement du personnel',
                    'error' => $e->getMessage()
                ], 500);
            }

            return redirect()->back()
                ->withInput()
                ->with('error', 'Erreur lors de l\'enregistrement du personnel');
        }
    }

    /**
     * Mettre à jour un personnel
     */
    public function update(UpdatePersonnelRequest $request, $id)
    {
        try {
            DB::beginTransaction();

            $personnel = Personnel::findOrFail($id);

            // Vérifier les permissions
            if ($personnel->entreprise_id !== auth()->user()->entreprise_id && !auth()->user()->hasRole('Super Admin')) {
                abort(403, 'Accès non autorisé');
            }

            $data = $request->validated();

            // Upload de la nouvelle photo si fournie
            if ($request->hasFile('photo')) {
                // Supprimer l'ancienne photo
                if ($personnel->photo) {
                    Storage::disk('public')->delete($personnel->photo);
                }
                $data['photo'] = $request->file('photo')->store('personnels/photos', 'public');
            }

            $personnel->update($data);

            DB::commit();

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Personnel mis à jour avec succès',
                    'data' => $personnel->load(['entreprise', 'departement', 'service'])
                ]);
            }

            return redirect()->route('personnels.show', $personnel->id)
                ->with('success', 'Personnel mis à jour avec succès');
        } catch (\Exception $e) {
            DB::rollBack();

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur lors de la mise à jour du personnel',
                    'error' => $e->getMessage()
                ], 500);
            }

            return redirect()->back()
                ->withInput()
                ->with('error', 'Erreur lors de la mise à jour du personnel');
        }
    }

    /**
     * Supprimer un personnel (soft delete)
     */
    public function destroy($id)
    {
        try {
            $personnel = Personnel::findOrFail($id);

            // Vérifier les permissions
            if ($personnel->entreprise_id !== auth()->user()->entreprise_id && !auth()->user()->hasRole('Super Admin')) {
                abort(403, 'Accès non autorisé');
            }

            // Ne pas supprimer si le personnel a un compte utilisateur actif
            if ($personnel->hasUser()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Impossible de supprimer un personnel ayant un compte utilisateur actif'
                ], 422);
            }

            $personnel->delete();

            return response()->json([
                'success' => true,
                'message' => 'Personnel supprimé avec succès'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression du personnel',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Assigner un compte utilisateur à un personnel
     */
    public function assignUser(AssignUserRequest $request, $id)
    {
        try {
            DB::beginTransaction();

            $personnel = Personnel::findOrFail($id);

            // Vérifier les permissions
            if ($personnel->entreprise_id !== auth()->user()->entreprise_id && !auth()->user()->hasRole('Super Admin')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Accès non autorisé'
                ], 403);
            }

            // Vérifier si le personnel a déjà un compte
            if ($personnel->hasUser()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ce personnel possède déjà un compte utilisateur'
                ], 422);
            }

            $data = $request->validated();

            // Utiliser l'email du personnel pour le compte utilisateur
            $email = $personnel->email;

            // Vérifier que le personnel a un email
            if (!$email) {
                return response()->json([
                    'success' => false,
                    'message' => 'Le personnel doit avoir un email pour créer un compte utilisateur'
                ], 422);
            }

            // Vérifier que l'email n'est pas déjà utilisé
            if (User::where('email', $email)->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cet email est déjà utilisé par un autre compte utilisateur'
                ], 422);
            }

            // Générer un mot de passe aléatoire si non fourni
            $randomPassword = $data['password'] ?? \Str::random(12);

            // Créer le compte utilisateur
            $user = User::create([
                'entreprise_id' => $personnel->entreprise_id,
                'personnel_id' => $personnel->id,
                'name' => $personnel->nom_complet,
                'email' => $email,
                'password' => Hash::make($randomPassword),
                'phone' => $personnel->telephone_complet,
                'department' => $personnel->departement->nom ?? null,
                'status' => $data['status'] ?? 'active',
                'force_password_change' => true
            ]);

            // Assigner le rôle
            if (isset($data['role'])) {
                $user->assignRole($data['role']);
            }

            // Lier le personnel à l'utilisateur
            $personnel->user_id = $user->id;
            $personnel->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Compte utilisateur créé et assigné avec succès',
                'user' => $user->load('roles'),
                'personnel' => $personnel->load('user.roles')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            \Log::error('Erreur assignUser: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la création du compte utilisateur',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Dissocier le compte utilisateur d'un personnel
     */
    public function detachUser($id)
    {
        try {
            DB::beginTransaction();

            $personnel = Personnel::findOrFail($id);

            // Vérifier les permissions
            if ($personnel->entreprise_id !== auth()->user()->entreprise_id && !auth()->user()->hasRole('Super Admin')) {
                abort(403, 'Accès non autorisé');
            }

            if (!$personnel->hasUser()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ce personnel n\'a pas de compte utilisateur'
                ], 422);
            }

            $userId = $personnel->user_id;
            $personnel->user_id = null;
            $personnel->save();

            // Optionnel : désactiver le compte utilisateur au lieu de le supprimer
            $user = User::find($userId);
            if ($user) {
                $user->status = 'inactive';
                $user->save();
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Compte utilisateur dissocié avec succès'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la dissociation du compte',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Récupérer les services d'un département
     */
    public function getServicesByDepartement($departementId)
    {
        $services = Service::where('departement_id', $departementId)
            ->where('is_active', true)
            ->get(['id', 'nom', 'code']);

        return response()->json([
            'success' => true,
            'data' => $services
        ]);
    }

    /**
     * Export du personnel (PDF, Excel, etc.)
     */
    public function export(Request $request)
    {
        // À implémenter selon les besoins
        // Utiliser Laravel Excel ou DomPDF
    }
}
