<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

/**
 * Déconnecte immédiatement tout utilisateur dont le compte a été désactivé
 * (statut "inactive") — y compris s'il était déjà connecté au moment de la
 * désactivation : sans ce contrôle, "inactif" n'était qu'un badge d'affichage,
 * sans effet sur une session déjà ouverte ni sur une nouvelle connexion.
 */
class EnsureAccountActive
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();

            if ($user->status !== 'active' && !$request->routeIs('logout', 'logout.get')) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('login')
                    ->with('error', 'Ce compte a été désactivé. Contactez votre administrateur.');
            }
        }

        return $next($request);
    }
}
