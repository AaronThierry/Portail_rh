<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class ForcePasswordChange
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Vérifier si l'utilisateur est authentifié
        if (Auth::check()) {
            $user = Auth::user();

            // Liste des routes autorisées même si le changement de mot de passe est requis
            $allowedRoutes = [
                'password.change-first',
                'password.update-first',
                'logout'
            ];

            // Vérifier si l'utilisateur doit changer son mot de passe
            if ($user->force_password_change && !$request->routeIs($allowedRoutes)) {
                return redirect()->route('password.change-first')
                    ->with('warning', 'Vous devez changer votre mot de passe avant de continuer.');
            }
        }

        return $next($request);
    }
}
