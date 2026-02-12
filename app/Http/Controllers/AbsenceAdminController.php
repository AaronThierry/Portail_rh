<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Absence;
use App\Models\TypeAbsence;
use App\Models\Personnel;

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

        $query = Absence::with(['personnel', 'typeAbsence', 'enregistrePar'])
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
            ->whereNull('date_sortie')
            ->orderBy('nom')
            ->get();

        return view('admin.absences.index', compact(
            'absences', 'stats', 'annee', 'typeAbsenceId', 'justifiee', 'search',
            'anneesDisponibles', 'typesAbsence', 'personnels'
        ));
    }

    /**
     * Enregistrer une absence
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
            'annee' => \Carbon\Carbon::parse($request->date_absence)->year,
        ]);

        return back()->with('success', 'L\'absence a été enregistrée.');
    }

    /**
     * Détail d'une absence (JSON)
     */
    public function show(Absence $absence)
    {
        $absence->load(['personnel', 'typeAbsence', 'enregistrePar']);
        return response()->json($absence);
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
