<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TwoFactorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        // Si l'utilisateur n'est pas authentifié, laisser passer (géré par auth middleware)
        if (!$user) {
            return $next($request);
        }

        // Si le 2FA n'est pas activé pour cet utilisateur, laisser passer
        if (!$user->google2fa_enabled) {
            return $next($request);
        }

        // Si l'utilisateur a déjà vérifié son 2FA dans cette session, laisser passer
        if (session('2fa_verified')) {
            return $next($request);
        }

        // Routes exemptées de la vérification 2FA
        $exemptedRoutes = [
            'two-factor.show',
            'two-factor.verify.login',
            'logout'
        ];

        if (in_array($request->route()->getName(), $exemptedRoutes)) {
            return $next($request);
        }

        // Rediriger vers la page de vérification 2FA
        return redirect()->route('two-factor.show');
    }
}
