<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Entreprise;
use App\Models\Departement;
use App\Policies\UserPolicy;
use App\Policies\EntreprisePolicy;
use App\Policies\DepartementPolicy;
use App\Policies\RolePolicy;
use Spatie\Permission\Models\Role;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        User::class => UserPolicy::class,
        Entreprise::class => EntreprisePolicy::class,
        Departement::class => DepartementPolicy::class,
        Role::class => RolePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // Définition de Gates personnalisés pour des autorisations spécifiques

        /**
         * Gate pour vérifier si l'utilisateur est Super Admin
         * Utile pour des vérifications rapides dans les views et controllers
         */
        Gate::define('is-super-admin', function (User $user) {
            return $user->hasRole('Super Admin');
        });

        /**
         * Gate pour vérifier si l'utilisateur est Admin (de son entreprise)
         */
        Gate::define('is-admin', function (User $user) {
            return $user->hasRole('Admin');
        });

        /**
         * Gate pour vérifier si l'utilisateur peut gérer son entreprise
         */
        Gate::define('manage-own-company', function (User $user) {
            return $user->hasRole(['Super Admin', 'Admin']);
        });

        /**
         * Gate pour vérifier si l'utilisateur peut approuver des congés
         */
        Gate::define('can-approve-leave', function (User $user) {
            return $user->hasAnyPermission(['approve-conges', 'manage-conges']);
        });

        /**
         * Gate pour vérifier l'appartenance à la même entreprise
         * Utile pour filtrer les données par entreprise
         */
        Gate::define('same-company', function (User $user, User $targetUser) {
            // Super Admin peut accéder à toutes les entreprises
            if ($user->hasRole('Super Admin')) {
                return true;
            }

            return $user->entreprise_id === $targetUser->entreprise_id;
        });

        /**
         * Gate pour les actions RH
         */
        Gate::define('can-manage-hr', function (User $user) {
            return $user->hasRole(['Super Admin', 'Admin', 'RH']);
        });
    }
}
