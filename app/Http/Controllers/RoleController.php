<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;

/**
 * Controller pour la gestion des rôles et permissions
 *
 * Ce controller gère toutes les opérations CRUD sur les rôles
 * ainsi que l'attribution des permissions aux rôles
 */
class RoleController extends Controller
{
    /**
     * Rôles système qui ne peuvent pas être supprimés
     */
    private const PROTECTED_ROLES = ['Super Admin', 'Admin', 'RH', 'Manager', 'Employé'];

    /**
     * Constructeur - Applique les autorisations
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('check.permission:view-roles')->only(['index']);
        $this->middleware('check.permission:view-role-details')->only(['show']);
        $this->middleware('check.permission:create-roles')->only(['create', 'store']);
        $this->middleware('check.permission:edit-roles')->only(['edit', 'update']);
        $this->middleware('check.permission:delete-roles')->only(['destroy']);
        $this->middleware('check.permission:manage-permissions')->only(['permissions', 'updatePermissions']);
    }

    /**
     * Affiche la liste de tous les rôles avec statistiques
     */
    public function index()
    {
        $this->authorize('viewAny', Role::class);

        $roles = Role::with('permissions')
            ->withCount(['permissions', 'users'])
            ->orderBy('name')
            ->get()
            ->map(function ($role) {
                // Ajoute des métadonnées utiles
                $role->is_protected = in_array($role->name, self::PROTECTED_ROLES);
                $role->can_edit = auth()->user()->can('update', $role);
                $role->can_delete = auth()->user()->can('delete', $role);
                return $role;
            });

        return view('parametres.roles', compact('roles'));
    }

    /**
     * Affiche les détails d'un rôle spécifique
     */
    public function show(Role $role)
    {
        $this->authorize('view', $role);

        $role->load(['permissions', 'users' => function ($query) {
            $query->with('entreprise')->limit(10);
        }]);

        $role->loadCount('users');

        return view('roles.show', compact('role'));
    }

    /**
     * Enregistre un nouveau rôle en base de données
     *
     * @param \App\Http\Requests\StoreRoleRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(\App\Http\Requests\StoreRoleRequest $request)
    {
        DB::beginTransaction();

        try {
            // Création du rôle avec les données validées
            $role = Role::create([
                'name' => $request->validated('name'),
                'guard_name' => 'web',
            ]);

            // Attribue les permissions si fournies
            if ($request->has('permissions') && !empty($request->validated('permissions'))) {
                $permissions = Permission::whereIn('id', $request->validated('permissions'))->get();
                $role->syncPermissions($permissions);

                \Log::info("Rôle créé avec permissions", [
                    'role_id' => $role->id,
                    'role_name' => $role->name,
                    'permissions_count' => $permissions->count(),
                    'created_by' => auth()->id(),
                ]);
            } else {
                \Log::info("Rôle créé sans permissions", [
                    'role_id' => $role->id,
                    'role_name' => $role->name,
                    'created_by' => auth()->id(),
                ]);
            }

            // Vide le cache des permissions
            app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

            DB::commit();

            return redirect()
                ->route('admin.roles.index')
                ->with('success', "Le rôle '{$role->name}' a été créé avec succès.");

        } catch (\Exception $e) {
            DB::rollBack();

            \Log::error('Erreur lors de la création du rôle', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => auth()->id(),
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Erreur lors de la création du rôle: ' . $e->getMessage());
        }
    }

    /**
     * Met à jour un rôle existant
     *
     * @param \App\Http\Requests\UpdateRoleRequest $request
     * @param Role $role
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(\App\Http\Requests\UpdateRoleRequest $request, Role $role)
    {
        DB::beginTransaction();

        try {
            $oldName = $role->name;

            // Met à jour le nom du rôle
            $role->update(['name' => $request->validated('name')]);

            // Met à jour les permissions si fournies
            if ($request->has('permissions')) {
                $permissions = Permission::whereIn('id', $request->validated('permissions') ?? [])->get();
                $role->syncPermissions($permissions);
            }

            // Vide le cache des permissions
            app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

            \Log::info("Rôle mis à jour", [
                'role_id' => $role->id,
                'old_name' => $oldName,
                'new_name' => $role->name,
                'updated_by' => auth()->id(),
            ]);

            DB::commit();

            return redirect()
                ->route('admin.roles.index')
                ->with('success', "Le rôle '{$role->name}' a été mis à jour avec succès.");

        } catch (\Exception $e) {
            DB::rollBack();

            \Log::error('Erreur lors de la mise à jour du rôle', [
                'role_id' => $role->id,
                'error' => $e->getMessage(),
                'user_id' => auth()->id(),
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Erreur lors de la mise à jour: ' . $e->getMessage());
        }
    }

    /**
     * Supprime un rôle
     */
    public function destroy(Role $role)
    {
        $this->authorize('delete', $role);

        // Double vérification de sécurité
        if (in_array($role->name, self::PROTECTED_ROLES)) {
            return redirect()
                ->route('admin.roles.index')
                ->with('error', "Le rôle '{$role->name}' est protégé et ne peut pas être supprimé.");
        }

        // Vérifie si des utilisateurs ont ce rôle
        $usersCount = $role->users()->count();

        if ($usersCount > 0) {
            return redirect()
                ->route('admin.roles.index')
                ->with('error', "Impossible de supprimer le rôle '{$role->name}'. {$usersCount} utilisateur(s) possède(nt) ce rôle.");
        }

        DB::beginTransaction();

        try {
            $roleName = $role->name;

            // Supprime d'abord toutes les permissions associées
            $role->syncPermissions([]);

            // Supprime le rôle
            $role->delete();

            DB::commit();

            return redirect()
                ->route('admin.roles.index')
                ->with('success', "Le rôle '{$roleName}' a été supprimé avec succès.");

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->route('admin.roles.index')
                ->with('error', 'Erreur lors de la suppression: ' . $e->getMessage());
        }
    }

    /**
     * Affiche le formulaire de gestion des permissions d'un rôle
     */
    public function permissions(Role $role)
    {
        $this->authorize('managePermissions', $role);

        // Récupère toutes les permissions ordonnées
        $permissions = Permission::orderBy('name')->get();

        // Groupe les permissions par catégorie pour une meilleure organisation
        $groupedPermissions = $this->groupPermissionsByCategory($permissions);

        // Récupère les IDs des permissions actuellement assignées au rôle
        $rolePermissions = $role->permissions->pluck('id')->toArray();

        // Statistiques
        $stats = [
            'total_permissions' => $permissions->count(),
            'assigned_permissions' => count($rolePermissions),
            'users_count' => $role->users()->count(),
        ];

        return view('roles.permissions', compact('role', 'permissions', 'groupedPermissions', 'rolePermissions', 'stats'));
    }

    /**
     * Met à jour les permissions d'un rôle
     *
     * @param \App\Http\Requests\SyncPermissionsRequest $request
     * @param Role $role
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePermissions(\App\Http\Requests\SyncPermissionsRequest $request, Role $role)
    {
        DB::beginTransaction();

        try {
            // Récupère les permissions par leurs IDs
            $permissionIds = $request->validated('permissions') ?? [];
            $permissions = Permission::whereIn('id', $permissionIds)->get();

            // Compte les permissions avant et après
            $beforeCount = $role->permissions->count();
            $beforePermissions = $role->permissions->pluck('name')->toArray();

            // Synchronisation des permissions
            $role->syncPermissions($permissions);

            $afterCount = $permissions->count();
            $afterPermissions = $permissions->pluck('name')->toArray();

            // Rafraîchit le cache des permissions
            app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

            \Log::info("Permissions du rôle mises à jour", [
                'role_id' => $role->id,
                'role_name' => $role->name,
                'before_count' => $beforeCount,
                'after_count' => $afterCount,
                'added' => array_diff($afterPermissions, $beforePermissions),
                'removed' => array_diff($beforePermissions, $afterPermissions),
                'updated_by' => auth()->id(),
            ]);

            DB::commit();

            $message = "Les permissions du rôle '{$role->name}' ont été mises à jour avec succès. ";
            $message .= "({$beforeCount} → {$afterCount} permissions)";

            return redirect()
                ->route('admin.roles.index')
                ->with('success', $message);

        } catch (\Exception $e) {
            DB::rollBack();

            \Log::error('Erreur lors de la mise à jour des permissions', [
                'role_id' => $role->id,
                'error' => $e->getMessage(),
                'user_id' => auth()->id(),
            ]);

            return redirect()
                ->back()
                ->with('error', 'Erreur lors de la mise à jour des permissions: ' . $e->getMessage());
        }
    }

    /**
     * Groupe les permissions par catégorie (module)
     *
     * Format attendu: action-module (ex: view-users, create-departements)
     * Les permissions sont regroupées par module pour faciliter la gestion
     */
    private function groupPermissionsByCategory($permissions)
    {
        $grouped = [];

        // Mapping des catégories avec des libellés français
        $categoryLabels = [
            'users' => 'Utilisateurs',
            'entreprises' => 'Entreprises',
            'departements' => 'Départements',
            'services' => 'Services',
            'roles' => 'Rôles & Permissions',
            'settings' => 'Paramètres',
            'reports' => 'Rapports',
            'dashboard' => 'Tableau de bord',
            'conges' => 'Congés',
            'paies' => 'Paies',
            'documents' => 'Documents',
        ];

        foreach ($permissions as $permission) {
            // Split par le tiret: "view-users" devient ["view", "users"]
            $parts = explode('-', $permission->name);

            if (count($parts) >= 2) {
                // Le module est le dernier élément
                $module = end($parts);
                $label = $categoryLabels[$module] ?? ucfirst($module);

                if (!isset($grouped[$label])) {
                    $grouped[$label] = [
                        'module' => $module,
                        'permissions' => [],
                    ];
                }

                $grouped[$label]['permissions'][] = $permission;
            } else {
                // Permissions sans catégorie
                if (!isset($grouped['Autres'])) {
                    $grouped['Autres'] = [
                        'module' => 'autres',
                        'permissions' => [],
                    ];
                }
                $grouped['Autres']['permissions'][] = $permission;
            }
        }

        // Trie les groupes par ordre alphabétique
        ksort($grouped);

        return $grouped;
    }
}
