<?php

namespace App\Http\Controllers;

use App\Models\BulletinPaie;
use App\Models\Personnel;
use App\Models\Entreprise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Notifications\BulletinPaieNotification;

class BulletinPaieController extends Controller
{
    /**
     * Afficher la liste des bulletins (vue admin)
     * Organisé par année > mois avec navigation intuitive
     */
    public function index(Request $request)
    {
        $anneeSelectionnee = $request->get('annee', now()->year);
        $moisSelectionne = $request->get('mois');
        $search = $request->get('search');

        // Années disponibles pour le filtre
        $anneesDisponibles = BulletinPaie::getAnneesDisponibles();
        if ($anneesDisponibles->isEmpty()) {
            $anneesDisponibles = collect([now()->year]);
        }

        // Timeline de l'année sélectionnée
        $timeline = BulletinPaie::getTimelineAnnee($anneeSelectionnee);

        // Bulletins filtrés
        $query = BulletinPaie::with(['personnel', 'uploadedBy'])
            ->annee($anneeSelectionnee)
            ->orderBy('mois', 'desc')
            ->orderBy('created_at', 'desc');

        if ($moisSelectionne) {
            $query->mois($moisSelectionne);
        }

        if ($search) {
            $query->whereHas('personnel', function ($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                    ->orWhere('prenoms', 'like', "%{$search}%")
                    ->orWhere('matricule', 'like', "%{$search}%");
            });
        }

        $bulletins = $query->paginate(20)->withQueryString();

        // Statistiques
        $stats = BulletinPaie::getStatistiques(null, $anneeSelectionnee);

        // Personnel pour le modal d'upload
        $personnels = Personnel::actif()
            ->orderBy('nom')
            ->orderBy('prenoms')
            ->get();

        return view('admin.bulletins-paie.index', compact(
            'bulletins',
            'anneesDisponibles',
            'anneeSelectionnee',
            'moisSelectionne',
            'timeline',
            'stats',
            'personnels',
            'search'
        ));
    }

    /**
     * Upload d'un bulletin de paie
     * Processus optimisé avec validation et organisation automatique
     */
    public function store(Request $request)
    {
        $request->validate([
            'personnel_id' => 'required|exists:personnels,id',
            'mois' => 'required|integer|min:1|max:12',
            'annee' => 'required|integer|min:2000|max:2100',
            'fichier' => 'required|file|mimes:pdf|max:10240', // 10 Mo max
            'salaire_brut' => 'nullable|numeric|min:0',
            'salaire_net' => 'nullable|numeric|min:0',
            'visible_employe' => 'boolean',
            'notifier_employe' => 'boolean',
            'commentaire' => 'nullable|string|max:500',
        ], [
            'fichier.required' => 'Le fichier PDF du bulletin est obligatoire.',
            'fichier.mimes' => 'Le fichier doit être au format PDF.',
            'fichier.max' => 'Le fichier ne doit pas dépasser 10 Mo.',
            'personnel_id.required' => 'Veuillez sélectionner un employé.',
            'mois.required' => 'Le mois est obligatoire.',
            'annee.required' => 'L\'année est obligatoire.',
        ]);

        // Vérifier si un bulletin existe déjà pour cette période
        if (BulletinPaie::existePourPeriode($request->personnel_id, $request->annee, $request->mois)) {
            return back()->withErrors([
                'periode' => 'Un bulletin existe déjà pour cet employé pour la période ' .
                    BulletinPaie::MOIS_NOMS[$request->mois] . ' ' . $request->annee . '.'
            ])->withInput();
        }

        $personnel = Personnel::findOrFail($request->personnel_id);
        $fichier = $request->file('fichier');

        // Générer le chemin de stockage organisé
        $storagePath = BulletinPaie::getStoragePath(
            $personnel->entreprise_id,
            $request->annee,
            $request->mois
        );

        // Nom du fichier : matricule_annee_mois.pdf
        $fileName = sprintf('%s_%d_%02d.pdf',
            Str::slug($personnel->matricule),
            $request->annee,
            $request->mois
        );

        // Stocker le fichier
        $path = $fichier->storeAs($storagePath, $fileName, 'public');

        // Créer l'enregistrement
        $bulletin = BulletinPaie::create([
            'personnel_id' => $request->personnel_id,
            'entreprise_id' => $personnel->entreprise_id,
            'uploaded_by' => Auth::id(),
            'mois' => $request->mois,
            'annee' => $request->annee,
            'fichier_path' => $path,
            'fichier_nom_original' => $fichier->getClientOriginalName(),
            'fichier_type' => $fichier->getMimeType(),
            'fichier_taille' => $fichier->getSize(),
            'salaire_brut' => $request->salaire_brut,
            'salaire_net' => $request->salaire_net,
            'reference' => BulletinPaie::genererReference(
                $personnel->entreprise_id,
                $request->personnel_id,
                $request->annee,
                $request->mois
            ),
            'statut' => 'publie',
            'visible_employe' => $request->boolean('visible_employe', true),
            'notifier_employe' => $request->boolean('notifier_employe', false),
            'commentaire' => $request->commentaire,
        ]);

        // Envoyer notification WhatsApp si demandé
        if ($bulletin->notifier_employe && $personnel->user) {
            $personnel->user->notify(new BulletinPaieNotification($bulletin));
            $bulletin->update(['notifie_at' => now()]);
        }

        return redirect()->route('admin.bulletins-paie.index', [
            'annee' => $request->annee,
            'mois' => $request->mois
        ])->with('success', 'Bulletin de paie uploadé avec succès pour ' . $personnel->nom_complet);
    }

    /**
     * Upload en masse pour un mois donné
     * Permet d'uploader plusieurs bulletins d'un coup
     */
    public function storeBulk(Request $request)
    {
        $request->validate([
            'mois' => 'required|integer|min:1|max:12',
            'annee' => 'required|integer|min:2000|max:2100',
            'bulletins' => 'required|array|min:1',
            'bulletins.*.personnel_id' => 'required|exists:personnels,id',
            'bulletins.*.fichier' => 'required|file|mimes:pdf|max:10240',
            'bulletins.*.salaire_net' => 'nullable|numeric|min:0',
        ]);

        $mois = $request->mois;
        $annee = $request->annee;
        $resultats = ['success' => 0, 'errors' => []];

        DB::beginTransaction();
        try {
            foreach ($request->bulletins as $index => $data) {
                $personnel = Personnel::find($data['personnel_id']);

                // Vérifier si bulletin existe déjà
                if (BulletinPaie::existePourPeriode($data['personnel_id'], $annee, $mois)) {
                    $resultats['errors'][] = "{$personnel->nom_complet} : Bulletin déjà existant";
                    continue;
                }

                $fichier = $data['fichier'];
                $storagePath = BulletinPaie::getStoragePath($personnel->entreprise_id, $annee, $mois);
                $fileName = sprintf('%s_%d_%02d.pdf', Str::slug($personnel->matricule), $annee, $mois);
                $path = $fichier->storeAs($storagePath, $fileName, 'public');

                $bulletin = BulletinPaie::create([
                    'personnel_id' => $data['personnel_id'],
                    'entreprise_id' => $personnel->entreprise_id,
                    'uploaded_by' => Auth::id(),
                    'mois' => $mois,
                    'annee' => $annee,
                    'fichier_path' => $path,
                    'fichier_nom_original' => $fichier->getClientOriginalName(),
                    'fichier_type' => $fichier->getMimeType(),
                    'fichier_taille' => $fichier->getSize(),
                    'salaire_net' => $data['salaire_net'] ?? null,
                    'reference' => BulletinPaie::genererReference($personnel->entreprise_id, $data['personnel_id'], $annee, $mois),
                    'statut' => 'publie',
                    'visible_employe' => true,
                    'notifier_employe' => true,
                ]);

                // Notification WhatsApp
                if ($personnel->user) {
                    $personnel->user->notify(new BulletinPaieNotification($bulletin));
                    $bulletin->update(['notifie_at' => now()]);
                }

                $resultats['success']++;
            }

            DB::commit();

            $message = "{$resultats['success']} bulletin(s) uploadé(s) avec succès.";
            if (!empty($resultats['errors'])) {
                $message .= ' ' . count($resultats['errors']) . ' erreur(s).';
            }

            return redirect()->route('admin.bulletins-paie.index', [
                'annee' => $annee,
                'mois' => $mois
            ])->with('success', $message);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Erreur lors de l\'upload : ' . $e->getMessage()]);
        }
    }

    /**
     * Afficher un bulletin
     */
    public function show(BulletinPaie $bulletin)
    {
        $bulletin->load(['personnel', 'uploadedBy']);
        return view('admin.bulletins-paie.show', compact('bulletin'));
    }

    /**
     * Mettre à jour un bulletin
     */
    public function update(Request $request, BulletinPaie $bulletin)
    {
        $request->validate([
            'salaire_brut' => 'nullable|numeric|min:0',
            'salaire_net' => 'nullable|numeric|min:0',
            'visible_employe' => 'boolean',
            'statut' => 'in:brouillon,publie,archive',
            'commentaire' => 'nullable|string|max:500',
        ]);

        $bulletin->update($request->only([
            'salaire_brut',
            'salaire_net',
            'visible_employe',
            'statut',
            'commentaire',
        ]));

        return back()->with('success', 'Bulletin mis à jour avec succès.');
    }

    /**
     * Remplacer le fichier d'un bulletin
     */
    public function replaceFichier(Request $request, BulletinPaie $bulletin)
    {
        $request->validate([
            'fichier' => 'required|file|mimes:pdf|max:10240',
        ]);

        // Supprimer l'ancien fichier
        if ($bulletin->fichier_path && Storage::disk('public')->exists($bulletin->fichier_path)) {
            Storage::disk('public')->delete($bulletin->fichier_path);
        }

        $fichier = $request->file('fichier');
        $storagePath = BulletinPaie::getStoragePath(
            $bulletin->entreprise_id,
            $bulletin->annee,
            $bulletin->mois
        );

        $fileName = sprintf('%s_%d_%02d.pdf',
            Str::slug($bulletin->personnel->matricule),
            $bulletin->annee,
            $bulletin->mois
        );

        $path = $fichier->storeAs($storagePath, $fileName, 'public');

        $bulletin->update([
            'fichier_path' => $path,
            'fichier_nom_original' => $fichier->getClientOriginalName(),
            'fichier_type' => $fichier->getMimeType(),
            'fichier_taille' => $fichier->getSize(),
        ]);

        return back()->with('success', 'Fichier remplacé avec succès.');
    }

    /**
     * Supprimer un bulletin
     */
    public function destroy(BulletinPaie $bulletin)
    {
        // Supprimer le fichier
        if ($bulletin->fichier_path && Storage::disk('public')->exists($bulletin->fichier_path)) {
            Storage::disk('public')->delete($bulletin->fichier_path);
        }

        $bulletin->delete();

        return back()->with('success', 'Bulletin supprimé avec succès.');
    }

    /**
     * Télécharger un bulletin
     */
    public function download(BulletinPaie $bulletin)
    {
        if (!Storage::disk('public')->exists($bulletin->fichier_path)) {
            abort(404, 'Fichier non trouvé');
        }

        $nomTelecharge = sprintf('Bulletin_%s_%s_%d.pdf',
            Str::slug($bulletin->personnel->nom_complet),
            BulletinPaie::MOIS_COURTS[$bulletin->mois],
            $bulletin->annee
        );

        return Storage::disk('public')->download($bulletin->fichier_path, $nomTelecharge);
    }

    /**
     * Prévisualiser un bulletin (PDF inline)
     */
    public function preview(BulletinPaie $bulletin)
    {
        if (!Storage::disk('public')->exists($bulletin->fichier_path)) {
            abort(404, 'Fichier non trouvé');
        }

        return response()->file(
            Storage::disk('public')->path($bulletin->fichier_path),
            ['Content-Type' => 'application/pdf']
        );
    }

    /**
     * Exporter la liste des bulletins
     */
    public function export(Request $request)
    {
        $annee = $request->get('annee', now()->year);
        $mois = $request->get('mois');

        $query = BulletinPaie::with('personnel')
            ->annee($annee)
            ->orderBy('mois')
            ->orderBy('personnel_id');

        if ($mois) {
            $query->mois($mois);
        }

        $bulletins = $query->get();

        // Export CSV
        $filename = "bulletins_paie_{$annee}" . ($mois ? "_" . str_pad($mois, 2, '0', STR_PAD_LEFT) : '') . ".csv";

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($bulletins) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF)); // BOM UTF-8

            // En-têtes
            fputcsv($file, [
                'Référence',
                'Matricule',
                'Nom',
                'Prénoms',
                'Mois',
                'Année',
                'Salaire Brut',
                'Salaire Net',
                'Date Upload',
            ], ';');

            foreach ($bulletins as $bulletin) {
                fputcsv($file, [
                    $bulletin->reference,
                    $bulletin->personnel->matricule,
                    $bulletin->personnel->nom,
                    $bulletin->personnel->prenoms,
                    $bulletin->mois_nom,
                    $bulletin->annee,
                    $bulletin->salaire_brut,
                    $bulletin->salaire_net,
                    $bulletin->created_at->format('d/m/Y H:i'),
                ], ';');
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
