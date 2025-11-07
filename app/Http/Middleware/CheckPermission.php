<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware pour vérifier les permissions avec support des wildcard
 *
 * Usage dans les routes:
 * Route::get('/users', [UserController::class, 'index'])->middleware('check.permission:view-users');
 * Route::get('/users', [UserController::class, 'index'])->middleware('check.permission:view-users,create-users');
 */
class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$permissions): Response
    {
        if (!auth()->check()) {
            abort(401, 'Non authentifié');
        }

        $user = auth()->user();

        // Super Admin a tous les droits
        if ($user->hasRole('Super Admin')) {
            return $next($request);
        }

        // Vérifie si l'utilisateur a au moins une des permissions requises
        foreach ($permissions as $permission) {
            if ($user->hasPermissionTo($permission)) {
                return $next($request);
            }
        }

        abort(403, 'Accès refusé. Permission requise: ' . implode(' ou ', $permissions));
    }
}
