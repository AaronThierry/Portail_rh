<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Controller unifié pour la gestion des Rôles et Permissions
 *
 * Gère le CRUD complet avec interface moderne et Ajax
 */
class RolePermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('check.permission:manage-permissions');
    }

    // ==================== DASHBOARD PRINCIPAL ====================

    /**
     * Affiche le dashboard principal de gestion
     */
    public function index()
    {
        $roles = Role::withCount(['permissions', 'users'])->get();
        $permissions = Permission::withCount('roles')->get();

        // Grouper les permissions par module
        $groupedPermissions = $this->groupPermissions($permissions);

        // Statistiques
        $stats = [
            'total_roles' => $roles->count(),
            'total_permissions' => $permissions->count(),
            'total_users' => \App\Models\User::role($roles)->count(),
        ];

        return view('admin.roles-permissions.index', compact('roles', 'permissions', 'groupedPermissions', 'stats'));
    }

    // ==================== GESTION DES RÔLES ====================

    /**
     * Créer un nouveau rôle
     */
    public function storeRole(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:roles,name|regex:/^[a-zA-ZÀ-ÿ\s\-_]+$/',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id',
        ], [
            'name.required' => 'Le nom du rôle est obligatoire',
            'name.unique' => 'Ce rôle existe déjà',
            'name.regex' => 'Le nom ne peut contenir que des lettres, espaces et tirets',
        ]);

        DB::beginTransaction();
        try {
            $role = Role::create(['name' => $validated['name'], 'guard_name' => 'web']);

            if (isset($validated['permissions'])) {
                $role->syncPermissions($validated['permissions']);
            }

            app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

            Log::info('Rôle créé', ['role' => $role->name, 'user' => auth()->id()]);

            DB::commit();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => "Le rôle '{$role->name}' a été créé avec succès",
                    'role' => $role->load('permissions'),
                ]);
            }

            return redirect()->back()->with('success', "Le rôle '{$role->name}' a été créé");

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erreur création rôle', ['error' => $e->getMessage()]);

            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Erreur lors de la création'], 500);
            }

            return redirect()->back()->with('error', 'Erreur: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Modifier un rôle
     */
    public function updateRole(Request $request, Role $role)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:roles,name,'.$role->id.'|regex:/^[a-zA-ZÀ-ÿ\s\-_]+$/',
        ]);

        DB::beginTransaction();
        try {
            $role->update(['name' => $validated['name']]);

            app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

            Log::info('Rôle modifié', ['role' => $role->name, 'user' => auth()->id()]);

            DB::commit();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Rôle modifié avec succès',
                    'role' => $role,
                ]);
            }

            return redirect()->back()->with('success', 'Rôle modifié avec succès');

        } catch (\Exception $e) {
            DB::rollBack();

            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Erreur lors de la modification'], 500);
            }

            return redirect()->back()->with('error', 'Erreur: ' . $e->getMessage());
        }
    }

    /**
     * Supprimer un rôle
     */
    public function destroyRole(Request $request, Role $role)
    {
        $protectedRoles = ['Super Admin', 'Admin', 'RH', 'Manager', 'Employé'];

        if (in_array($role->name, $protectedRoles)) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Ce rôle est protégé'], 403);
            }
            return redirect()->back()->with('error', 'Ce rôle est protégé et ne peut être supprimé');
        }

        $usersCount = $role->users()->count();
        if ($usersCount > 0) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => "Ce rôle est utilisé par {$usersCount} utilisateur(s)"], 403);
            }
            return redirect()->back()->with('error', "Ce rôle est utilisé par {$usersCount} utilisateur(s)");
        }

        DB::beginTransaction();
        try {
            $roleName = $role->name;
            $role->syncPermissions([]);
            $role->delete();

            app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

            Log::info('Rôle supprimé', ['role' => $roleName, 'user' => auth()->id()]);

            DB::commit();

            if ($request->ajax()) {
                return response()->json(['success' => true, 'message' => 'Rôle supprimé avec succès']);
            }

            return redirect()->back()->with('success', 'Rôle supprimé avec succès');

        } catch (\Exception $e) {
            DB::rollBack();

            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Erreur lors de la suppression'], 500);
            }

            return redirect()->back()->with('error', 'Erreur: ' . $e->getMessage());
        }
    }

    /**
     * Synchroniser les permissions d'un rôle
     */
    public function syncPermissions(Request $request, Role $role)
    {
        $validated = $request->validate([
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        DB::beginTransaction();
        try {
            $permissions = $validated['permissions'] ?? [];
            $role->syncPermissions($permissions);

            app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

            Log::info('Permissions synchronisées', [
                'role' => $role->name,
                'count' => count($permissions),
                'user' => auth()->id()
            ]);

            DB::commit();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Permissions mises à jour avec succès',
                    'count' => count($permissions),
                ]);
            }

            return redirect()->back()->with('success', 'Permissions mises à jour avec succès');

        } catch (\Exception $e) {
            DB::rollBack();

            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Erreur lors de la synchronisation'], 500);
            }

            return redirect()->back()->with('error', 'Erreur: ' . $e->getMessage());
        }
    }

    // ==================== GESTION DES PERMISSIONS ====================

    /**
     * Créer une nouvelle permission
     */
    public function storePermission(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:permissions,name|regex:/^[a-z\-]+$/',
            'description' => 'nullable|string|max:255',
        ], [
            'name.required' => 'Le nom de la permission est obligatoire',
            'name.unique' => 'Cette permission existe déjà',
            'name.regex' => 'Format requis: action-resource (ex: view-users)',
        ]);

        DB::beginTransaction();
        try {
            $permission = Permission::create([
                'name' => $validated['name'],
                'guard_name' => 'web',
            ]);

            app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

            Log::info('Permission créée', ['permission' => $permission->name, 'user' => auth()->id()]);

            DB::commit();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => "Permission '{$permission->name}' créée avec succès",
                    'permission' => $permission,
                ]);
            }

            return redirect()->back()->with('success', "Permission '{$permission->name}' créée");

        } catch (\Exception $e) {
            DB::rollBack();

            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Erreur lors de la création'], 500);
            }

            return redirect()->back()->with('error', 'Erreur: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Modifier une permission
     */
    public function updatePermission(Request $request, Permission $permission)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:permissions,name,'.$permission->id.'|regex:/^[a-z\-]+$/',
        ]);

        DB::beginTransaction();
        try {
            $permission->update(['name' => $validated['name']]);

            app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

            Log::info('Permission modifiée', ['permission' => $permission->name, 'user' => auth()->id()]);

            DB::commit();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Permission modifiée avec succès',
                    'permission' => $permission,
                ]);
            }

            return redirect()->back()->with('success', 'Permission modifiée avec succès');

        } catch (\Exception $e) {
            DB::rollBack();

            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Erreur lors de la modification'], 500);
            }

            return redirect()->back()->with('error', 'Erreur: ' . $e->getMessage());
        }
    }

    /**
     * Supprimer une permission
     */
    public function destroyPermission(Request $request, Permission $permission)
    {
        $rolesCount = $permission->roles()->count();

        if ($rolesCount > 0) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => "Cette permission est utilisée par {$rolesCount} rôle(s)"
                ], 403);
            }
            return redirect()->back()->with('error', "Cette permission est utilisée par {$rolesCount} rôle(s)");
        }

        DB::beginTransaction();
        try {
            $permissionName = $permission->name;
            $permission->delete();

            app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

            Log::info('Permission supprimée', ['permission' => $permissionName, 'user' => auth()->id()]);

            DB::commit();

            if ($request->ajax()) {
                return response()->json(['success' => true, 'message' => 'Permission supprimée avec succès']);
            }

            return redirect()->back()->with('success', 'Permission supprimée avec succès');

        } catch (\Exception $e) {
            DB::rollBack();

            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Erreur lors de la suppression'], 500);
            }

            return redirect()->back()->with('error', 'Erreur: ' . $e->getMessage());
        }
    }

    // ==================== API / AJAX ====================

    /**
     * Récupérer les permissions d'un rôle (API)
     */
    public function getRolePermissions(Role $role)
    {
        return response()->json([
            'role' => $role->name,
            'permissions' => $role->permissions->pluck('id')->toArray(),
        ]);
    }

    /**
     * Récupérer tous les rôles (API)
     */
    public function getAllRoles()
    {
        $roles = Role::withCount(['permissions', 'users'])->get();
        return response()->json(['roles' => $roles]);
    }

    /**
     * Récupérer toutes les permissions (API)
     */
    public function getAllPermissions()
    {
        $permissions = Permission::withCount('roles')->get();
        return response()->json([
            'permissions' => $permissions,
            'grouped' => $this->groupPermissions($permissions),
        ]);
    }

    // ==================== HELPERS ====================

    /**
     * Grouper les permissions par module
     */
    private function groupPermissions($permissions)
    {
        $grouped = [];

        $labels = [
            'users' => 'Utilisateurs',
            'entreprises' => 'Entreprises',
            'departements' => 'Départements',
            'services' => 'Services',
            'roles' => 'Rôles',
            'settings' => 'Paramètres',
            'reports' => 'Rapports',
            'dashboard' => 'Tableau de bord',
            'conges' => 'Congés',
            'paies' => 'Paies',
            'documents' => 'Documents',
        ];

        foreach ($permissions as $permission) {
            $parts = explode('-', $permission->name);
            $module = count($parts) >= 2 ? end($parts) : 'autres';
            $label = $labels[$module] ?? ucfirst($module);

            if (!isset($grouped[$label])) {
                $grouped[$label] = [];
            }

            $grouped[$label][] = $permission;
        }

        ksort($grouped);
        return $grouped;
    }
}
