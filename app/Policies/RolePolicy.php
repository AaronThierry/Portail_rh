<?php

namespace App\Policies;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Policy pour gérer les autorisations liées aux rôles
 */
class RolePolicy
{
    use HandlesAuthorization;

    /**
     * Détermine si l'utilisateur peut voir tous les rôles
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view-roles');
    }

    /**
     * Détermine si l'utilisateur peut voir un rôle spécifique
     */
    public function view(User $user, Role $role): bool
    {
        return $user->hasPermissionTo('view-role-details');
    }

    /**
     * Détermine si l'utilisateur peut créer un nouveau rôle
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create-roles');
    }

    /**
     * Détermine si l'utilisateur peut modifier un rôle
     *
     * Les rôles système (Super Admin, Admin) ne peuvent être modifiés que par les Super Admins
     */
    public function update(User $user, Role $role): bool
    {
        if (!$user->hasPermissionTo('edit-roles')) {
            return false;
        }

        // Protection des rôles système
        $protectedRoles = ['Super Admin', 'Admin'];

        if (in_array($role->name, $protectedRoles) && !$user->hasRole('Super Admin')) {
            return false;
        }

        return true;
    }

    /**
     * Détermine si l'utilisateur peut supprimer un rôle
     *
     * Les rôles système ne peuvent jamais être supprimés
     */
    public function delete(User $user, Role $role): bool
    {
        if (!$user->hasPermissionTo('delete-roles')) {
            return false;
        }

        // Protection des rôles système - ne peuvent JAMAIS être supprimés
        $protectedRoles = ['Super Admin', 'Admin', 'RH', 'Manager', 'Employé'];

        if (in_array($role->name, $protectedRoles)) {
            return false;
        }

        return true;
    }

    /**
     * Détermine si l'utilisateur peut gérer les permissions d'un rôle
     */
    public function managePermissions(User $user, Role $role): bool
    {
        if (!$user->hasPermissionTo('manage-permissions')) {
            return false;
        }

        // Seul le Super Admin peut modifier les permissions du rôle Super Admin
        if ($role->name === 'Super Admin' && !$user->hasRole('Super Admin')) {
            return false;
        }

        return true;
    }

    /**
     * Politique par défaut: autorise les Super Admins
     */
    public function before(User $user, string $ability): ?bool
    {
        if ($user->hasRole('Super Admin')) {
            return true;
        }

        return null;
    }
}
