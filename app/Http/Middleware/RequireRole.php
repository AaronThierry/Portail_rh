<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware pour exiger un ou plusieurs rôles spécifiques
 *
 * Usage:
 * Route::get('/admin/dashboard', [AdminController::class, 'index'])
 *     ->middleware('require.role:Super Admin,Admin');
 */
class RequireRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!auth()->check()) {
            abort(401, 'Non authentifié');
        }

        $user = auth()->user();

        // Vérifie si l'utilisateur a au moins un des rôles requis
        if (!$user->hasAnyRole($roles)) {
            abort(403, 'Accès refusé. Rôle requis: ' . implode(' ou ', $roles));
        }

        return $next($request);
    }
}
