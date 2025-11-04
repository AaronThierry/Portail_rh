<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware d'authentification Sanctum
 * Vérifie si l'utilisateur est authentifié via session ou token Sanctum
 */
class SanctumAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Vérifie si l'utilisateur est authentifié via le guard 'web' (session)
        // ou via 'sanctum' (token API)
        if (!Auth::guard('web')->check() && !Auth::guard('sanctum')->check()) {
            // Si la requête attend du JSON (API), retourne une erreur 401
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Non authentifié. Veuillez vous connecter.'
                ], 401);
            }

            // Sinon, redirige vers la page de connexion
            return redirect()->route('login')->with('error', 'Vous devez être connecté pour accéder à cette page.');
        }

        return $next($request);
    }
}