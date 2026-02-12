<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;
use Carbon\Carbon;
use App\Models\Personnel;
use App\Models\DocumentAgent;
use App\Models\CategorieDocument;
use App\Models\BulletinPaie;
use App\Models\Conge;
use App\Models\TypeConge;
use App\Models\User;
use App\Models\Absence;
use App\Models\TypeAbsence;
use App\Http\Requests\StoreCongeRequest;
use App\Notifications\NouvelleDemandeCongeNotification;
use App\Notifications\NouvelleDemandeAbsenceNotification;

class EspaceEmployeController extends Controller
{
    /**
     * Affiche le tableau de bord de l'employé
     */
    public function dashboard()
    {
        $user = Auth::user();
        $personnel = $user->personnel;

        // Statistiques pour le dashboard
        $soldeConges = $personnel
            ? Conge::getSolde($personnel->id, now()->year, $personnel->entreprise_id)
            : ['annuels' => 0, 'pris' => 0, 'restants' => 0, 'en_attente' => 0];

        $statsAbsences = $personnel
            ? Absence::getStatistiquesPersonnel($personnel->id, now()->year)
            : ['total' => 0, 'justifiees' => 0, 'injustifiees' => 0, 'retards' => 0];

        $stats = [
            'documents' => $personnel ? $personnel->documents()->count() : 0,
            'conges_restants' => $soldeConges['restants'],
            'demandes_en_cours' => $personnel ? Conge::forPersonnel($personnel->id)->enAttente()->count() : 0,
            'anciennete' => $personnel ? $personnel->anciennete : 0,
            'absences' => $statsAbsences['total'],
            'absences_injustifiees' => $statsAbsences['injustifiees'],
        ];

        // Dernières activités réelles depuis les congés
        $activities = collect([]);
        if ($personnel) {
            $recentConges = Conge::forPersonnel($personnel->id)
                ->with('typeConge')
                ->orderBy('updated_at', 'desc')
                ->take(5)
                ->get();

            foreach ($recentConges as $conge) {
                $activities->push([
                    'type' => 'conge',
                    'title' => match($conge->statut) {
                        'en_attente' => 'Demande de ' . ($conge->typeConge->nom ?? 'congé') . ' soumise',
                        'approuve' => 'Demande de ' . ($conge->typeConge->nom ?? 'congé') . ' approuvée',
                        'refuse' => 'Demande de ' . ($conge->typeConge->nom ?? 'congé') . ' refusée',
                        'annule' => 'Demande de ' . ($conge->typeConge->nom ?? 'congé') . ' annulée',
                        default => 'Demande de congé',
                    },
                    'date' => $conge->updated_at,
                    'icon' => 'calendar',
                ]);
            }

            // Ajouter les documents récents
            $recentDocs = $personnel->documents()
                ->where('visible_employe', true)
                ->orderBy('created_at', 'desc')
                ->take(3)
                ->get();

            foreach ($recentDocs as $doc) {
                $activities->push([
                    'type' => 'document',
                    'title' => ($doc->titre ?? 'Document') . ' ajouté',
                    'date' => $doc->created_at,
                    'icon' => 'file',
                ]);
            }

            $activities = $activities->sortByDesc('date')->take(5)->values();
        }

        return view('espace-employe.dashboard', compact('personnel', 'stats', 'activities'));
    }

    /**
     * Affiche le profil de l'employé
     */
    public function profil()
    {
        $user = Auth::user();
        $personnel = $user->personnel;

        if (!$personnel) {
            return redirect()->route('espace-employe.dashboard')
                ->with('error', 'Profil non trouvé. Veuillez contacter l\'administrateur.');
        }

        $personnel->load(['entreprise', 'departement', 'service']);

        return view('espace-employe.profil', compact('personnel'));
    }

    /**
     * Met à jour le profil de l'employé
     */
    public function updateProfil(Request $request)
    {
        $user = Auth::user();
        $personnel = $user->personnel;

        if (!$personnel) {
            return back()->with('error', 'Profil non trouvé.');
        }

        $request->validate([
            'telephone' => 'nullable|string|max:20',
            'adresse' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->only(['telephone', 'adresse']);

        // Gestion de la photo
        if ($request->hasFile('photo')) {
            // Supprimer l'ancienne photo
            if ($personnel->photo) {
                Storage::disk('public')->delete($personnel->photo);
            }

            $photo = $request->file('photo');
            $filename = 'personnel_' . $personnel->id . '_' . time() . '.' . $photo->getClientOriginalExtension();
            $path = $photo->storeAs('photos/personnel', $filename, 'public');
            $data['photo'] = $path;
        }

        $personnel->update($data);

        return back()->with('success', 'Profil mis à jour avec succès.');
    }

    /**
     * Met à jour le mot de passe
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Le mot de passe actuel est incorrect.']);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Mot de passe modifié avec succès.');
    }

    /**
     * Affiche les documents de l'employé organisés par catégorie
     */
    public function documents(Request $request)
    {
        $user = Auth::user();
        $personnel = $user->personnel;

        // Récupérer tous les documents visibles par l'employé
        $allDocuments = $personnel
            ? $personnel->documents()
                ->where('visible_employe', true)
                ->with('categorie')
                ->orderBy('created_at', 'desc')
                ->get()
            : collect([]);

        // Grouper les documents par catégorie
        $documentsByCategory = $allDocuments->groupBy(function($doc) {
            return $doc->categorie_id ?? 0;
        });

        // Récupérer toutes les catégories qui ont des documents
        $categoriesWithDocs = CategorieDocument::whereIn('id', $documentsByCategory->keys()->filter())
            ->ordered()
            ->get()
            ->keyBy('id');

        // Catégorie sélectionnée (null = vue d'ensemble des dossiers)
        $selectedCategory = $request->get('categorie');
        $currentCategory = null;
        $documents = collect([]);

        if ($selectedCategory) {
            $currentCategory = CategorieDocument::find($selectedCategory);
            $documents = $documentsByCategory->get((int)$selectedCategory, collect([]));
        }

        // Statistiques
        $stats = [
            'total' => $allDocuments->count(),
            'categories' => $categoriesWithDocs->count(),
            'recent' => $allDocuments->where('created_at', '>=', now()->subDays(30))->count(),
            'this_year' => $allDocuments->where('created_at', '>=', now()->startOfYear())->count(),
        ];

        // Documents sans catégorie
        $uncategorizedDocs = $documentsByCategory->get(0, collect([]));

        return view('espace-employe.documents', compact(
            'personnel',
            'allDocuments',
            'documents',
            'documentsByCategory',
            'categoriesWithDocs',
            'currentCategory',
            'selectedCategory',
            'uncategorizedDocs',
            'stats'
        ));
    }

    /**
     * Affiche les bulletins de paie organisés par année/mois (style dossiers)
     */
    public function bulletins(Request $request)
    {
        $user = Auth::user();
        $personnel = $user->personnel;

        if (!$personnel) {
            return redirect()->route('espace-employe.dashboard')
                ->with('error', 'Profil non trouvé. Veuillez contacter l\'administrateur.');
        }

        // Récupérer tous les bulletins visibles de l'employé
        $allBulletins = BulletinPaie::where('personnel_id', $personnel->id)
            ->visibleEmploye()
            ->orderBy('annee', 'desc')
            ->orderBy('mois', 'desc')
            ->get();

        // Statistiques globales
        $totalBulletins = $allBulletins->count();

        // Années disponibles
        $anneesDisponibles = $allBulletins->pluck('annee')->unique()->sort()->reverse()->values();

        // Grouper par année
        $bulletinsParAnnee = $allBulletins->groupBy('annee');

        // Année sélectionnée (par défaut: année courante ou première année disponible)
        $anneeSelectionnee = $request->get('annee', $anneesDisponibles->first() ?? now()->year);

        // Mois sélectionné (optionnel - pour voir un bulletin spécifique)
        $moisSelectionne = $request->get('mois');

        // Bulletins de l'année sélectionnée
        $bulletinsAnnee = $bulletinsParAnnee->get((int)$anneeSelectionnee, collect([]));

        // Construire les données des mois pour l'affichage en grille
        $moisData = [];
        for ($m = 1; $m <= 12; $m++) {
            $bulletin = $bulletinsAnnee->firstWhere('mois', $m);
            $moisData[$m] = [
                'mois' => $m,
                'nom' => BulletinPaie::MOIS_NOMS[$m],
                'nom_court' => BulletinPaie::MOIS_COURTS[$m],
                'bulletin' => $bulletin,
                'disponible' => $bulletin !== null,
            ];
        }

        // Bulletin sélectionné pour prévisualisation
        $bulletinSelectionne = null;
        if ($moisSelectionne && isset($moisData[(int)$moisSelectionne])) {
            $bulletinSelectionne = $moisData[(int)$moisSelectionne]['bulletin'];
        }

        return view('espace-employe.bulletins', compact(
            'personnel',
            'totalBulletins',
            'anneesDisponibles',
            'bulletinsParAnnee',
            'anneeSelectionnee',
            'moisSelectionne',
            'moisData',
            'bulletinSelectionne'
        ));
    }

    /**
     * Prévisualise un bulletin de paie (PDF inline)
     */
    public function previewBulletin(BulletinPaie $bulletin)
    {
        $user = Auth::user();
        $personnel = $user->personnel;

        // Vérifier que le bulletin appartient bien à l'employé connecté
        if (!$personnel || $bulletin->personnel_id !== $personnel->id) {
            abort(403, 'Accès non autorisé');
        }

        // Vérifier que le bulletin est visible pour l'employé
        if (!$bulletin->visible_employe || $bulletin->statut !== 'publie') {
            abort(403, 'Ce bulletin n\'est pas accessible');
        }

        // Vérifier que le fichier existe
        if (!Storage::disk('public')->exists($bulletin->fichier_path)) {
            abort(404, 'Fichier non trouvé');
        }

        return response()->file(
            Storage::disk('public')->path($bulletin->fichier_path),
            ['Content-Type' => 'application/pdf']
        );
    }

    /**
     * Télécharge un bulletin de paie
     */
    public function downloadBulletin(BulletinPaie $bulletin)
    {
        $user = Auth::user();
        $personnel = $user->personnel;

        // Vérifier que le bulletin appartient bien à l'employé connecté
        if (!$personnel || $bulletin->personnel_id !== $personnel->id) {
            abort(403, 'Accès non autorisé');
        }

        // Vérifier que le bulletin est visible pour l'employé
        if (!$bulletin->visible_employe || $bulletin->statut !== 'publie') {
            abort(403, 'Ce bulletin n\'est pas accessible');
        }

        // Vérifier que le fichier existe
        if (!Storage::disk('public')->exists($bulletin->fichier_path)) {
            abort(404, 'Fichier non trouvé');
        }

        // Nom du fichier pour le téléchargement
        $nomFichier = sprintf(
            'Bulletin_Paie_%s_%d.pdf',
            BulletinPaie::MOIS_COURTS[$bulletin->mois],
            $bulletin->annee
        );

        return Storage::disk('public')->download($bulletin->fichier_path, $nomFichier);
    }

    /**
     * Affiche les attestations
     */
    public function attestations()
    {
        $user = Auth::user();
        $personnel = $user->personnel;

        return view('espace-employe.attestations', compact('personnel'));
    }

    /**
     * Affiche la page des congés
     */
    public function conges()
    {
        $user = Auth::user();
        $personnel = $user->personnel;

        if (!$personnel) {
            return redirect()->route('espace-employe.dashboard')
                ->with('error', 'Profil non trouvé.');
        }

        $annee = request('annee', now()->year);

        $soldeConges = Conge::getSolde($personnel->id, $annee, $personnel->entreprise_id);

        $conges = Conge::forPersonnel($personnel->id)
            ->annee($annee)
            ->with('typeConge')
            ->orderBy('date_debut', 'desc')
            ->get();

        $typesConge = TypeConge::forEntreprise($personnel->entreprise_id)
            ->actif()
            ->ordered()
            ->get();

        // Auto-seed des types par défaut si aucun n'existe pour cette entreprise
        if ($typesConge->isEmpty()) {
            foreach (TypeConge::getDefaultTypes() as $type) {
                TypeConge::firstOrCreate(
                    ['entreprise_id' => $personnel->entreprise_id, 'code' => $type['code']],
                    array_merge($type, ['entreprise_id' => $personnel->entreprise_id])
                );
            }
            $typesConge = TypeConge::forEntreprise($personnel->entreprise_id)
                ->actif()
                ->ordered()
                ->get();
        }

        $anneesDisponibles = Conge::getAnneesDisponibles($personnel->id, $personnel->entreprise_id);

        return view('espace-employe.conges', compact(
            'personnel', 'conges', 'soldeConges', 'typesConge', 'annee', 'anneesDisponibles'
        ));
    }

    /**
     * Enregistre une nouvelle demande de congé
     */
    public function storeConge(StoreCongeRequest $request)
    {
        $user = Auth::user();
        $personnel = $user->personnel;

        if (!$personnel) {
            return back()->with('error', 'Profil non trouvé.');
        }

        $nombreJours = Conge::calculerNombreJours(
            $request->date_debut,
            $request->date_fin,
            $request->boolean('demi_journee_debut'),
            $request->boolean('demi_journee_fin')
        );

        $typeConge = TypeConge::findOrFail($request->type_conge_id);
        $annee = Carbon::parse($request->date_debut)->year;

        // Vérifier qu'il n'y a pas de congé en cours qui chevauche les dates demandées
        $chevauchement = Conge::forPersonnel($personnel->id)
            ->whereIn('statut', ['en_attente', 'approuve'])
            ->where(function ($q) use ($request) {
                $q->where(function ($sub) use ($request) {
                    $sub->where('date_debut', '<=', $request->date_fin)
                        ->where('date_fin', '>=', $request->date_debut);
                });
            })
            ->first();

        if ($chevauchement) {
            $msg = 'Vous avez déjà un congé (' . ($chevauchement->typeConge->nom ?? 'Congé') . ') '
                 . 'du ' . $chevauchement->date_debut->format('d/m/Y') . ' au ' . $chevauchement->date_fin->format('d/m/Y')
                 . ' qui chevauche cette période. Vous pouvez prolonger ce congé existant au lieu d\'en créer un nouveau.';
            return back()->withErrors(['date_debut' => $msg])->withInput();
        }

        // Vérifier le solde si le type est déductible
        if ($typeConge->deductible) {
            $solde = Conge::getSolde($personnel->id, $annee, $personnel->entreprise_id);
            if ($nombreJours > $solde['restants']) {
                return back()->withErrors(['date_debut' => 'Solde de congés insuffisant. Il vous reste ' . $solde['restants'] . ' jours.'])->withInput();
            }
        }

        // Upload pièce jointe
        $pieceJointe = null;
        if ($request->hasFile('piece_jointe')) {
            $pieceJointe = $request->file('piece_jointe')
                ->store("conges/{$personnel->entreprise_id}/{$personnel->id}", 'public');
        }

        $conge = Conge::create([
            'entreprise_id' => $personnel->entreprise_id,
            'personnel_id' => $personnel->id,
            'type_conge_id' => $request->type_conge_id,
            'user_id' => $user->id,
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
            'nombre_jours' => $nombreJours,
            'demi_journee_debut' => $request->boolean('demi_journee_debut'),
            'demi_journee_fin' => $request->boolean('demi_journee_fin'),
            'motif' => $request->motif,
            'piece_jointe' => $pieceJointe,
            'statut' => 'en_attente',
            'annee' => $annee,
        ]);

        // Notifier les admins/RH
        $conge->load('personnel', 'typeConge');
        $adminsRH = User::where('entreprise_id', $personnel->entreprise_id)
            ->where('id', '!=', $user->id)
            ->whereHas('roles', fn($q) => $q->whereIn('name', ['Super Admin', 'Admin', 'RH', 'Manager']))
            ->get();

        if ($adminsRH->isNotEmpty()) {
            Notification::send($adminsRH, new NouvelleDemandeCongeNotification($conge));
        }

        return redirect()->route('espace-employe.conges')
            ->with('success', 'Votre demande de congé a été soumise avec succès.');
    }

    /**
     * Annule une demande de congé en attente
     */
    public function annulerConge(Conge $conge)
    {
        $user = Auth::user();
        $personnel = $user->personnel;

        if (!$personnel || $conge->personnel_id !== $personnel->id) {
            abort(403, 'Accès non autorisé');
        }

        if ($conge->statut !== 'en_attente') {
            return back()->with('error', 'Seules les demandes en attente peuvent être annulées.');
        }

        $conge->update(['statut' => 'annule']);

        return back()->with('success', 'La demande de congé a été annulée.');
    }

    /**
     * Prolonger un congé approuvé existant
     */
    public function prolongerConge(Request $request, Conge $conge)
    {
        $user = Auth::user();
        $personnel = $user->personnel;

        if (!$personnel || $conge->personnel_id !== $personnel->id) {
            abort(403, 'Accès non autorisé');
        }

        if ($conge->statut !== 'approuve') {
            return back()->with('error', 'Seuls les congés approuvés peuvent être prolongés.');
        }

        $request->validate([
            'nouvelle_date_fin' => ['required', 'date', 'after:' . $conge->date_fin->format('Y-m-d')],
            'motif' => ['nullable', 'string', 'max:1000'],
            'piece_jointe' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
        ], [
            'nouvelle_date_fin.required' => 'La nouvelle date de fin est obligatoire.',
            'nouvelle_date_fin.after' => 'La nouvelle date de fin doit être postérieure au ' . $conge->date_fin->format('d/m/Y') . '.',
        ]);

        // Calculer les jours supplémentaires (du lendemain de l'ancienne fin jusqu'à la nouvelle fin)
        $ancienneFin = $conge->date_fin->copy()->addDay();
        $nouvelleFin = Carbon::parse($request->nouvelle_date_fin);
        $joursSupp = Conge::calculerNombreJours($ancienneFin, $nouvelleFin);

        // Vérifier le solde si le type est déductible
        $typeConge = $conge->typeConge;
        $annee = $conge->annee;

        if ($typeConge && $typeConge->deductible) {
            $solde = Conge::getSolde($personnel->id, $annee, $personnel->entreprise_id);
            if ($joursSupp > $solde['restants']) {
                return back()->withErrors(['nouvelle_date_fin' => 'Solde insuffisant. Il vous reste ' . $solde['restants'] . ' jours, mais la prolongation nécessite ' . $joursSupp . ' jours.'])->withInput();
            }
        }

        // Upload pièce jointe
        $pieceJointe = null;
        if ($request->hasFile('piece_jointe')) {
            $pieceJointe = $request->file('piece_jointe')
                ->store("conges/{$personnel->entreprise_id}/{$personnel->id}", 'public');
        }

        // Créer une demande de prolongation liée au congé parent
        $prolongation = Conge::create([
            'entreprise_id' => $personnel->entreprise_id,
            'personnel_id' => $personnel->id,
            'type_conge_id' => $conge->type_conge_id,
            'user_id' => $user->id,
            'date_debut' => $ancienneFin,
            'date_fin' => $nouvelleFin,
            'nombre_jours' => $joursSupp,
            'motif' => $request->motif ? 'Prolongation : ' . $request->motif : 'Prolongation du congé #' . $conge->id,
            'piece_jointe' => $pieceJointe,
            'statut' => 'en_attente',
            'annee' => $annee,
            'conge_parent_id' => $conge->id,
        ]);

        // Notifier les admins/RH
        $prolongation->load('personnel', 'typeConge');
        $adminsRH = User::where('entreprise_id', $personnel->entreprise_id)
            ->where('id', '!=', $user->id)
            ->whereHas('roles', fn($q) => $q->whereIn('name', ['Super Admin', 'Admin', 'RH', 'Manager']))
            ->get();

        if ($adminsRH->isNotEmpty()) {
            Notification::send($adminsRH, new NouvelleDemandeCongeNotification($prolongation));
        }

        return redirect()->route('espace-employe.conges')
            ->with('success', 'Votre demande de prolongation a été soumise (' . $joursSupp . ' jours supplémentaires).');
    }

    /**
     * Télécharger le document officiel d'un congé approuvé
     */
    public function downloadDocumentOfficiel(Conge $conge)
    {
        $user = Auth::user();
        $personnel = $user->personnel;

        if (!$personnel || $conge->personnel_id !== $personnel->id) {
            abort(403, 'Accès non autorisé');
        }

        if (!$conge->document_officiel || !Storage::disk('public')->exists($conge->document_officiel)) {
            return back()->with('error', 'Aucun document officiel disponible.');
        }

        return Storage::disk('public')->download($conge->document_officiel, 'note_conge_' . $conge->id . '.pdf');
    }

    /**
     * Affiche les demandes de l'employé
     */
    public function demandes()
    {
        $user = Auth::user();
        $personnel = $user->personnel;

        if (!$personnel) {
            return redirect()->route('espace-employe.dashboard')
                ->with('error', 'Profil non trouvé.');
        }

        $demandes = Conge::forPersonnel($personnel->id)
            ->with('typeConge')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('espace-employe.demandes', compact('personnel', 'demandes'));
    }

    /**
     * Affiche les absences de l'employé
     */
    public function absences(Request $request)
    {
        $user = Auth::user();
        $personnel = $user->personnel;

        if (!$personnel) {
            return redirect()->route('espace-employe.dashboard')
                ->with('error', 'Profil non trouvé.');
        }

        $annee = $request->get('annee', now()->year);

        $absences = Absence::forPersonnel($personnel->id)
            ->annee($annee)
            ->with('typeAbsence')
            ->orderBy('date_absence', 'desc')
            ->get();

        $statsAbsences = Absence::getStatistiquesPersonnel($personnel->id, $annee);

        $anneesDisponibles = Absence::getAnneesDisponibles($personnel->id);

        // Types d'absences pour le formulaire
        $typesAbsence = TypeAbsence::forEntreprise($personnel->entreprise_id)->actif()->ordered()->get();

        // Auto-seed si vide
        if ($typesAbsence->isEmpty()) {
            foreach (TypeAbsence::getDefaultTypes() as $type) {
                TypeAbsence::firstOrCreate(
                    ['entreprise_id' => $personnel->entreprise_id, 'code' => $type['code']],
                    array_merge($type, ['entreprise_id' => $personnel->entreprise_id])
                );
            }
            $typesAbsence = TypeAbsence::forEntreprise($personnel->entreprise_id)->actif()->ordered()->get();
        }

        return view('espace-employe.absences', compact(
            'personnel', 'absences', 'statsAbsences', 'annee', 'anneesDisponibles', 'typesAbsence'
        ));
    }

    /**
     * Enregistre une demande d'absence par l'employé
     */
    public function storeAbsence(Request $request)
    {
        $user = Auth::user();
        $personnel = $user->personnel;

        if (!$personnel) {
            return back()->with('error', 'Profil non trouvé.');
        }

        $request->validate([
            'type_absence_id' => 'required|exists:type_absences,id',
            'date_absence' => 'required|date',
            'duree_type' => 'required|in:journee,demi_journee,retard,depart_anticipe',
            'minutes_retard' => 'nullable|integer|min:1|max:480',
            'motif' => 'required|string|max:1000',
            'justificatif' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ], [
            'type_absence_id.required' => 'Le type d\'absence est obligatoire.',
            'date_absence.required' => 'La date est obligatoire.',
            'motif.required' => 'Le motif est obligatoire pour une déclaration d\'absence.',
        ]);

        // Vérifier doublon
        $existe = Absence::where('personnel_id', $personnel->id)
            ->where('date_absence', $request->date_absence)
            ->where('duree_type', $request->duree_type)
            ->whereIn('statut', ['en_attente', 'approuvee'])
            ->exists();

        if ($existe) {
            return back()->with('error', 'Une absence existe déjà pour cette date et ce type de durée.')->withInput();
        }

        $justificatif = null;
        if ($request->hasFile('justificatif')) {
            $justificatif = $request->file('justificatif')
                ->store("absences/{$personnel->entreprise_id}/{$personnel->id}", 'public');
        }

        $absence = Absence::create([
            'entreprise_id' => $personnel->entreprise_id,
            'personnel_id' => $personnel->id,
            'type_absence_id' => $request->type_absence_id,
            'enregistre_par' => $user->id,
            'date_absence' => $request->date_absence,
            'duree_type' => $request->duree_type,
            'minutes_retard' => $request->duree_type === 'retard' ? $request->minutes_retard : null,
            'motif' => $request->motif,
            'justificatif' => $justificatif,
            'justifiee' => false,
            'source' => 'employe',
            'statut' => 'en_attente',
            'annee' => Carbon::parse($request->date_absence)->year,
        ]);

        // Notifier les admins/RH
        $absence->load('personnel', 'typeAbsence');
        $adminsRH = User::where('entreprise_id', $personnel->entreprise_id)
            ->where('id', '!=', $user->id)
            ->whereHas('roles', fn($q) => $q->whereIn('name', ['Super Admin', 'Admin', 'RH', 'Manager']))
            ->get();

        if ($adminsRH->isNotEmpty()) {
            Notification::send($adminsRH, new NouvelleDemandeAbsenceNotification($absence));
        }

        return redirect()->route('espace-employe.absences')
            ->with('success', 'Votre déclaration d\'absence a été soumise avec succès.');
    }

    /**
     * Soumettre un justificatif pour une absence existante non justifiée
     */
    public function justifierAbsence(Request $request, Absence $absence)
    {
        $user = Auth::user();
        $personnel = $user->personnel;

        if (!$personnel || $absence->personnel_id !== $personnel->id) {
            abort(403, 'Accès non autorisé');
        }

        if ($absence->justifiee) {
            return back()->with('error', 'Cette absence est déjà justifiée.');
        }

        $request->validate([
            'justificatif' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'motif' => 'nullable|string|max:1000',
        ], [
            'justificatif.required' => 'Un justificatif est obligatoire.',
        ]);

        $justificatif = $request->file('justificatif')
            ->store("absences/{$personnel->entreprise_id}/{$personnel->id}", 'public');

        $absence->update([
            'justificatif' => $justificatif,
            'motif' => $request->motif ?: $absence->motif,
            'statut' => 'en_attente',
        ]);

        // Notifier les admins/RH
        $absence->load('personnel', 'typeAbsence');
        $adminsRH = User::where('entreprise_id', $personnel->entreprise_id)
            ->where('id', '!=', $user->id)
            ->whereHas('roles', fn($q) => $q->whereIn('name', ['Super Admin', 'Admin', 'RH', 'Manager']))
            ->get();

        if ($adminsRH->isNotEmpty()) {
            Notification::send($adminsRH, new NouvelleDemandeAbsenceNotification($absence));
        }

        return back()->with('success', 'Votre justificatif a été soumis. L\'administration va l\'examiner.');
    }

    /**
     * Annuler une demande d'absence en attente
     */
    public function annulerAbsence(Absence $absence)
    {
        $user = Auth::user();
        $personnel = $user->personnel;

        if (!$personnel || $absence->personnel_id !== $personnel->id) {
            abort(403, 'Accès non autorisé');
        }

        if ($absence->statut !== 'en_attente' || $absence->source !== 'employe') {
            return back()->with('error', 'Seules vos demandes en attente peuvent être annulées.');
        }

        $absence->delete();

        return back()->with('success', 'La déclaration d\'absence a été annulée.');
    }

    /**
     * Affiche les paramètres
     */
    public function parametres()
    {
        $user = Auth::user();
        $personnel = $user->personnel;

        return view('espace-employe.parametres', compact('personnel', 'user'));
    }

    /**
     * Prévisualise un document
     */
    public function previewDocument($id)
    {
        $user = Auth::user();
        $personnel = $user->personnel;

        if (!$personnel) {
            abort(403, 'Accès non autorisé');
        }

        $document = DocumentAgent::where('id', $id)
            ->where('personnel_id', $personnel->id)
            ->where('visible_employe', true)
            ->firstOrFail();

        if (empty($document->chemin)) {
            abort(404, 'Aucun fichier associé à ce document');
        }

        // Essayer plusieurs chemins possibles (dossiers_agents est le disk utilisé)
        $possiblePaths = [
            storage_path('app/dossiers_agents/' . $document->chemin),
            storage_path('app/public/dossiers_agents/' . $document->chemin),
            storage_path('app/' . $document->chemin),
        ];

        $path = null;
        foreach ($possiblePaths as $possiblePath) {
            if (file_exists($possiblePath)) {
                $path = $possiblePath;
                break;
            }
        }

        if (!$path) {
            abort(404, 'Fichier non trouvé sur le serveur');
        }

        $mimeType = $document->mime_type ?? mime_content_type($path);

        return response()->file($path, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="' . $document->titre . '.' . $document->extension . '"'
        ]);
    }

    /**
     * Télécharge un document
     */
    public function downloadDocument($id)
    {
        $user = Auth::user();
        $personnel = $user->personnel;

        if (!$personnel) {
            abort(403, 'Accès non autorisé');
        }

        $document = DocumentAgent::where('id', $id)
            ->where('personnel_id', $personnel->id)
            ->where('visible_employe', true)
            ->firstOrFail();

        if (empty($document->chemin)) {
            abort(404, 'Aucun fichier associé à ce document');
        }

        // Essayer plusieurs chemins possibles (dossiers_agents est le disk utilisé)
        $possiblePaths = [
            storage_path('app/dossiers_agents/' . $document->chemin),
            storage_path('app/public/dossiers_agents/' . $document->chemin),
            storage_path('app/' . $document->chemin),
        ];

        $path = null;
        foreach ($possiblePaths as $possiblePath) {
            if (file_exists($possiblePath)) {
                $path = $possiblePath;
                break;
            }
        }

        if (!$path) {
            abort(404, 'Fichier non trouvé sur le serveur');
        }

        $filename = $document->titre . '.' . $document->extension;

        return response()->download($path, $filename);
    }
}
