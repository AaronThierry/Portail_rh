<?php

namespace App\Http\Controllers;

use App\Models\Requete;
use App\Models\User;
use App\Notifications\NouvelleRequeteNotification;
use App\Notifications\ReponseRequeteNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RequeteController extends Controller
{
    /* ══════════════════════════════════════════════════════
     |  CHEF D'ENTREPRISE — ses requêtes
     ══════════════════════════════════════════════════════ */

    /**
     * Liste des requêtes du Chef d'Entreprise connecté
     */
    public function index(Request $request)
    {
        $user   = Auth::user();
        $statut = $request->get('statut');

        $query = Requete::with(['reponduPar'])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc');

        if ($statut) {
            $query->where('statut', $statut);
        }

        $requetes = $query->paginate(15);
        $stats    = [
            'total'      => Requete::where('user_id', $user->id)->count(),
            'en_attente' => Requete::where('user_id', $user->id)->where('statut', 'en_attente')->count(),
            'repondue'   => Requete::where('user_id', $user->id)->where('statut', 'repondue')->count(),
            'non_lues'   => Requete::where('user_id', $user->id)->where('lu_par_chef', false)->where('statut', 'repondue')->count(),
        ];

        return view('chef.requetes.index', compact('requetes', 'stats', 'statut'));
    }

    /**
     * Formulaire de création
     */
    public function create()
    {
        return view('chef.requetes.create');
    }

    /**
     * Enregistre la requête et notifie le Super Admin
     */
    public function store(Request $request)
    {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'sujet'     => 'required|string|max:150',
            'categorie' => 'required|in:question,facturation,support,autre',
            'priorite'  => 'required|in:normale,urgente',
            'message'   => 'required|string|min:10|max:3000',
        ], [
            'sujet.required'     => 'Le sujet est obligatoire.',
            'message.required'   => 'Le message est obligatoire.',
            'message.min'        => 'Le message doit contenir au moins 10 caractères.',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('admin.requetes.index')
                ->withErrors($validator)
                ->withInput();
        }

        $user = Auth::user();

        $requete = Requete::create([
            'entreprise_id' => $user->entreprise_id,
            'user_id'       => $user->id,
            'sujet'         => $request->sujet,
            'categorie'     => $request->categorie,
            'priorite'      => $request->priorite,
            'message'       => $request->message,
            'lu_par_chef'   => true,
            'lu_par_admin'  => false,
        ]);

        // Notifier le Super Admin (DB + WhatsApp)
        $superAdmin = User::role('Super Admin')->first();
        if ($superAdmin) {
            try {
                $superAdmin->notify(new NouvelleRequeteNotification($requete));
            } catch (\Throwable $e) {
                \Log::error('Erreur notification SuperAdmin requete: ' . $e->getMessage());
            }
        }

        return redirect()
            ->route('admin.requetes.index')
            ->with('success', 'Votre requête a été envoyée avec succès. Nous vous répondrons dans les plus brefs délais.');
    }

    /**
     * Détail d'une requête pour le Chef (marque comme lu)
     */
    public function show(Requete $requete)
    {
        // Sécurité : le Chef ne peut voir que ses propres requêtes
        if (!Auth::user()->hasRole('Super Admin') && $requete->user_id !== Auth::id()) {
            abort(403);
        }

        // Marquer comme lu par le chef si répondue
        if ($requete->statut === 'repondue' && !$requete->lu_par_chef) {
            $requete->update(['lu_par_chef' => true]);
        }

        return view('chef.requetes.show', compact('requete'));
    }

    /* ══════════════════════════════════════════════════════
     |  SUPER ADMIN — inbox
     ══════════════════════════════════════════════════════ */

    /**
     * Inbox Super Admin — toutes les requêtes
     */
    public function adminIndex(Request $request)
    {
        $statut   = $request->get('statut');
        $search   = $request->get('search');
        $priorite = $request->get('priorite');

        $query = Requete::with(['user', 'entreprise', 'reponduPar'])
            ->orderByRaw("CASE WHEN priorite = 'urgente' THEN 0 ELSE 1 END")
            ->orderBy('created_at', 'desc');

        if ($statut) {
            $query->where('statut', $statut);
        }
        if ($priorite) {
            $query->where('priorite', $priorite);
        }
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('sujet', 'like', "%{$search}%")
                  ->orWhereHas('entreprise', fn($q) => $q->where('nom', 'like', "%{$search}%"))
                  ->orWhereHas('user', fn($q) => $q->where('name', 'like', "%{$search}%"));
            });
        }

        $requetes = $query->paginate(20);
        $stats    = [
            'total'      => Requete::count(),
            'non_lues'   => Requete::where('lu_par_admin', false)->whereIn('statut', ['en_attente', 'en_cours'])->count(),
            'en_attente' => Requete::where('statut', 'en_attente')->count(),
            'urgentes'   => Requete::where('priorite', 'urgente')->whereNotIn('statut', ['repondue', 'fermee'])->count(),
            'repondues'  => Requete::where('statut', 'repondue')->count(),
        ];

        return view('admin.requetes.index', compact('requetes', 'stats', 'statut', 'search', 'priorite'));
    }

    /**
     * Détail d'une requête (Super Admin) — marque comme lu
     */
    public function adminShow(Requete $requete)
    {
        if (!$requete->lu_par_admin) {
            $requete->update(['lu_par_admin' => true, 'statut' => $requete->statut === 'en_attente' ? 'en_cours' : $requete->statut]);
        }

        $requete->load(['user', 'entreprise', 'reponduPar']);

        return view('admin.requetes.show', compact('requete'));
    }

    /**
     * Répondre à une requête
     */
    public function adminReply(Request $request, Requete $requete)
    {
        $request->validate([
            'reponse' => 'required|string|min:5|max:3000',
        ], [
            'reponse.required' => 'La réponse est obligatoire.',
            'reponse.min'      => 'La réponse doit contenir au moins 5 caractères.',
        ]);

        $requete->update([
            'reponse'     => $request->reponse,
            'statut'      => 'repondue',
            'repondu_par' => Auth::id(),
            'repondu_le'  => now(),
            'lu_par_chef' => false,
        ]);

        // Notifier le Chef d'Entreprise
        try {
            $requete->user->notify(new ReponseRequeteNotification($requete));
        } catch (\Throwable $e) {
            \Log::error('Erreur notification Chef requete: ' . $e->getMessage());
        }

        return redirect()
            ->route('admin.admin-requetes.show', $requete)
            ->with('success', 'Réponse envoyée avec succès.');
    }

    /**
     * Fermer une requête
     */
    public function adminClose(Requete $requete)
    {
        $requete->update(['statut' => 'fermee']);

        return redirect()
            ->route('admin.admin-requetes.index')
            ->with('success', "La requête « {$requete->sujet} » a été fermée.");
    }
}
