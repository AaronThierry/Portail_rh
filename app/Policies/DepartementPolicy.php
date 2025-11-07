<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Departement;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Policy pour gérer les autorisations liées aux départements
 */
class DepartementPolicy
{
    use HandlesAuthorization;

    /**
     * Détermine si l'utilisateur peut voir tous les départements
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view-departements');
    }

    /**
     * Détermine si l'utilisateur peut voir un département spécifique
     */
    public function view(User $user, Departement $departement): bool
    {
        // Super Admin peut tout voir
        if ($user->hasRole('Super Admin')) {
            return true;
        }

        // Doit avoir la permission ET appartenir à la même entreprise
        return $user->hasPermissionTo('view-departement-details')
            && $user->entreprise_id === $departement->entreprise_id;
    }

    /**
     * Détermine si l'utilisateur peut créer un département
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create-departements');
    }

    /**
     * Détermine si l'utilisateur peut modifier un département
     */
    public function update(User $user, Departement $departement): bool
    {
        // Super Admin peut tout modifier
        if ($user->hasRole('Super Admin')) {
            return true;
        }

        // Doit avoir la permission ET le département doit appartenir à son entreprise
        return $user->hasPermissionTo('edit-departements')
            && $user->entreprise_id === $departement->entreprise_id;
    }

    /**
     * Détermine si l'utilisateur peut supprimer un département
     */
    public function delete(User $user, Departement $departement): bool
    {
        // Super Admin peut tout supprimer
        if ($user->hasRole('Super Admin')) {
            return true;
        }

        // Doit avoir la permission ET le département doit appartenir à son entreprise
        return $user->hasPermissionTo('delete-departements')
            && $user->entreprise_id === $departement->entreprise_id;
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
