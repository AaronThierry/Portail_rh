<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Policy pour gérer les autorisations liées aux utilisateurs
 *
 * Cette policy définit qui peut faire quoi sur les utilisateurs du système.
 * Elle prend en compte les rôles ET l'appartenance à l'entreprise.
 */
class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Détermine si l'utilisateur peut voir la liste des utilisateurs
     */
    public function viewAny(User $authUser): bool
    {
        return $authUser->hasPermissionTo('view-users');
    }

    /**
     * Détermine si l'utilisateur peut voir les détails d'un utilisateur spécifique
     *
     * Un utilisateur peut voir:
     * - Lui-même
     * - Les utilisateurs de son entreprise s'il a la permission
     * - Tous les utilisateurs s'il est Super Admin
     */
    public function view(User $authUser, User $targetUser): bool
    {
        // Un utilisateur peut toujours voir son propre profil
        if ($authUser->id === $targetUser->id) {
            return true;
        }

        // Super Admin peut tout voir
        if ($authUser->hasRole('Super Admin')) {
            return true;
        }

        // Doit avoir la permission ET appartenir à la même entreprise
        return $authUser->hasPermissionTo('view-user-details')
            && $authUser->entreprise_id === $targetUser->entreprise_id;
    }

    /**
     * Détermine si l'utilisateur peut créer un nouvel utilisateur
     */
    public function create(User $authUser): bool
    {
        return $authUser->hasPermissionTo('create-users');
    }

    /**
     * Détermine si l'utilisateur peut modifier un utilisateur
     *
     * Règles:
     * - Ne peut pas modifier son propre rôle (sauf Super Admin)
     * - Ne peut modifier que les utilisateurs de son entreprise
     * - Ne peut pas modifier un utilisateur avec un rôle supérieur
     */
    public function update(User $authUser, User $targetUser): bool
    {
        // Vérifie la permission de base
        if (!$authUser->hasPermissionTo('edit-users')) {
            return false;
        }

        // Super Admin peut tout modifier
        if ($authUser->hasRole('Super Admin')) {
            return true;
        }

        // Ne peut pas modifier un utilisateur d'une autre entreprise
        if ($authUser->entreprise_id !== $targetUser->entreprise_id) {
            return false;
        }

        // Ne peut pas modifier un Super Admin
        if ($targetUser->hasRole('Super Admin')) {
            return false;
        }

        // Un Admin ne peut pas modifier un autre Admin
        if ($targetUser->hasRole('Admin') && !$authUser->hasRole('Super Admin')) {
            return false;
        }

        return true;
    }

    /**
     * Détermine si l'utilisateur peut supprimer un utilisateur
     *
     * Règles strictes:
     * - Ne peut jamais se supprimer soi-même
     * - Ne peut supprimer que les utilisateurs de son entreprise
     * - Ne peut pas supprimer un utilisateur avec un rôle égal ou supérieur
     */
    public function delete(User $authUser, User $targetUser): bool
    {
        // Ne peut jamais se supprimer soi-même
        if ($authUser->id === $targetUser->id) {
            return false;
        }

        // Vérifie la permission de base
        if (!$authUser->hasPermissionTo('delete-users')) {
            return false;
        }

        // Super Admin peut tout supprimer (sauf lui-même, vérifié ci-dessus)
        if ($authUser->hasRole('Super Admin')) {
            return true;
        }

        // Ne peut pas supprimer un utilisateur d'une autre entreprise
        if ($authUser->entreprise_id !== $targetUser->entreprise_id) {
            return false;
        }

        // Ne peut pas supprimer un Super Admin
        if ($targetUser->hasRole('Super Admin')) {
            return false;
        }

        // Un Admin ne peut pas supprimer un autre Admin
        if ($targetUser->hasRole('Admin')) {
            return false;
        }

        return true;
    }

    /**
     * Détermine si l'utilisateur peut attribuer des rôles
     */
    public function assignRole(User $authUser, User $targetUser): bool
    {
        // Vérifie la permission de base
        if (!$authUser->hasPermissionTo('assign-roles')) {
            return false;
        }

        // Super Admin peut tout attribuer
        if ($authUser->hasRole('Super Admin')) {
            return true;
        }

        // Ne peut attribuer des rôles qu'aux utilisateurs de son entreprise
        if ($authUser->entreprise_id !== $targetUser->entreprise_id) {
            return false;
        }

        // Ne peut pas modifier les rôles d'un Super Admin
        if ($targetUser->hasRole('Super Admin')) {
            return false;
        }

        return true;
    }

    /**
     * Détermine si l'utilisateur peut exporter les utilisateurs
     */
    public function export(User $authUser): bool
    {
        return $authUser->hasPermissionTo('export-users');
    }

    /**
     * Détermine si l'utilisateur peut importer des utilisateurs
     */
    public function import(User $authUser): bool
    {
        return $authUser->hasPermissionTo('import-users');
    }

    /**
     * Politique par défaut: autorise les Super Admins
     * Cette méthode est appelée avant toutes les autres
     */
    public function before(User $authUser, string $ability): ?bool
    {
        // Super Admin a tous les droits
        if ($authUser->hasRole('Super Admin')) {
            return true;
        }

        // Retourne null pour laisser les autres méthodes décider
        return null;
    }
}
