<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Gate;

/**
 * Middleware pour s'assurer que l'utilisateur n'accède qu'aux données de son entreprise
 *
 * Ce middleware est particulièrement utile pour les routes qui manipulent des ressources
 * liées à une entreprise (utilisateurs, départements, services, etc.)
 *
 * Usage:
 * Route::get('/users/{user}', [UserController::class, 'show'])->middleware('same.company:user');
 * Route::get('/departements/{departement}', [DepartementController::class, 'show'])->middleware('same.company:departement');
 */
class EnsureSameCompany
{
    /**
     * Handle an incoming request.
     *
     * @param  string|null  $paramName  Nom du paramètre de route à vérifier
     */
    public function handle(Request $request, Closure $next, ?string $paramName = null): Response
    {
        if (!auth()->check()) {
            abort(401, 'Non authentifié');
        }

        $user = auth()->user();

        // Super Admin peut accéder à toutes les entreprises
        if ($user->hasRole('Super Admin')) {
            return $next($request);
        }

        // Si un paramètre est spécifié, vérifier l'entreprise de la ressource
        if ($paramName) {
            $resource = $request->route($paramName);

            if ($resource && method_exists($resource, 'getAttribute')) {
                $resourceEntrepriseId = $resource->getAttribute('entreprise_id');

                if ($resourceEntrepriseId && $resourceEntrepriseId !== $user->entreprise_id) {
                    abort(403, 'Accès refusé. Vous ne pouvez accéder qu\'aux ressources de votre entreprise.');
                }
            }
        }

        return $next($request);
    }
}
