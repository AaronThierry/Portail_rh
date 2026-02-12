<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Conge;
use App\Notifications\CongeStatusNotification;

class CongeAdminController extends Controller
{
    /**
     * Liste des demandes de congés (admin)
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $entrepriseId = $user->entreprise_id;

        $annee = $request->get('annee', now()->year);
        $statut = $request->get('statut');
        $search = $request->get('search');

        $query = Conge::with(['personnel', 'typeConge', 'user', 'traitePar', 'congeParent'])
            ->orderBy('created_at', 'desc');

        if ($entrepriseId) {
            $query->forEntreprise($entrepriseId);
        }

        if ($annee) {
            $query->annee($annee);
        }

        if ($statut) {
            $query->statut($statut);
        }

        if ($search) {
            $query->whereHas('personnel', function ($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                    ->orWhere('prenoms', 'like', "%{$search}%")
                    ->orWhere('matricule', 'like', "%{$search}%");
            });
        }

        $conges = $query->paginate(20);

        $stats = Conge::getStatistiques($entrepriseId, $annee);

        $anneesDisponibles = Conge::getAnneesDisponibles(null, $entrepriseId);

        return view('admin.conges.index', compact(
            'conges', 'stats', 'annee', 'statut', 'search', 'anneesDisponibles'
        ));
    }

    /**
     * Détail d'une demande de congé
     */
    public function show(Conge $conge)
    {
        $conge->load(['personnel', 'typeConge', 'user', 'traitePar', 'congeParent']);

        return response()->json($conge);
    }

    /**
     * Approuver une demande de congé
     */
    public function approve(Request $request, Conge $conge)
    {
        $request->validate([
            'commentaire_admin' => 'nullable|string|max:1000',
            'document_officiel' => 'nullable|file|mimes:pdf|max:10240',
        ]);

        if ($conge->statut !== 'en_attente') {
            return back()->with('error', 'Cette demande a déjà été traitée.');
        }

        $data = [
            'statut' => 'approuve',
            'traite_par' => Auth::id(),
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

        return back()->with('success', 'La demande de congé a été approuvée.');
    }

    /**
     * Refuser une demande de congé
     */
    public function reject(Request $request, Conge $conge)
    {
        $request->validate([
            'motif_refus' => 'required|string|max:1000',
            'commentaire_admin' => 'nullable|string|max:1000',
        ]);

        if ($conge->statut !== 'en_attente') {
            return back()->with('error', 'Cette demande a déjà été traitée.');
        }

        $conge->update([
            'statut' => 'refuse',
            'traite_par' => Auth::id(),
            'motif_refus' => $request->motif_refus,
            'commentaire_admin' => $request->commentaire_admin,
            'traite_at' => now(),
        ]);

        // Notifier l'employé
        $conge->load('personnel', 'typeConge');
        if ($conge->user) {
            $conge->user->notify(new CongeStatusNotification($conge, 'refuse'));
        }

        return back()->with('success', 'La demande de congé a été refusée.');
    }
}
