<?php

namespace App\Http\Controllers;

use App\Models\AssistantDocument;
use App\Services\GeminiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

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
            ->when(!$user->hasRole('Super Admin') && $user->entreprise_id, fn($q) =>
                $q->where('entreprise_id', $user->entreprise_id)
            )
            ->get();

        // Refresh expired URIs
        $fileUris = [];
        foreach ($docs as $doc) {
            if ($doc->isUriExpired()) {
                try {
                    $result = $gemini->uploadFile(Storage::disk('public')->path($doc->fichier_path), $doc->nom);
                    $doc->update([
                        'gemini_file_uri'  => $result['uri'],
                        'gemini_file_name' => $result['name'],
                        'uri_expires_at'   => $result['expires_at'],
                    ]);
                    $fileUris[] = $result['uri'];
                } catch (\Exception $e) {
                    Log::error('Gemini re-upload failed', ['id' => $doc->id, 'error' => $e->getMessage()]);
                }
            } else {
                $fileUris[] = $doc->gemini_file_uri;
            }
        }

        try {
            $answer = $gemini->ask(
                $request->question,
                array_filter($fileUris),
                $request->history ?? []
            );
            return response()->json(['answer' => $answer]);
        } catch (\Exception $e) {
            Log::error('Gemini chat error', ['error' => $e->getMessage()]);
            return response()->json(['answer' => 'Une erreur s\'est produite. Vérifiez la clé API Gemini ou réessayez.'], 500);
        }
    }

    public function uploadDocument(Request $request, GeminiService $gemini)
    {
        $request->validate([
            'pdf' => 'required|file|mimes:pdf|max:20480',
            'nom' => 'required|string|max:255',
        ]);

        $user = auth()->user();
        $file = $request->file('pdf');
        $path = $file->store('assistant-docs', 'public');

        try {
            $result = $gemini->uploadFile(Storage::disk('public')->path($path), $request->nom);
        } catch (\Exception $e) {
            Storage::disk('public')->delete($path);
            return back()->withErrors(['pdf' => 'Erreur upload Gemini : ' . $e->getMessage()]);
        }

        AssistantDocument::create([
            'nom'              => $request->nom,
            'fichier_path'     => $path,
            'gemini_file_uri'  => $result['uri'],
            'gemini_file_name' => $result['name'],
            'uri_expires_at'   => $result['expires_at'],
            'actif'            => true,
            'entreprise_id'    => $user->hasRole('Super Admin') ? null : $user->entreprise_id,
            'taille'           => $file->getSize(),
            'uploaded_by'      => $user->id,
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
