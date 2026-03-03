<?php

namespace App\Http\Controllers;

use App\Models\BulletinImport;
use App\Models\Entreprise;
use App\Services\BulletinImportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BulletinImportController extends Controller
{
    public function __construct(private BulletinImportService $importService) {}

    /**
     * Page d'import automatique
     */
    public function index()
    {
        $entreprises = Entreprise::orderBy('nom')->get();
        $historique  = BulletinImport::with(['entreprise', 'uploadedBy'])
            ->orderBy('created_at', 'desc')
            ->take(20)
            ->get();

        return view('admin.bulletins-paie.import', compact('entreprises', 'historique'));
    }

    /**
     * Traiter l'upload du ZIP
     */
    public function store(Request $request)
    {
        $request->validate([
            'fichier_zip'    => ['required', 'file', 'mimes:zip', 'max:102400'], // 100 Mo max
            'entreprise_id'  => ['required', 'exists:entreprises,id'],
            'notifier'       => ['nullable', 'boolean'],
        ]);

        $entrepriseId = (int) $request->entreprise_id;
        $notifier     = (bool) $request->input('notifier', false);
        $zip          = $request->file('fichier_zip');

        // Sauvegarder le ZIP pour la traçabilité
        $zipPath = $zip->store('imports/bulletins/zips', 'local');

        // Créer le log d'import
        $import = BulletinImport::create([
            'entreprise_id' => $entrepriseId,
            'uploaded_by'   => Auth::id(),
            'fichier_zip'   => $zipPath,
            'statut'        => 'en_cours',
        ]);

        try {
            $result = $this->importService->processZip($zip, $entrepriseId, Auth::id(), $notifier);

            // Déterminer le statut final
            $statut = 'termine';
            if ($result['succes'] === 0 && $result['total'] > 0) {
                $statut = 'echec';
            } elseif (!empty($result['erreurs'])) {
                $statut = 'partiel';
            }

            // Mettre à jour le log
            $import->update([
                'total'          => $result['total'],
                'succes'         => $result['succes'],
                'doublons'       => $result['doublons'],
                'erreurs_count'  => count($result['erreurs']),
                'erreurs'        => $result['erreurs'],
                'bulletins_crees' => $result['bulletins_ids'],
                'statut'         => $statut,
            ]);

            return redirect()
                ->route('admin.bulletins-paie.import.index')
                ->with('import_result', $result)
                ->with('import_statut', $statut);

        } catch (\Exception $e) {
            $import->update(['statut' => 'echec', 'erreurs' => [['fichier' => 'ZIP', 'raison' => $e->getMessage()]]]);

            return redirect()
                ->route('admin.bulletins-paie.import.index')
                ->with('error', 'Erreur lors du traitement : ' . $e->getMessage());
        }
    }
}
