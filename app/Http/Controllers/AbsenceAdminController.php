<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Absence;
use App\Models\TypeAbsence;
use App\Models\Personnel;
use App\Models\User;
use App\Notifications\AbsenceStatusNotification;

class AbsenceAdminController extends Controller
{
    /**
     * Liste des absences (admin)
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $entrepriseId = $user->entreprise_id;

        $annee = $request->get('annee', now()->year);
        $typeAbsenceId = $request->get('type_absence');
        $justifiee = $request->get('justifiee');
        $search = $request->get('search');
        $statut = $request->get('statut');

        $query = Absence::with(['personnel', 'typeAbsence', 'enregistrePar', 'traitePar'])
            ->orderBy('date_absence', 'desc');

        if ($entrepriseId) {
            $query->forEntreprise($entrepriseId);
        }

        if ($annee) {
            $query->annee($annee);
        }

        if ($typeAbsenceId) {
            $query->where('type_absence_id', $typeAbsenceId);
        }

        if ($justifiee !== null && $justifiee !== '') {
            $query->where('justifiee', $justifiee === '1');
        }

        if ($statut) {
            $query->where('statut', $statut);
        }

        if ($search) {
            $query->whereHas('personnel', function ($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                    ->orWhere('prenoms', 'like', "%{$search}%")
                    ->orWhere('matricule', 'like', "%{$search}%");
            });
        }

        $absences = $query->paginate(20);

        $stats = Absence::getStatistiques($entrepriseId, $annee);

        $anneesDisponibles = Absence::getAnneesDisponibles(null, $entrepriseId);

        // Types d'absences pour le formulaire
        $typesAbsence = TypeAbsence::forEntreprise($entrepriseId)->actif()->ordered()->get();

        // Auto-seed si vide
        if ($typesAbsence->isEmpty() && $entrepriseId) {
            foreach (TypeAbsence::getDefaultTypes() as $type) {
                TypeAbsence::create(array_merge($type, ['entreprise_id' => $entrepriseId]));
            }
            $typesAbsence = TypeAbsence::forEntreprise($entrepriseId)->actif()->ordered()->get();
        }

        // Liste des personnels pour le formulaire d'ajout
        $personnels = Personnel::where('entreprise_id', $entrepriseId)
            ->actif()
            ->orderBy('nom')
            ->get();

        return view('admin.absences.index', compact(
            'absences', 'stats', 'annee', 'typeAbsenceId', 'justifiee', 'search', 'statut',
            'anneesDisponibles', 'typesAbsence', 'personnels'
        ));
    }

    /**
     * Enregistrer une absence (par l'admin)
     */
    public function store(Request $request)
    {
        $request->validate([
            'personnel_id' => 'required|exists:personnels,id',
            'type_absence_id' => 'required|exists:type_absences,id',
            'date_absence' => 'required|date',
            'duree_type' => 'required|in:journee,demi_journee,retard,depart_anticipe',
            'heure_debut' => 'nullable|date_format:H:i',
            'heure_fin' => 'nullable|date_format:H:i',
            'minutes_retard' => 'nullable|integer|min:1|max:480',
            'motif' => 'nullable|string|max:1000',
            'commentaire_admin' => 'nullable|string|max:1000',
            'justificatif' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'justifiee' => 'nullable|boolean',
        ], [
            'personnel_id.required' => 'L\'employé est obligatoire.',
            'type_absence_id.required' => 'Le type d\'absence est obligatoire.',
            'date_absence.required' => 'La date est obligatoire.',
            'duree_type.required' => 'Le type de durée est obligatoire.',
        ]);

        $user = Auth::user();

        // Vérifier si une absence existe déjà pour cet employé à cette date
        $existe = Absence::where('personnel_id', $request->personnel_id)
            ->where('date_absence', $request->date_absence)
            ->where('duree_type', $request->duree_type)
            ->whereIn('statut', ['en_attente', 'approuvee'])
            ->exists();

        if ($existe) {
            return back()->with('error', 'Une absence de ce type existe déjà pour cet employé à cette date.')->withInput();
        }

        $justificatif = null;
        if ($request->hasFile('justificatif')) {
            $justificatif = $request->file('justificatif')
                ->store('absences/justificatifs', 'public');
        }

        $personnel = Personnel::findOrFail($request->personnel_id);

        Absence::create([
            'entreprise_id' => $personnel->entreprise_id,
            'personnel_id' => $request->personnel_id,
            'type_absence_id' => $request->type_absence_id,
            'enregistre_par' => $user->id,
            'date_absence' => $request->date_absence,
            'heure_debut' => $request->heure_debut,
            'heure_fin' => $request->heure_fin,
            'duree_type' => $request->duree_type,
            'minutes_retard' => $request->duree_type === 'retard' ? $request->minutes_retard : null,
            'motif' => $request->motif,
            'commentaire_admin' => $request->commentaire_admin,
            'justificatif' => $justificatif,
            'justifiee' => $request->boolean('justifiee'),
            'source' => 'admin',
            'statut' => 'approuvee',
            'annee' => \Carbon\Carbon::parse($request->date_absence)->year,
        ]);

        return back()->with('success', 'L\'absence a été enregistrée.');
    }

    /**
     * Détail d'une absence (JSON)
     */
    public function show(Absence $absence)
    {
        $absence->load(['personnel', 'typeAbsence', 'enregistrePar', 'traitePar']);
        return response()->json($absence);
    }

    /**
     * Approuver une demande d'absence / justification
     */
    public function approve(Absence $absence)
    {
        if ($absence->statut !== 'en_attente') {
            return back()->with('error', 'Cette absence a déjà été traitée.');
        }

        $absence->update([
            'statut' => 'approuvee',
            'justifiee' => true,
            'traite_par' => Auth::id(),
            'traite_at' => now(),
        ]);

        // Notifier l'employé
        $absence->load('personnel', 'typeAbsence');
        $userEmploye = User::where('personnel_id', $absence->personnel_id)->first();
        if ($userEmploye) {
            $userEmploye->notify(new AbsenceStatusNotification($absence, 'approuvee'));
        }

        return back()->with('success', 'L\'absence a été approuvée et justifiée.');
    }

    /**
     * Refuser une demande d'absence / justification
     */
    public function reject(Request $request, Absence $absence)
    {
        $request->validate([
            'motif_refus' => 'required|string|max:1000',
        ], [
            'motif_refus.required' => 'Le motif de refus est obligatoire.',
        ]);

        if ($absence->statut !== 'en_attente') {
            return back()->with('error', 'Cette absence a déjà été traitée.');
        }

        // Si c'est une déclaration employé, on refuse (statut refusee)
        // Si c'est une justification d'absence admin, on remet en approuvee mais injustifiée
        if ($absence->source === 'employe') {
            $absence->update([
                'statut' => 'refusee',
                'motif_refus' => $request->motif_refus,
                'traite_par' => Auth::id(),
                'traite_at' => now(),
            ]);
        } else {
            $absence->update([
                'statut' => 'approuvee',
                'justifiee' => false,
                'motif_refus' => $request->motif_refus,
                'traite_par' => Auth::id(),
                'traite_at' => now(),
            ]);
        }

        // Notifier l'employé
        $absence->load('personnel', 'typeAbsence');
        $userEmploye = User::where('personnel_id', $absence->personnel_id)->first();
        if ($userEmploye) {
            $userEmploye->notify(new AbsenceStatusNotification($absence, 'refusee'));
        }

        return back()->with('success', 'L\'absence a été refusée.');
    }

    /**
     * Modifier le statut justifiée d'une absence
     */
    public function toggleJustifiee(Absence $absence)
    {
        $absence->update(['justifiee' => !$absence->justifiee]);
        return back()->with('success', 'Le statut a été mis à jour.');
    }

    /**
     * Supprimer une absence
     */
    public function destroy(Absence $absence)
    {
        $absence->delete();
        return back()->with('success', 'L\'absence a été supprimée.');
    }
}
