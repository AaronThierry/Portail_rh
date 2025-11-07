<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use App\Helpers\PermissionHelper;

/**
 * Controller pour la gestion des permissions
 *
 * Ce controller permet de:
 * - Lister toutes les permissions
 * - Créer de nouvelles permissions
 * - Modifier les permissions existantes
 * - Voir les statistiques d'utilisation
 */
class PermissionController extends Controller
{
    /**
     * Constructeur - Applique les autorisations
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('require.role:Super Admin,Admin')->except(['index']);
        $this->middleware('check.permission:manage-permissions')->only(['store', 'update', 'destroy']);
    }

    /**
     * Affiche la liste de toutes les permissions
     */
    public function index()
    {
        // Récupère toutes les permissions avec leurs rôles associés
        $permissions = Permission::with('roles')
            ->orderBy('name')
            ->get()
            ->map(function ($permission) {
                // Ajoute des métadonnées
                $permission->roles_count = $permission->roles->count();
                $permission->users_count = $this->getUsersCountForPermission($permission);
                $permission->module = $this->extractModule($permission->name);
                $permission->description = PermissionHelper::getPermissionDescription($permission->name);
                return $permission;
            });

        // Groupe les permissions par module
        $groupedPermissions = $permissions->groupBy('module');

        // Statistiques globales
        $stats = [
            'total_permissions' => $permissions->count(),
            'total_modules' => $groupedPermissions->count(),
            'used_permissions' => $permissions->where('roles_count', '>', 0)->count(),
            'unused_permissions' => $permissions->where('roles_count', 0)->count(),
        ];

        return view('parametres.permissions', compact('permissions', 'groupedPermissions', 'stats'));
    }

    /**
     * Affiche les détails d'une permission
     */
    public function show(Permission $permission)
    {
        $permission->load(['roles' => function ($query) {
            $query->withCount('users');
        }]);

        // Récupère les utilisateurs qui ont cette permission
        $users = \App\Models\User::permission($permission)->with('entreprise')->paginate(20);

        $stats = [
            'roles_count' => $permission->roles->count(),
            'users_count' => $this->getUsersCountForPermission($permission),
            'description' => PermissionHelper::getPermissionDescription($permission->name),
        ];

        return view('permissions.show', compact('permission', 'users', 'stats'));
    }

    /**
     * Enregistre une nouvelle permission
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'unique:permissions,name',
                'regex:/^[a-z\-]+$/', // Format: action-module
            ],
            'description' => 'nullable|string|max:500',
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,id',
        ], [
            'name.required' => 'Le nom de la permission est obligatoire.',
            'name.unique' => 'Cette permission existe déjà.',
            'name.regex' => 'Le format doit être: action-module (ex: view-users, create-departements). Lettres minuscules et tirets uniquement.',
        ]);

        DB::beginTransaction();

        try {
            // Crée la permission
            $permission = Permission::create([
                'name' => $validated['name'],
                'guard_name' => 'web',
            ]);

            // Attribue la permission aux rôles sélectionnés
            if (isset($validated['roles']) && count($validated['roles']) > 0) {
                $roles = Role::whereIn('id', $validated['roles'])->get();
                foreach ($roles as $role) {
                    $role->givePermissionTo($permission);
                }
            }

            // Rafraîchit le cache
            PermissionHelper::clearPermissionCache();

            DB::commit();

            return redirect()
                ->route('parametres.permissions')
                ->with('success', "La permission '{$permission->name}' a été créée avec succès.");

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Erreur lors de la création: ' . $e->getMessage());
        }
    }

    /**
     * Met à jour une permission
     */
    public function update(Request $request, Permission $permission)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'unique:permissions,name,' . $permission->id,
                'regex:/^[a-z\-]+$/',
            ],
            'description' => 'nullable|string|max:500',
        ], [
            'name.required' => 'Le nom de la permission est obligatoire.',
            'name.unique' => 'Cette permission existe déjà.',
            'name.regex' => 'Le format doit être: action-module (ex: view-users). Lettres minuscules et tirets uniquement.',
        ]);

        DB::beginTransaction();

        try {
            $permission->update(['name' => $validated['name']]);

            // Rafraîchit le cache
            PermissionHelper::clearPermissionCache();

            DB::commit();

            return redirect()
                ->route('parametres.permissions')
                ->with('success', "La permission '{$permission->name}' a été mise à jour.");

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Erreur lors de la mise à jour: ' . $e->getMessage());
        }
    }

    /**
     * Supprime une permission
     */
    public function destroy(Permission $permission)
    {
        // Vérifie si la permission est utilisée
        $rolesCount = $permission->roles()->count();
        $usersCount = \App\Models\User::permission($permission)->count();

        if ($rolesCount > 0 || $usersCount > 0) {
            return redirect()
                ->route('parametres.permissions')
                ->with('error', "Impossible de supprimer '{$permission->name}'. Elle est utilisée par {$rolesCount} rôle(s) et {$usersCount} utilisateur(s).");
        }

        DB::beginTransaction();

        try {
            $permissionName = $permission->name;
            $permission->delete();

            // Rafraîchit le cache
            PermissionHelper::clearPermissionCache();

            DB::commit();

            return redirect()
                ->route('parametres.permissions')
                ->with('success', "La permission '{$permissionName}' a été supprimée.");

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->route('parametres.permissions')
                ->with('error', 'Erreur lors de la suppression: ' . $e->getMessage());
        }
    }

    // ========================================
    // MÉTHODES PRIVÉES UTILITAIRES
    // ========================================

    /**
     * Compte le nombre d'utilisateurs ayant une permission
     */
    private function getUsersCountForPermission(Permission $permission): int
    {
        try {
            return \App\Models\User::permission($permission)->count();
        } catch (\Exception $e) {
            return 0;
        }
    }

    /**
     * Extrait le module du nom de la permission
     */
    private function extractModule(string $permissionName): string
    {
        $parts = explode('-', $permissionName);
        return count($parts) >= 2 ? end($parts) : 'autres';
    }
}
