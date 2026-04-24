<?php

namespace App\Http\Controllers;

use App\Models\AssistantDocument;
use App\Services\GeminiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Smalot\PdfParser\Parser as PdfParser;

class AssistantController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $docs = AssistantDocument::where('actif', true)
            ->when(!$user->hasRole('Super Admin') && $user->entreprise_id, fn($q) =>
                $q->where('entreprise_id', $user->entreprise_id)
            )
            ->orderByDesc('created_at')
            ->get();

        $canManage = $user->hasAnyRole(['Super Admin', 'Admin', 'RH', 'Agent administratif']);

        return view('assistant.index', compact('docs', 'canManage'));
    }

    public function chat(Request $request, GeminiService $gemini)
    {
        $request->validate([
            'question' => 'required|string|max:1000',
            'history'  => 'nullable|array|max:20',
        ]);

        $user = auth()->user();

        $docs = AssistantDocument::where('actif', true)
            ->whereNotNull('contenu_texte')
            ->when(!$user->hasRole('Super Admin') && $user->entreprise_id, fn($q) =>
                $q->where('entreprise_id', $user->entreprise_id)
            )
            ->get();

        $docTexts = $docs->map(fn($d) => [
            'nom'   => $d->nom,
            'texte' => $d->contenu_texte,
        ])->toArray();

        try {
            $answer = $gemini->ask($request->question, $docTexts, $request->history ?? []);
            return response()->json(['answer' => $answer]);
        } catch (\Exception $e) {
            Log::error('Gemini chat error', ['error' => $e->getMessage()]);
            return response()->json(['answer' => 'Une erreur s\'est produite. Vérifiez la clé API Gemini ou réessayez.'], 500);
        }
    }

    public function uploadDocument(Request $request)
    {
        $request->validate([
            'pdf' => 'required|file|mimes:pdf|max:20480',
            'nom' => 'required|string|max:255',
        ]);

        $user = auth()->user();
        $file = $request->file('pdf');
        $path = $file->store('assistant-docs', 'public');

        $contenuTexte = null;
        try {
            $parser       = new PdfParser();
            $pdf          = $parser->parseFile(Storage::disk('public')->path($path));
            $contenuTexte = $pdf->getText();
        } catch (\Exception $e) {
            Log::warning('PDF text extraction failed', ['nom' => $request->nom, 'error' => $e->getMessage()]);
        }

        AssistantDocument::create([
            'nom'           => $request->nom,
            'fichier_path'  => $path,
            'contenu_texte' => $contenuTexte,
            'actif'         => true,
            'entreprise_id' => $user->hasRole('Super Admin') ? null : $user->entreprise_id,
            'taille'        => $file->getSize(),
            'uploaded_by'   => $user->id,
        ]);

        return back()->with('success', "Document «{$request->nom}» ajouté à l'assistant.");
    }

    public function deleteDocument(AssistantDocument $document)
    {
        Storage::disk('public')->delete($document->fichier_path);
        $document->delete();
        return back()->with('success', 'Document supprimé.');
    }
}
