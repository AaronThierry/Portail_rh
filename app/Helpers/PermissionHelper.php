<?php

namespace App\Helpers;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

/**
 * Helper Class pour la Gestion des Permissions
 *
 * Cette classe fournit des méthodes utilitaires pour faciliter
 * la gestion des rôles et permissions dans l'application
 *
 * @package App\Helpers
 */
class PermissionHelper
{
    /**
     * Vérifie si l'utilisateur connecté est un Super Admin
     *
     * @return bool
     */
    public static function isSuperAdmin(): bool
    {
        return auth()->check() && auth()->user()->hasRole('Super Admin');
    }

    /**
     * Vérifie si l'utilisateur connecté est un Admin (ou plus)
     *
     * @return bool
     */
    public static function isAdmin(): bool
    {
        return auth()->check() && auth()->user()->hasAnyRole(['Super Admin', 'Admin']);
    }

    /**
     * Vérifie si l'utilisateur connecté est un Manager (ou plus)
     *
     * @return bool
     */
    public static function isManager(): bool
    {
        return auth()->check() && auth()->user()->hasAnyRole(['Super Admin', 'Admin', 'Manager']);
    }

    /**
     * Récupère toutes les permissions d'un utilisateur
     * (incluant celles des rôles et celles assignées directement)
     *
     * @param User|null $user
     * @return \Illuminate\Support\Collection
     */
    public static function getUserPermissions(?User $user = null): \Illuminate\Support\Collection
    {
        $user = $user ?? auth()->user();

        if (!$user) {
            return collect([]);
        }

        return $user->getAllPermissions();
    }

    /**
     * Récupère les noms des rôles d'un utilisateur
     *
     * @param User|null $user
     * @return \Illuminate\Support\Collection
     */
    public static function getUserRoleNames(?User $user = null): \Illuminate\Support\Collection
    {
        $user = $user ?? auth()->user();

        if (!$user) {
            return collect([]);
        }

        return $user->getRoleNames();
    }

    /**
     * Vérifie si un utilisateur a au moins une des permissions données
     *
     * @param array $permissions
     * @param User|null $user
     * @return bool
     */
    public static function hasAnyPermission(array $permissions, ?User $user = null): bool
    {
        $user = $user ?? auth()->user();

        if (!$user) {
            return false;
        }

        return $user->hasAnyPermission($permissions);
    }

    /**
     * Vérifie si un utilisateur a toutes les permissions données
     *
     * @param array $permissions
     * @param User|null $user
     * @return bool
     */
    public static function hasAllPermissions(array $permissions, ?User $user = null): bool
    {
        $user = $user ?? auth()->user();

        if (!$user) {
            return false;
        }

        return $user->hasAllPermissions($permissions);
    }

    /**
     * Récupère toutes les permissions groupées par catégorie
     *
     * @return array
     */
    public static function getPermissionsByCategory(): array
    {
        $permissions = Permission::all();
        $grouped = [];

        foreach ($permissions as $permission) {
            // Extrait la catégorie du nom (format: action-category)
            $parts = explode('-', $permission->name);

            if (count($parts) >= 2) {
                $category = $parts[1]; // users, entreprises, etc.

                if (!isset($grouped[$category])) {
                    $grouped[$category] = [
                        'name' => ucfirst($category),
                        'permissions' => []
                    ];
                }

                $grouped[$category]['permissions'][] = $permission;
            }
        }

        return $grouped;
    }

    /**
     * Récupère les statistiques des rôles et permissions
     *
     * @return array
     */
    public static function getStatistics(): array
    {
        return [
            'total_roles' => Role::count(),
            'total_permissions' => Permission::count(),
            'total_users_with_roles' => User::role(Role::all())->count(),
            'roles_breakdown' => Role::withCount('users')->get()->map(function ($role) {
                return [
                    'name' => $role->name,
                    'users_count' => $role->users_count,
                    'permissions_count' => $role->permissions()->count()
                ];
            })
        ];
    }

    /**
     * Vérifie si un utilisateur peut effectuer une action sur une ressource
     *
     * @param string $action (view, create, edit, delete, manage)
     * @param string $resource (users, entreprises, etc.)
     * @param User|null $user
     * @return bool
     */
    public static function canDo(string $action, string $resource, ?User $user = null): bool
    {
        $user = $user ?? auth()->user();

        if (!$user) {
            return false;
        }

        $permission = "{$action}-{$resource}";
        return $user->can($permission);
    }

    /**
     * Assigne un rôle à un utilisateur avec vérification
     *
     * @param User $user
     * @param string $roleName
     * @return bool
     * @throws \Exception
     */
    public static function assignRoleToUser(User $user, string $roleName): bool
    {
        // Vérifie que le rôle existe
        $role = Role::findByName($roleName);

        if (!$role) {
            throw new \Exception("Le rôle '{$roleName}' n'existe pas.");
        }

        // Vérifie que l'utilisateur connecté a le droit d'assigner ce rôle
        if (!auth()->user()->can('assign-roles')) {
            throw new \Exception("Vous n'avez pas la permission d'assigner des rôles.");
        }

        // Un non-Super Admin ne peut pas créer de Super Admin
        if ($roleName === 'Super Admin' && !self::isSuperAdmin()) {
            throw new \Exception("Seul un Super Admin peut assigner le rôle Super Admin.");
        }

        $user->assignRole($roleName);
        return true;
    }

    /**
     * Retire un rôle à un utilisateur avec vérification
     *
     * @param User $user
     * @param string $roleName
     * @return bool
     * @throws \Exception
     */
    public static function removeRoleFromUser(User $user, string $roleName): bool
    {
        // Vérifie que l'utilisateur connecté a le droit de retirer des rôles
        if (!auth()->user()->can('assign-roles')) {
            throw new \Exception("Vous n'avez pas la permission de retirer des rôles.");
        }

        // Empêche de retirer le rôle Super Admin par un non-Super Admin
        if ($roleName === 'Super Admin' && !self::isSuperAdmin()) {
            throw new \Exception("Seul un Super Admin peut retirer le rôle Super Admin.");
        }

        $user->removeRole($roleName);
        return true;
    }

    /**
     * Retourne un badge HTML coloré pour un rôle
     *
     * @param string $roleName
     * @return string
     */
    public static function getRoleBadge(string $roleName): string
    {
        $colors = [
            'Super Admin' => 'bg-red-100 text-red-800',
            'Admin' => 'bg-blue-100 text-blue-800',
            'Manager' => 'bg-green-100 text-green-800',
            'Employé' => 'bg-gray-100 text-gray-800',
        ];

        $colorClass = $colors[$roleName] ?? 'bg-gray-100 text-gray-800';

        return "<span class='px-2 py-1 text-xs font-semibold rounded-full {$colorClass}'>{$roleName}</span>";
    }

    /**
     * Vérifie si un rôle est protégé (ne peut pas être supprimé)
     *
     * @param string $roleName
     * @return bool
     */
    public static function isProtectedRole(string $roleName): bool
    {
        $protectedRoles = ['Super Admin', 'Admin'];
        return in_array($roleName, $protectedRoles);
    }

    /**
     * Récupère les permissions qu'un rôle peut assigner
     * (Un Admin ne peut pas assigner toutes les permissions du Super Admin)
     *
     * @param User|null $user
     * @return \Illuminate\Support\Collection
     */
    public static function getAssignablePermissions(?User $user = null): \Illuminate\Support\Collection
    {
        $user = $user ?? auth()->user();

        if (!$user) {
            return collect([]);
        }

        // Super Admin peut tout assigner
        if ($user->hasRole('Super Admin')) {
            return Permission::all();
        }

        // Admin peut assigner tout sauf les permissions d'entreprises
        if ($user->hasRole('Admin')) {
            return Permission::where('name', 'not like', '%-entreprises')->get();
        }

        // Les autres ne peuvent rien assigner
        return collect([]);
    }

    /**
     * Retourne un tableau des actions possibles sur une ressource
     *
     * @param string $resource
     * @return array
     */
    public static function getActionsForResource(string $resource): array
    {
        $actions = ['view', 'create', 'edit', 'delete'];
        $permissions = [];

        foreach ($actions as $action) {
            $permissionName = "{$action}-{$resource}";
            if (Permission::where('name', $permissionName)->exists()) {
                $permissions[$action] = auth()->user() ? auth()->user()->can($permissionName) : false;
            }
        }

        return $permissions;
    }

    /**
     * Vide le cache des permissions
     * À utiliser après modification des rôles/permissions
     *
     * @return void
     */
    public static function clearPermissionCache(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
    }

    /**
     * Retourne la description d'une permission
     *
     * @param string $permissionName
     * @return string
     */
    public static function getPermissionDescription(string $permissionName): string
    {
        $descriptions = [
            // Utilisateurs
            'view-users' => 'Voir la liste des utilisateurs',
            'view-user-details' => 'Voir les détails d\'un utilisateur',
            'create-users' => 'Créer un nouvel utilisateur',
            'edit-users' => 'Modifier un utilisateur',
            'delete-users' => 'Supprimer un utilisateur',
            'manage-users' => 'Gestion complète des utilisateurs',
            'export-users' => 'Exporter la liste des utilisateurs',
            'import-users' => 'Importer des utilisateurs',

            // Entreprises
            'view-entreprises' => 'Voir toutes les entreprises',
            'view-entreprise-details' => 'Voir les détails d\'une entreprise',
            'create-entreprises' => 'Créer une nouvelle entreprise',
            'edit-entreprises' => 'Modifier une entreprise',
            'delete-entreprises' => 'Supprimer une entreprise',
            'manage-entreprises' => 'Gestion complète des entreprises',

            // Départements
            'view-departements' => 'Voir les départements',
            'view-departement-details' => 'Voir les détails d\'un département',
            'create-departements' => 'Créer un département',
            'edit-departements' => 'Modifier un département',
            'delete-departements' => 'Supprimer un département',
            'manage-departements' => 'Gestion complète des départements',

            // Services
            'view-services' => 'Voir les services',
            'view-service-details' => 'Voir les détails d\'un service',
            'create-services' => 'Créer un service',
            'edit-services' => 'Modifier un service',
            'delete-services' => 'Supprimer un service',
            'manage-services' => 'Gestion complète des services',

            // Rôles & Permissions
            'view-roles' => 'Voir les rôles',
            'view-role-details' => 'Voir les détails d\'un rôle',
            'create-roles' => 'Créer un rôle',
            'edit-roles' => 'Modifier un rôle',
            'delete-roles' => 'Supprimer un rôle',
            'assign-roles' => 'Attribuer des rôles',
            'manage-permissions' => 'Gérer les permissions',

            // Paramètres
            'view-settings' => 'Voir les paramètres',
            'edit-settings' => 'Modifier les paramètres',
            'manage-settings' => 'Gestion complète des paramètres',

            // Rapports
            'view-reports' => 'Voir les rapports',
            'create-reports' => 'Créer des rapports',
            'export-reports' => 'Exporter des rapports',
            'delete-reports' => 'Supprimer des rapports',

            // Dashboard
            'view-dashboard' => 'Accéder au tableau de bord',
            'view-analytics' => 'Voir les statistiques avancées',
            'view-global-stats' => 'Voir les statistiques globales',

            // Congés
            'view-conges' => 'Voir les congés',
            'create-conges' => 'Créer une demande de congé',
            'edit-conges' => 'Modifier une demande de congé',
            'delete-conges' => 'Supprimer une demande de congé',
            'approve-conges' => 'Approuver des congés',
            'reject-conges' => 'Rejeter des congés',
            'manage-conges' => 'Gestion complète des congés',

            // Paies
            'view-paies' => 'Voir les fiches de paie',
            'create-paies' => 'Créer des fiches de paie',
            'edit-paies' => 'Modifier des fiches de paie',
            'delete-paies' => 'Supprimer des fiches de paie',
            'export-paies' => 'Exporter des fiches de paie',
            'manage-paies' => 'Gestion complète des paies',

            // Documents
            'view-documents' => 'Voir les documents',
            'upload-documents' => 'Télécharger des documents',
            'edit-documents' => 'Modifier des documents',
            'delete-documents' => 'Supprimer des documents',
            'download-documents' => 'Télécharger des documents',
            'manage-documents' => 'Gestion complète des documents',
        ];

        return $descriptions[$permissionName] ?? 'Permission personnalisée';
    }

    /**
     * Génère un menu de navigation basé sur les permissions
     *
     * @return array
     */
    public static function getNavigationMenu(): array
    {
        $user = auth()->user();

        if (!$user) {
            return [];
        }

        $menu = [];

        // Dashboard (accessible à tous)
        $menu[] = [
            'name' => 'Tableau de bord',
            'route' => 'dashboard',
            'icon' => 'dashboard',
            'visible' => true
        ];

        // Utilisateurs
        if ($user->can('view-users')) {
            $menu[] = [
                'name' => 'Utilisateurs',
                'route' => 'utilisateurs.index',
                'icon' => 'users',
                'visible' => true
            ];
        }

        // Entreprises (Super Admin seulement)
        if ($user->can('view-entreprises')) {
            $menu[] = [
                'name' => 'Entreprises',
                'route' => 'entreprises.index',
                'icon' => 'building',
                'visible' => true
            ];
        }

        // Départements
        if ($user->can('view-departements')) {
            $menu[] = [
                'name' => 'Départements',
                'route' => 'departements.index',
                'icon' => 'briefcase',
                'visible' => true
            ];
        }

        // Services
        if ($user->can('view-services')) {
            $menu[] = [
                'name' => 'Services',
                'route' => 'services.index',
                'icon' => 'cog',
                'visible' => true
            ];
        }

        // Rôles & Permissions
        if ($user->can('view-roles')) {
            $menu[] = [
                'name' => 'Rôles & Permissions',
                'route' => 'roles.index',
                'icon' => 'shield',
                'visible' => true
            ];
        }

        return $menu;
    }
}
