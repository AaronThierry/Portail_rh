<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Entreprise;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Policy pour gérer les autorisations liées aux entreprises
 *
 * La gestion des entreprises est réservée principalement aux Super Admins
 */
class EntreprisePolicy
{
    use HandlesAuthorization;

    /**
     * Détermine si l'utilisateur peut voir toutes les entreprises
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view-entreprises');
    }

    /**
     * Détermine si l'utilisateur peut voir une entreprise spécifique
     *
     * Un utilisateur peut voir:
     * - Son entreprise
     * - Toutes les entreprises s'il est Super Admin
     */
    public function view(User $user, Entreprise $entreprise): bool
    {
        // Peut voir sa propre entreprise
        if ($user->entreprise_id === $entreprise->id) {
            return true;
        }

        // Doit être Super Admin pour voir les autres entreprises
        return $user->hasPermissionTo('view-entreprise-details');
    }

    /**
     * Détermine si l'utilisateur peut créer une entreprise
     * Réservé aux Super Admins
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create-entreprises');
    }

    /**
     * Détermine si l'utilisateur peut modifier une entreprise
     */
    public function update(User $user, Entreprise $entreprise): bool
    {
        // Super Admin peut tout modifier
        if ($user->hasRole('Super Admin')) {
            return true;
        }

        // Admin peut modifier sa propre entreprise
        if ($user->hasRole('Admin')
            && $user->entreprise_id === $entreprise->id
            && $user->hasPermissionTo('edit-entreprises')) {
            return true;
        }

        return false;
    }

    /**
     * Détermine si l'utilisateur peut supprimer une entreprise
     * Réservé aux Super Admins uniquement
     */
    public function delete(User $user, Entreprise $entreprise): bool
    {
        return $user->hasPermissionTo('delete-entreprises')
            && $user->hasRole('Super Admin');
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
