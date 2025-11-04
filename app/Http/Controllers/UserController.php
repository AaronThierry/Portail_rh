<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

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

            // Si c'est une requête JSON (API), générer un token
            if ($request->expectsJson()) {
                $token = $user->createToken('auth_token')->plainTextToken;

                return response()->json([
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

        // Invalidation de la session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

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
        $users = User::orderBy('created_at', 'desc')->get();
        return view('utilisateurs.index', compact('users'));
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
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'phone' => 'nullable|string|max:20',
            'role' => 'required|in:admin,manager,employee,hr',
            'department' => 'nullable|string|max:100',
            'status' => 'required|in:active,inactive'
        ], [
            'name.required' => 'Le nom est requis',
            'name.min' => 'Le nom doit contenir au moins 3 caractères',
            'email.required' => 'L\'adresse e-mail est requise',
            'email.email' => 'L\'adresse e-mail doit être valide',
            'email.unique' => 'Cette adresse e-mail est déjà utilisée',
            'password.required' => 'Le mot de passe est requis',
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

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone' => $request->phone,
                'role' => $request->role,
                'department' => $request->department,
                'status' => $request->status
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Utilisateur créé avec succès',
                    'user' => $user
                ], 201);
            }

            return redirect()->route('utilisateurs.index')
                ->with('success', 'Utilisateur créé avec succès');
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Erreur lors de la création de l\'utilisateur',
                    'error' => $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Erreur lors de la création de l\'utilisateur')
                ->withInput();
        }
    }

    /**
     * Met à jour un utilisateur
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:6',
            'phone' => 'nullable|string|max:20',
            'role' => 'required|in:admin,manager,employee,hr',
            'department' => 'nullable|string|max:100',
            'status' => 'required|in:active,inactive'
        ], [
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

        try {
            $data = [
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
}
