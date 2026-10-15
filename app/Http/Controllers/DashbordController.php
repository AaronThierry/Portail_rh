<?php

namespace App\Http\Controllers;

use App\Models\Personnel;
use App\Models\Conge;
use App\Models\Absence;
use App\Models\BulletinPaie;
use App\Models\DocumentAgent;
use App\Models\Entreprise;
use App\Support\AdminQueue;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashbordController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $entrepriseId = $user->entreprise_id;
        $annee = now()->year;

        // --- Statistiques Personnel ---
        $totalEmployes = Personnel::actif()
            ->when($entrepriseId, fn($q) => $q->forEntreprise($entrepriseId))
            ->count();

        $employesAvecCompte = Personnel::actif()->avecCompte()
            ->when($entrepriseId, fn($q) => $q->forEntreprise($entrepriseId))
            ->count();

        // --- Congés ---
        $statsConges = Conge::getStatistiques($entrepriseId, $annee);

        // --- Absences annuelles ---
        $statsAbsences = Absence::getStatistiques($entrepriseId, $annee);

        // --- Bulletins de paie ---
        $statsBulletins = BulletinPaie::getStatistiques($entrepriseId, $annee);

        // --- Documents expirant bientôt (30 jours) ---
        $docsExpirentBientot = DocumentAgent::expirentBientot(30)
            ->when($entrepriseId, fn($q) => $q->whereHas('personnel', fn($p) => $p->forEntreprise($entrepriseId)))
            ->count();

        // --- Données graphique : congés par mois ---
        $congesParMois = [];
        $absencesParMois = [];
        $moisLabels = [];
        for ($m = 1; $m <= 12; $m++) {
            $moisLabels[] = Carbon::create($annee, $m, 1)->translatedFormat('M');

            $congesParMois[] = Conge::where('statut', 'approuve')
                ->where('annee', $annee)
                ->when($entrepriseId, fn($q) => $q->forEntreprise($entrepriseId))
                ->where(function ($q) use ($annee, $m) {
                    $q->whereMonth('date_debut', $m)
                      ->whereYear('date_debut', $annee);
                })
                ->count();

            $absencesParMois[] = Absence::where('statut', 'approuvee')
                ->where('annee', $annee)
                ->when($entrepriseId, fn($q) => $q->forEntreprise($entrepriseId))
                ->whereMonth('date_absence', $m)
                ->count();
        }

        // --- Activités récentes ---
        $activitesRecentes = collect();

        // Derniers congés traités
        $derniersConges = Conge::with('personnel')
            ->whereIn('statut', ['approuve', 'refuse'])
            ->when($entrepriseId, fn($q) => $q->forEntreprise($entrepriseId))
            ->whereNotNull('traite_at')
            ->orderByDesc('traite_at')
            ->limit(5)
            ->get()
            ->map(fn($c) => [
                'type' => 'conge',
                'icon' => $c->statut === 'approuve' ? 'success' : 'danger',
                'titre' => $c->statut === 'approuve' ? 'Congé approuvé' : 'Congé refusé',
                'description' => ($c->personnel->nom ?? '') . ' ' . ($c->personnel->prenoms ?? '') . ' - ' . $c->nombre_jours . ' jours',
                'date' => Carbon::parse($c->traite_at),
            ]);
        $activitesRecentes = $activitesRecentes->merge($derniersConges);

        // Dernières demandes de congé en attente de traitement
        $nouvellesDemandesConge = Conge::with('personnel')
            ->whereIn('statut', ['en_attente', 'valide_chef'])
            ->when($entrepriseId, fn($q) => $q->forEntreprise($entrepriseId))
            ->orderByDesc('created_at')
            ->limit(5)
            ->get()
            ->map(fn($c) => [
                'type' => 'demande_conge',
                'icon' => 'warning',
                'titre' => 'Nouvelle demande de congé',
                'description' => ($c->personnel->nom ?? '') . ' ' . ($c->personnel->prenoms ?? '') . ' - ' . $c->nombre_jours . ' jours',
                'date' => $c->created_at,
            ]);
        $activitesRecentes = $activitesRecentes->merge($nouvellesDemandesConge);

        // Dernières absences déclarées
        $dernieresAbsences = Absence::with('personnel', 'typeAbsence')
            ->when($entrepriseId, fn($q) => $q->forEntreprise($entrepriseId))
            ->orderByDesc('created_at')
            ->limit(5)
            ->get()
            ->map(fn($a) => [
                'type' => 'absence',
                'icon' => 'info',
                'titre' => 'Absence déclarée',
                'description' => ($a->personnel->nom ?? '') . ' ' . ($a->personnel->prenoms ?? '') . ' - ' . ($a->typeAbsence->nom ?? 'Absence'),
                'date' => $a->created_at,
            ]);
        $activitesRecentes = $activitesRecentes->merge($dernieresAbsences);

        // Derniers bulletins uploadés
        $derniersBulletins = BulletinPaie::with('personnel')
            ->when($entrepriseId, fn($q) => $q->forEntreprise($entrepriseId))
            ->orderByDesc('created_at')
            ->limit(5)
            ->get()
            ->map(fn($b) => [
                'type' => 'bulletin',
                'icon' => 'primary',
                'titre' => 'Bulletin de paie uploadé',
                'description' => ($b->personnel->nom ?? '') . ' ' . ($b->personnel->prenoms ?? '') . ' - ' . ($b->mois_nom ?? $b->mois) . ' ' . $b->annee,
                'date' => $b->created_at,
            ]);
        $activitesRecentes = $activitesRecentes->merge($derniersBulletins);

        // Derniers employés ajoutés
        $nouveauxEmployes = Personnel::actif()
            ->when($entrepriseId, fn($q) => $q->forEntreprise($entrepriseId))
            ->orderByDesc('created_at')
            ->limit(3)
            ->get()
            ->map(fn($p) => [
                'type' => 'personnel',
                'icon' => 'primary',
                'titre' => 'Nouvel employé ajouté',
                'description' => $p->nom . ' ' . $p->prenoms . ' - ' . ($p->poste ?? 'N/A'),
                'date' => $p->created_at,
            ]);
        $activitesRecentes = $activitesRecentes->merge($nouveauxEmployes);

        // Trier par date décroissante et prendre les 8 plus récentes
        $activitesRecentes = $activitesRecentes->sortByDesc('date')->take(8)->values();

        // --- Nombre d'entreprises (Super Admin : total / RH + Chef d'Entreprise : son entreprise uniquement) ---
        $totalEntreprises = $user->hasRole('Super Admin')
            ? Entreprise::count()
            : ($entrepriseId ? 1 : 0);

        // --- File « À traiter » (mêmes règles que les pastilles de la barre latérale) ---
        $queue = AdminQueue::counts($user);
        $estChef = AdminQueue::estChef($user);

        $fileConges = AdminQueue::congesQuery($user)
            ->with(['personnel', 'typeConge', 'entreprise'])
            ->orderByRaw('COALESCE(valide_chef_at, created_at) asc')
            ->limit(6)
            ->get();

        $fileAbsences = AdminQueue::absencesQuery($user)
            ->with(['personnel', 'typeAbsence', 'entreprise'])
            ->orderBy('date_absence')
            ->limit(6)
            ->get();

        $requetesQuery = AdminQueue::requetesQuery($user);
        $fileRequetes = $requetesQuery
            ? $requetesQuery->with(['user', 'entreprise'])->latest()->limit(4)->get()
            : collect();

        // Justificatifs déposés sur une absence encore « non justifiée »
        $fileJustificatifs = collect();
        if (!$estChef) {
            $fileJustificatifs = Absence::with(['personnel', 'entreprise'])
                ->where('statut', 'approuvee')
                ->where('justifiee', false)
                ->whereNotNull('justificatif')
                ->when($entrepriseId, fn($q) => $q->forEntreprise($entrepriseId))
                ->orderByDesc('updated_at')
                ->limit(4)
                ->get();
        }

        // --- Aujourd'hui ---
        $aujourdhui = now()->toDateString();
        $enCongeAujourdhui = Conge::with(['personnel', 'typeConge'])
            ->where('statut', 'approuve')
            ->whereDate('date_debut', '<=', $aujourdhui)
            ->whereDate('date_fin', '>=', $aujourdhui)
            ->when($entrepriseId, fn($q) => $q->forEntreprise($entrepriseId))
            ->orderBy('date_fin')
            ->get();
        $absentsAujourdhui = Absence::with(['personnel', 'typeAbsence'])
            ->where('statut', 'approuvee')
            ->whereDate('date_absence', $aujourdhui)
            ->when($entrepriseId, fn($q) => $q->forEntreprise($entrepriseId))
            ->get();

        // --- À surveiller / ce mois-ci ---
        $agentsSansCompte = Personnel::actif()->sansCompte()
            ->when($entrepriseId, fn($q) => $q->forEntreprise($entrepriseId))
            ->count();

        $congesApprouvesMois = Conge::where('statut', 'approuve')
            ->whereBetween('traite_at', [now()->startOfMonth(), now()])
            ->when($entrepriseId, fn($q) => $q->forEntreprise($entrepriseId))
            ->count();

        $absencesMois = Absence::where('statut', 'approuvee')
            ->whereBetween('date_absence', [now()->startOfMonth()->toDateString(), now()->endOfMonth()->toDateString()])
            ->when($entrepriseId, fn($q) => $q->forEntreprise($entrepriseId))
            ->count();

        return view('dashboard', compact(
            'queue',
            'estChef',
            'fileConges',
            'fileAbsences',
            'fileRequetes',
            'fileJustificatifs',
            'enCongeAujourdhui',
            'absentsAujourdhui',
            'agentsSansCompte',
            'congesApprouvesMois',
            'absencesMois',
            'totalEmployes',
            'employesAvecCompte',
            'statsConges',
            'statsAbsences',
            'statsBulletins',
            'docsExpirentBientot',
            'congesParMois',
            'absencesParMois',
            'moisLabels',
            'activitesRecentes',
            'totalEntreprises',
            'annee',
        ));
    }
}
