<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class FilterByEntreprise
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Partager l'entreprise de l'utilisateur connecté avec toutes les vues
        if (Auth::check() && Auth::user()->entreprise_id) {
            view()->share('current_entreprise', Auth::user()->entreprise);
            view()->share('current_entreprise_id', Auth::user()->entreprise_id);
        }

        return $next($request);
    }
}
