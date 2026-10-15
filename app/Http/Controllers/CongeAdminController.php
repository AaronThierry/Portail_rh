<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Conge;
use App\Notifications\CongeStatusNotification;
use App\Services\WhatsAppService;
use App\Support\AdminQueue;

class CongeAdminController extends Controller
{
    /**
     * Onglets de la page Congés, selon l'étape que l'utilisateur fait avancer.
     *
     * @return array<string, array{label:string, statuts:array}>
     */
    protected function vues(bool $estChef): array
    {
        return $estChef
            ? [
                'a_traiter' => ['label' => 'À valider', 'statuts' => ['en_attente']],
                'en_cours'  => ['label' => 'Chez le service RH', 'statuts' => ['valide_chef']],
                'traitees'  => ['label' => 'Traitées', 'statuts' => ['approuve', 'refuse', 'annule']],
                'toutes'    => ['label' => 'Toutes', 'statuts' => []],
            ]
            : [
                'a_traiter' => ['label' => 'À approuver', 'statuts' => ['valide_chef']],
                'en_cours'  => ['label' => 'Chez le chef', 'statuts' => ['en_attente']],
                'traitees'  => ['label' => 'Traitées', 'statuts' => ['approuve', 'refuse', 'annule']],
                'toutes'    => ['label' => 'Toutes', 'statuts' => []],
            ];
    }

    /**
     * Un utilisateur rattaché à une entreprise ne traite que les congés de celle-ci.
     */
    protected function verifierPerimetre(Conge $conge): void
    {
        $entrepriseId = Auth::user()->entreprise_id;
        if ($entrepriseId && (int) $conge->entreprise_id !== (int) $entrepriseId) {
            abort(403);
        }
    }

    /**
     * Liste des demandes de congés (admin) + détail de la demande sélectionnée
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $entrepriseId = $user->entreprise_id;
        $estChef = AdminQueue::estChef($user);
        $vues = $this->vues($estChef);

        $statut = $request->get('statut');
        $search = trim((string) $request->get('search', ''));
        $vue = $request->get('vue');
        if (!$vue || !isset($vues[$vue])) {
            $vue = $statut ? 'toutes' : 'a_traiter';
        }
        // L'année ne filtre que l'historique : une demande en attente reste visible.
        $anneeDemandee = $request->filled('annee');
        $annee = (int) $request->get('annee', now()->year);

        $base = Conge::query()->when($entrepriseId, fn ($q) => $q->forEntreprise($entrepriseId));

        $query = (clone $base)->with(['personnel', 'typeConge', 'entreprise', 'congeParent']);

        if ($statut && array_key_exists($statut, Conge::STATUTS)) {
            $query->statut($statut);
        } elseif ($vues[$vue]['statuts']) {
            $query->whereIn('statut', $vues[$vue]['statuts']);
        }

        if (in_array($vue, ['traitees', 'toutes'], true) || $anneeDemandee) {
            $query->annee($annee);
        }

        if ($search !== '') {
            $query->whereHas('personnel', function ($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                    ->orWhere('prenoms', 'like', "%{$search}%")
                    ->orWhere('matricule', 'like', "%{$search}%");
            });
        }

        if ($vue === 'a_traiter' || $vue === 'en_cours') {
            $query->orderByRaw('COALESCE(valide_chef_at, created_at) asc');
        } else {
            $query->orderByDesc('created_at');
        }

        $conges = $query->paginate(20)->withQueryString();

        // Compteurs des onglets (sans la recherche)
        $compteurs = [];
        foreach ($vues as $cle => $v) {
            $q = clone $base;
            if ($v['statuts']) {
                $q->whereIn('statut', $v['statuts']);
            }
            if (in_array($cle, ['traitees', 'toutes'], true)) {
                $q->annee($annee);
            }
            $compteurs[$cle] = $q->count();
        }

        // Demande sélectionnée : explicitement (?conge=) ou la première de la liste
        $selection = null;
        $selectionExplicite = false;
        if ($request->filled('conge')) {
            $selection = (clone $base)->with(['personnel', 'typeConge', 'entreprise', 'congeParent', 'valideChefPar', 'traitePar'])
                ->find((int) $request->get('conge'));
            $selectionExplicite = (bool) $selection;
        }
        if (!$selection && $conges->count() > 0) {
            $selection = $conges->first()->load(['valideChefPar', 'traitePar']);
        }

        $chevauchements = collect();
        $solde = null;
        if ($selection) {
            $chevauchements = Conge::with(['personnel', 'typeConge'])
                ->where('entreprise_id', $selection->entreprise_id)
                ->where('id', '!=', $selection->id)
                ->whereIn('statut', ['approuve', 'valide_chef', 'en_attente'])
                ->whereDate('date_debut', '<=', $selection->date_fin)
                ->whereDate('date_fin', '>=', $selection->date_debut)
                ->orderBy('date_debut')
                ->limit(8)
                ->get();

            if ($selection->personnel_id && $selection->typeConge && $selection->typeConge->deductible) {
                $solde = Conge::getSolde($selection->personnel_id, $selection->annee ?: $annee, $selection->entreprise_id);
            }
        }

        $stats = Conge::getStatistiques($entrepriseId, $annee);
        $anneesDisponibles = Conge::getAnneesDisponibles(null, $entrepriseId);

        return view('admin.conges.index', compact(
            'conges', 'stats', 'annee', 'statut', 'search', 'anneesDisponibles',
            'vue', 'vues', 'compteurs', 'estChef',
            'selection', 'selectionExplicite', 'chevauchements', 'solde'
        ));
    }

    /**
     * Détail d'une demande de congé
     */
    public function show(Conge $conge)
    {
        $this->verifierPerimetre($conge);
        $conge->load(['personnel', 'typeConge', 'user', 'traitePar', 'congeParent']);

        return response()->json($conge);
    }

    /**
     * Valider / Approuver une demande de congé (2 étapes)
     *
     * Étape 1 — Chef d'Entreprise : en_attente → valide_chef
     * Étape 2 — Super Admin / RH  : en_attente ou valide_chef → approuve
     */
    public function approve(Request $request, Conge $conge)
    {
        $request->validate([
            'commentaire_admin' => 'nullable|string|max:1000',
            'document_officiel' => 'nullable|file|mimes:pdf|max:10240',
        ]);

        $this->verifierPerimetre($conge);
        $user = Auth::user();

        // Étape 1 : Chef d'Entreprise valide en premier
        if ($user->hasRole("Chef d'Entreprise")) {
            if ($conge->statut !== 'en_attente') {
                return back()->with('error', 'Cette demande a déjà été traitée ou n\'est plus en attente.');
            }

            $conge->update([
                'statut' => 'valide_chef',
                'valide_chef_par' => $user->id,
                'valide_chef_at' => now(),
                'commentaire_admin' => $request->commentaire_admin,
            ]);

            return back()->with('success', 'Demande validée. En attente de l\'approbation finale du service RH.');
        }

        // Étape 2 : Super Admin / RH approuve définitivement
        // L'approbation est obligatoirement en 2 étapes : la validation du Chef d'Entreprise est requise
        if ($conge->statut !== 'valide_chef') {
            if ($conge->statut === 'en_attente') {
                return back()->with('error', 'Cette demande doit d\'abord être validée par le Chef d\'Entreprise avant votre approbation finale.');
            }
            return back()->with('error', 'Cette demande a déjà été traitée.');
        }

        $data = [
            'statut' => 'approuve',
            'traite_par' => $user->id,
            'commentaire_admin' => $request->commentaire_admin,
            'traite_at' => now(),
        ];

        if ($request->hasFile('document_officiel')) {
            $file = $request->file('document_officiel');
            $filename = 'conge_' . $conge->id . '_officiel_' . time() . '.pdf';
            $path = $file->storeAs('conges/documents-officiels', $filename, 'public');
            $data['document_officiel'] = $path;
        }

        $conge->update($data);

        // Notifier l'employé
        $conge->load('personnel', 'typeConge');
        if ($conge->user) {
            $conge->user->notify(new CongeStatusNotification($conge, 'approuve'));
        }
        if ($conge->personnel) {
            app(WhatsAppService::class)->notifyCongeValidation($conge, $conge->personnel);
        }

        return back()->with('success', 'La demande de congé a été approuvée définitivement.');
    }

    /**
     * Refuser une demande de congé (n'importe quelle étape)
     */
    public function reject(Request $request, Conge $conge)
    {
        $request->validate([
            'motif_refus' => 'required|string|max:1000',
            'commentaire_admin' => 'nullable|string|max:1000',
        ]);

        $this->verifierPerimetre($conge);
        $user = Auth::user();

        // Chef d'Entreprise peut refuser uniquement en_attente
        if ($user->hasRole("Chef d'Entreprise") && $conge->statut !== 'en_attente') {
            return back()->with('error', 'Vous ne pouvez refuser que les demandes en attente de votre validation.');
        }

        // Super Admin / RH peut refuser en_attente (si bloqué) ou valide_chef
        if (!$user->hasRole("Chef d'Entreprise") && !in_array($conge->statut, ['en_attente', 'valide_chef'])) {
            return back()->with('error', 'Cette demande a déjà été traitée.');
        }

        $conge->update([
            'statut' => 'refuse',
            'traite_par' => $user->id,
            'motif_refus' => $request->motif_refus,
            'commentaire_admin' => $request->commentaire_admin,
            'traite_at' => now(),
        ]);

        // Notifier l'employé
        $conge->load('personnel', 'typeConge');
        if ($conge->user) {
            $conge->user->notify(new CongeStatusNotification($conge, 'refuse'));
        }
        if ($conge->personnel) {
            app(WhatsAppService::class)->notifyCongeValidation($conge, $conge->personnel);
        }

        return back()->with('success', 'La demande de congé a été refusée.');
    }
}
