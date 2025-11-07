<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

/**
 * Middleware pour logger les vérifications de permissions
 *
 * Utile pour l'audit et le débogage
 * À utiliser uniquement en développement ou pour des routes sensibles
 *
 * Usage:
 * Route::delete('/users/{user}', [UserController::class, 'destroy'])
 *     ->middleware('log.permissions');
 */
class LogPermissionChecks
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return $next($request);
        }

        $user = auth()->user();

        // Log avant la requête
        Log::channel('permissions')->info('Permission Check', [
            'user_id' => $user->id,
            'user_email' => $user->email,
            'user_roles' => $user->roles->pluck('name')->toArray(),
            'route' => $request->route()->getName() ?? $request->path(),
            'method' => $request->method(),
            'ip' => $request->ip(),
            'timestamp' => now()->toDateTimeString(),
        ]);

        $response = $next($request);

        // Log après la requête si erreur 403
        if ($response->getStatusCode() === 403) {
            Log::channel('permissions')->warning('Permission Denied', [
                'user_id' => $user->id,
                'user_email' => $user->email,
                'route' => $request->route()->getName() ?? $request->path(),
                'method' => $request->method(),
                'ip' => $request->ip(),
                'timestamp' => now()->toDateTimeString(),
            ]);
        }

        return $response;
    }
}
