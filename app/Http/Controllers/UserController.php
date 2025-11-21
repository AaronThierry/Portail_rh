<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Personnel;
use App\Mail\UserCredentialsMail;
use App\Helpers\PasswordHelper;

class UserController extends Controller
{
    /**
     * Affiche le formulaire de connexion
     */
    public function loginform()
    {
        return view('login');
    }

    /**
     * Affiche le formulaire d'inscription
     */
    public function signupform()
    {
        return view('signup');
    }

    /**
     * Traite la connexion de l'utilisateur (pour les routes web avec session)
     */
    public function login(Request $request)
    {
        // Validation des données
        $validator = Validator::make($request->all(), [
            'courrier' => 'required|email',
            'password' => 'required|min:6',
        ], [
            'courrier.required' => 'L\'adresse e-mail est requise',
            'courrier.email' => 'L\'adresse e-mail doit être valide',
            'password.required' => 'Le mot de passe est requis',
            'password.min' => 'Le mot de passe doit contenir au moins 6 caractères',
        ]);

        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Erreur de validation',
                    'errors' => $validator->errors()
                ], 422);
            }
            return back()->withErrors($validator)->withInput();
        }

        // Tentative de connexion
        $credentials = [
            'email' => $request->courrier,
            'password' => $request->password
        ];

        // Tentative d'authentification
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            // Régénération de la session pour sécurité
            $request->session()->regenerate();

            $user = Auth::user();

            // Vérifier si l'utilisateur doit changer son mot de passe
            if ($user->force_password_change) {
                // Marquer que l'utilisateur doit changer son mot de passe
                $request->session()->put('must_change_password', true);

                // Si c'est une requête JSON (API)
                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Changement de mot de passe requis',
                        'requires_password_change' => true,
                        'redirect' => route('password.change-first')
                    ], 200);
                }

                // Rediriger vers la page de changement de mot de passe
                return redirect()->route('password.change-first')
                    ->with('info', 'Pour des raisons de sécurité, vous devez changer votre mot de passe avant de continuer.');
            }

            // Si l'utilisateur a activé le 2FA, rediriger vers la page de vérification
            if ($user->google2fa_enabled) {
                // Marquer que l'utilisateur a besoin de vérifier le 2FA
                $request->session()->put('2fa_required', true);

                // Si c'est une requête JSON (API)
                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Authentification 2FA requise',
                        'requires_2fa' => true,
                        'redirect' => route('two-factor.show')
                    ], 200);
                }

                // Rediriger vers la page de vérification 2FA
                return redirect()->route('two-factor.show');
            }

            // Si le 2FA n'est pas activé, continuer normalement
            if ($request->expectsJson()) {
                $token = $user->createToken('auth_token')->plainTextToken;

                return response()->json([
                    'success' => true,
                    'message' => 'Connexion réussie',
                    'user' => $user,
                    'token' => $token,
                    'redirect' => route('dashboard')
                ], 200);
            }

            // Sinon, redirection vers le dashboard
            return redirect()->intended(route('dashboard'))->with('success', 'Connexion réussie !');
        }

        // Échec de l'authentification
        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'E-mail ou mot de passe incorrect'
            ], 401);
        }

        return back()->withErrors([
            'courrier' => 'E-mail ou mot de passe incorrect',
        ])->withInput();
    }

    /**
     * Déconnecte l'utilisateur
     */
    public function logout(Request $request)
    {
        // Suppression des tokens Sanctum si présents
        if ($request->user()) {
            $request->user()->tokens()->delete();
        }

        // Déconnexion de la session web
        Auth::logout();

        // Suppression des données de session 2FA
        $request->session()->forget('2fa_verified');
        $request->session()->forget('2fa_required');

        // Invalidation de la session
        $request->session()->invalidate();
        //$request->session()->regenerateToken();

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Déconnexion réussie'
            ], 200);
        }

        return redirect()->route('login')->with('success', 'Vous avez été déconnecté avec succès');
    }

    /**
     * Récupère les informations de l'utilisateur connecté
     */
    public function profile(Request $request)
    {
        $user = $request->user();

        if ($request->expectsJson()) {
            return response()->json([
                'user' => $user
            ], 200);
        }

        return view('profile', compact('user'));
    }

    /**
     * Met à jour le profil de l'utilisateur connecté
     */
    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
        ], [
            'name.required' => 'Le nom est requis',
            'name.min' => 'Le nom doit contenir au moins 3 caractères',
            'email.required' => 'L\'adresse e-mail est requise',
            'email.email' => 'L\'adresse e-mail doit être valide',
            'email.unique' => 'Cette adresse e-mail est déjà utilisée',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
            ]);

            return back()->with('success', 'Profil mis à jour avec succès');
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de la mise à jour du profil')->withInput();
        }
    }

    /**
     * Met à jour le mot de passe de l'utilisateur connecté
     */
    public function updatePassword(Request $request)
    {
        $user = $request->user();

        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ], [
            'current_password.required' => 'Le mot de passe actuel est requis',
            'new_password.required' => 'Le nouveau mot de passe est requis',
            'new_password.min' => 'Le nouveau mot de passe doit contenir au moins 6 caractères',
            'new_password.confirmed' => 'La confirmation du mot de passe ne correspond pas',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Vérifier que le mot de passe actuel est correct
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors([
                'current_password' => 'Le mot de passe actuel est incorrect'
            ])->withInput();
        }

        // Vérifier que le nouveau mot de passe est différent de l'ancien
        if (Hash::check($request->new_password, $user->password)) {
            return back()->withErrors([
                'new_password' => 'Le nouveau mot de passe doit être différent de l\'ancien'
            ])->withInput();
        }

        try {
            $user->update([
                'password' => Hash::make($request->new_password)
            ]);

            // Révoquer tous les tokens Sanctum pour forcer une reconnexion
            $user->tokens()->delete();

            return back()->with('success', 'Mot de passe changé avec succès');
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors du changement de mot de passe')->withInput();
        }
    }

    /**
     * Met à jour l'avatar de l'utilisateur connecté
     */
    public function updateAvatar(Request $request)
    {
        $user = $request->user();

        $validator = Validator::make($request->all(), [
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB max
        ], [
            'avatar.required' => 'Veuillez sélectionner une image',
            'avatar.image' => 'Le fichier doit être une image',
            'avatar.mimes' => 'L\'image doit être au format jpeg, png, jpg ou gif',
            'avatar.max' => 'L\'image ne doit pas dépasser 2 Mo',
        ]);

        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Erreur de validation',
                    'errors' => $validator->errors()
                ], 422);
            }
            return back()->withErrors($validator);
        }

        try {
            // Supprimer l'ancien avatar s'il existe
            if ($user->avatar && file_exists(public_path($user->avatar))) {
                unlink(public_path($user->avatar));
            }

            // Stocker la nouvelle image
            $image = $request->file('avatar');
            $filename = 'avatar_' . $user->id . '_' . time() . '.' . $image->getClientOriginalExtension();

            // Créer le dossier s'il n'existe pas
            if (!file_exists(public_path('storage/avatars'))) {
                mkdir(public_path('storage/avatars'), 0755, true);
            }

            // Déplacer l'image
            $image->move(public_path('storage/avatars'), $filename);

            // Mettre à jour le chemin dans la BD
            $avatarPath = 'storage/avatars/' . $filename;
            $user->update([
                'avatar' => $avatarPath
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Photo de profil mise à jour avec succès',
                    'avatar_url' => asset($avatarPath)
                ], 200);
            }

            return back()->with('success', 'Photo de profil mise à jour avec succès');
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Erreur lors de la mise à jour de la photo',
                    'error' => $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Erreur lors de la mise à jour de la photo');
        }
    }

    /**
     * Affiche la liste des utilisateurs
     */
    public function index()
    {
        // Vérifier que l'utilisateur a un rôle assigné
        if (!auth()->user()->roles()->exists()) {
            return redirect()->route('dashboard')
                ->with('error', 'Votre compte n\'a pas de rôle assigné. Contactez un administrateur.');
        }

        // Vérifier la permission de visualisation
        if (!auth()->user()->can('view-users')) {
            return redirect()->route('dashboard')
                ->with('error', 'Vous n\'avez pas la permission d\'accéder à cette page.');
        }

        // Si l'utilisateur est Super Admin, afficher tous les utilisateurs
        // Sinon, filtrer par entreprise
        $query = User::with(['entreprise', 'roles', 'personnel'])->orderBy('created_at', 'desc');

        // Filtrer par entreprise si l'utilisateur n'est pas Super Admin
        if (!auth()->user()->hasRole('Super Admin') && auth()->user()->entreprise_id) {
            $query->where('entreprise_id', auth()->user()->entreprise_id);
        }

        $users = $query->get();

        // Récupérer les personnels sans compte utilisateur
        $personnels_query = Personnel::whereDoesntHave('user');

        // Filtrer par entreprise si nécessaire
        if (!auth()->user()->hasRole('Super Admin') && auth()->user()->entreprise_id) {
            $personnels_query->where('entreprise_id', auth()->user()->entreprise_id);
        }

        $personnels_sans_compte = $personnels_query->get();

        return view('utilisateurs.index', compact('users', 'personnels_sans_compte'));
    }

    /**
     * Affiche les détails d'un utilisateur
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

        if (request()->expectsJson()) {
            return response()->json([
                'user' => $user
            ], 200);
        }

        return view('utilisateurs.show', compact('user'));
    }

    /**
     * Crée un nouvel utilisateur
     */
    public function store(Request $request)
    {
        // Mapping des rôles pour uniformiser les formats
        $roleMapping = [
            'Super Admin' => 'Super Admin',
            'Admin' => 'Admin',
            'Manager' => 'Manager',
            'Employé' => 'Employé',
            'RH' => 'RH'
        ];

        $validator = Validator::make($request->all(), [
            'personnel_id' => 'required|exists:personnels,id',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:Super Admin,Admin,Manager,Employé,RH',
            'status' => 'required|in:active,inactive'
        ], [
            'personnel_id.required' => 'Veuillez sélectionner un employé',
            'personnel_id.exists' => 'L\'employé sélectionné n\'existe pas',
            'email.required' => 'L\'email est requis',
            'email.email' => 'L\'email doit être une adresse email valide',
            'email.unique' => 'Cet email est déjà utilisé par un autre compte',
            'role.required' => 'Le rôle est requis',
            'role.in' => 'Le rôle sélectionné n\'est pas valide',
            'status.required' => 'Le statut est requis',
            'status.in' => 'Le statut sélectionné n\'est pas valide'
        ]);

        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur de validation',
                    'errors' => $validator->errors()
                ], 422);
            }
            return back()->withErrors($validator)->withInput();
        }

        // Vérifier les permissions de l'utilisateur connecté
        if (!auth()->user()->can('create-users')) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Vous n\'avez pas la permission de créer des utilisateurs'
                ], 403);
            }
            return back()->with('error', 'Vous n\'avez pas la permission de créer des utilisateurs');
        }

        // Récupérer le personnel
        $personnel = Personnel::findOrFail($request->personnel_id);

        // Vérifier que le personnel n'a pas déjà un compte
        if ($personnel->user) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cet employé possède déjà un compte utilisateur'
                ], 400);
            }
            return back()->with('error', 'Cet employé possède déjà un compte utilisateur');
        }

        // Utiliser l'email du formulaire (déjà validé par le validator)
        $email = $request->email;

        // Convertir le rôle au format Spatie
        $spatieRoleName = $roleMapping[$request->role] ?? 'Employé';

        // Vérifier que seul un Super Admin peut créer un Super Admin
        if ($spatieRoleName === 'Super Admin' && !auth()->user()->hasRole('Super Admin')) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Seul un Super Admin peut créer un compte Super Admin'
                ], 403);
            }
            return back()->with('error', 'Seul un Super Admin peut créer un compte Super Admin');
        }

        try {
            DB::beginTransaction();

            // Générer un mot de passe aléatoire
            $randomPassword = PasswordHelper::generateRandomPassword(12);

            // Créer l'utilisateur
            $user = User::create([
                'personnel_id' => $personnel->id,
                'entreprise_id' => $personnel->entreprise_id,
                'name' => $personnel->nom_complet,
                'email' => $email, // Email du personnel
                'password' => Hash::make($randomPassword),
                'phone' => $personnel->telephone_complet ?? null,
                'department' => $personnel->departement->nom ?? null,
                'status' => $request->status,
                'force_password_change' => true // Forcer le changement de mot de passe
            ]);

            // Assigner le rôle via Spatie avec vérification
            if (\Spatie\Permission\Models\Role::where('name', $spatieRoleName)->exists()) {
                $user->assignRole($spatieRoleName);
            } else {
                throw new \Exception("Le rôle '{$spatieRoleName}' n'existe pas dans le système");
            }

            // Lier le personnel à l'utilisateur
            $personnel->user_id = $user->id;
            $personnel->save();

            // Envoyer l'email avec les identifiants (optionnel, peut échouer sans bloquer)
            try {
                Mail::to($user->email)->send(new UserCredentialsMail($user, $randomPassword));
            } catch (\Exception $mailError) {
                \Log::warning('Email non envoyé: ' . $mailError->getMessage());
            }

            DB::commit();

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Compte utilisateur créé avec succès.',
                    'user' => $user->load('roles'),
                    'personnel' => $personnel->fresh('user.roles')
                ], 201);
            }

            return redirect()->route('utilisateurs.index')
                ->with('success', 'Compte utilisateur créé avec succès pour ' . $personnel->nom_complet);
        } catch (\Exception $e) {
            DB::rollBack();

            \Log::error('Erreur création utilisateur: ' . $e->getMessage());

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur lors de la création de l\'utilisateur',
                    'error' => $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Erreur lors de la création de l\'utilisateur: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Met à jour un utilisateur
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Mapping des rôles pour uniformiser les formats
        $roleMapping = [
            'super_admin' => 'Super Admin',
            'admin' => 'Admin',
            'manager' => 'Manager',
            'employee' => 'Employé',
            'hr' => 'RH'
        ];

        $validator = Validator::make($request->all(), [
            'entreprise_id' => 'nullable|exists:entreprises,id',
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:6',
            'phone' => 'nullable|string|max:20',
            'role' => 'required|in:admin,manager,employee,hr,super_admin',
            'department' => 'nullable|string|max:100',
            'status' => 'required|in:active,inactive'
        ], [
            'entreprise_id.exists' => 'L\'entreprise sélectionnée n\'existe pas',
            'name.required' => 'Le nom est requis',
            'name.min' => 'Le nom doit contenir au moins 3 caractères',
            'email.required' => 'L\'adresse e-mail est requise',
            'email.email' => 'L\'adresse e-mail doit être valide',
            'email.unique' => 'Cette adresse e-mail est déjà utilisée',
            'password.min' => 'Le mot de passe doit contenir au moins 6 caractères',
            'role.required' => 'Le rôle est requis',
            'role.in' => 'Le rôle sélectionné n\'est pas valide',
            'status.required' => 'Le statut est requis',
            'status.in' => 'Le statut sélectionné n\'est pas valide'
        ]);

        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Erreur de validation',
                    'errors' => $validator->errors()
                ], 422);
            }
            return back()->withErrors($validator)->withInput();
        }

        // Vérifier les permissions de l'utilisateur connecté
        if (!auth()->user()->can('edit-users')) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Vous n\'avez pas la permission de modifier des utilisateurs'
                ], 403);
            }
            return back()->with('error', 'Vous n\'avez pas la permission de modifier des utilisateurs');
        }

        // Convertir le rôle au format Spatie
        $spatieRoleName = $roleMapping[$request->role] ?? 'Employé';

        // Vérifier que seul un Super Admin peut assigner/modifier le rôle Super Admin
        if ($spatieRoleName === 'Super Admin' && !auth()->user()->hasRole('Super Admin')) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Seul un Super Admin peut assigner le rôle Super Admin'
                ], 403);
            }
            return back()->with('error', 'Seul un Super Admin peut assigner le rôle Super Admin');
        }

        try {
            $data = [
                'entreprise_id' => $request->entreprise_id ?? $user->entreprise_id,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'role' => $request->role,
                'department' => $request->department,
                'status' => $request->status
            ];

            // Mettre à jour le mot de passe uniquement s'il est fourni
            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }

            $user->update($data);

            // Mettre à jour le rôle Spatie si modifié
            if (\Spatie\Permission\Models\Role::where('name', $spatieRoleName)->exists()) {
                $user->syncRoles([$spatieRoleName]); // syncRoles remplace tous les rôles existants
            } else {
                throw new \Exception("Le rôle '{$spatieRoleName}' n'existe pas dans le système");
            }

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Utilisateur mis à jour avec succès',
                    'user' => $user->fresh()
                ], 200);
            }

            return redirect()->route('utilisateurs.index')
                ->with('success', 'Utilisateur mis à jour avec succès');
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Erreur lors de la mise à jour de l\'utilisateur',
                    'error' => $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Erreur lors de la mise à jour de l\'utilisateur')
                ->withInput();
        }
    }

    /**
     * Supprime un utilisateur
     */
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);

            // Empêcher la suppression de son propre compte
            if (Auth::id() === $user->id) {
                if (request()->expectsJson()) {
                    return response()->json([
                        'message' => 'Vous ne pouvez pas supprimer votre propre compte'
                    ], 403);
                }

                return back()->with('error', 'Vous ne pouvez pas supprimer votre propre compte');
            }

            $user->delete();

            if (request()->expectsJson()) {
                return response()->json([
                    'message' => 'Utilisateur supprimé avec succès'
                ], 200);
            }

            return redirect()->route('utilisateurs.index')
                ->with('success', 'Utilisateur supprimé avec succès');
        } catch (\Exception $e) {
            if (request()->expectsJson()) {
                return response()->json([
                    'message' => 'Erreur lors de la suppression de l\'utilisateur',
                    'error' => $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Erreur lors de la suppression de l\'utilisateur');
        }
    }

    /**
     * Affiche le formulaire de changement de mot de passe obligatoire
     */
    public function showFirstPasswordChange()
    {
        // Vérifier que l'utilisateur doit effectivement changer son mot de passe
        if (!auth()->user()->force_password_change) {
            return redirect()->route('dashboard');
        }

        return view('auth.change-password-first');
    }

    /**
     * Traite le changement de mot de passe obligatoire à la première connexion
     */
    public function changeFirstPassword(Request $request)
    {
        $user = auth()->user();

        // Vérifier que l'utilisateur doit effectivement changer son mot de passe
        if (!$user->force_password_change) {
            return redirect()->route('dashboard');
        }

        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ], [
            'current_password.required' => 'Le mot de passe actuel est requis',
            'new_password.required' => 'Le nouveau mot de passe est requis',
            'new_password.min' => 'Le nouveau mot de passe doit contenir au moins 8 caractères',
            'new_password.confirmed' => 'La confirmation du mot de passe ne correspond pas',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Vérifier que le mot de passe actuel est correct
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors([
                'current_password' => 'Le mot de passe actuel est incorrect'
            ])->withInput();
        }

        // Vérifier que le nouveau mot de passe est différent de l'ancien
        if (Hash::check($request->new_password, $user->password)) {
            return back()->withErrors([
                'new_password' => 'Le nouveau mot de passe doit être différent de l\'ancien'
            ])->withInput();
        }

        try {
            // Mettre à jour le mot de passe et retirer le flag de changement obligatoire
            $user->update([
                'password' => Hash::make($request->new_password),
                'force_password_change' => false
            ]);

            // Retirer le flag de session
            $request->session()->forget('must_change_password');

            return redirect()->route('dashboard')
                ->with('success', 'Votre mot de passe a été changé avec succès !');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Erreur lors du changement de mot de passe')
                ->withInput();
        }
    }
}
