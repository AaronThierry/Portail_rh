<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiService
{
    private string $apiKey;
    private string $model;
    private string $apiBase  = 'https://generativelanguage.googleapis.com/v1beta';
    private string $uploadBase = 'https://generativelanguage.googleapis.com/upload/v1beta';

    public function __construct()
    {
        $this->apiKey = config('services.gemini.api_key');
        $this->model  = config('services.gemini.model', 'gemini-2.0-flash');
    }

    /**
     * Upload a PDF to Gemini Files API.
     * Returns uri, gemini file name, and expiry time (48h).
     */
    public function uploadFile(string $filePath, string $displayName): array
    {
        $fileContent = file_get_contents($filePath);
        $fileSize    = strlen($fileContent);

        // Step 1 — initiate resumable upload
        $init = Http::withHeaders([
            'X-Goog-Upload-Protocol'             => 'resumable',
            'X-Goog-Upload-Command'              => 'start',
            'X-Goog-Upload-Header-Content-Length'=> $fileSize,
            'X-Goog-Upload-Header-Content-Type'  => 'application/pdf',
            'Content-Type'                       => 'application/json',
        ])->post("{$this->uploadBase}/files?key={$this->apiKey}", [
            'file' => ['display_name' => $displayName],
        ]);

        $uploadUrl = $init->header('X-Goog-Upload-URL');

        if (!$uploadUrl) {
            throw new \RuntimeException('Gemini Files API : URL upload introuvable. ' . $init->body());
        }

        // Step 2 — upload bytes
        $upload = Http::withHeaders([
            'Content-Length'        => $fileSize,
            'X-Goog-Upload-Offset'  => '0',
            'X-Goog-Upload-Command' => 'upload, finalize',
        ])->withBody($fileContent, 'application/pdf')->post($uploadUrl);

        if (!$upload->ok()) {
            throw new \RuntimeException('Gemini upload échoué : ' . $upload->status() . ' ' . $upload->body());
        }

        $file = $upload->json('file');

        return [
            'uri'        => $file['uri'],
            'name'       => $file['name'],
            'expires_at' => now()->addHours(47),
        ];
    }

    /**
     * Ask a question using the given Gemini file URIs as context.
     * $history = [['role'=>'user','content'=>'...'],['role'=>'model','content'=>'...']]
     */
    public function ask(string $question, array $fileUris, array $history = []): string
    {
        if (empty($fileUris)) {
            return 'Aucun document disponible. Veuillez contacter votre administrateur pour ajouter des documents à l\'assistant.';
        }

        $systemPrompt = "Tu es un assistant RH professionnel pour le Portail RH+. "
            . "Tu réponds exclusivement en français, de façon claire, concise et professionnelle. "
            . "Tu bases tes réponses uniquement sur les documents fournis. "
            . "Si une information n'est pas dans les documents, dis-le clairement sans inventer. "
            . "Utilise des listes à puces ou de la mise en forme quand c'est utile pour la lisibilité.";

        $contents = [];

        // Conversation history (sans les PDFs pour ne pas répéter)
        foreach ($history as $msg) {
            $contents[] = [
                'role'  => $msg['role'],
                'parts' => [['text' => $msg['content']]],
            ];
        }

        // Current user message: PDFs + question
        $userParts = [];
        foreach ($fileUris as $uri) {
            $userParts[] = ['file_data' => ['mime_type' => 'application/pdf', 'file_uri' => $uri]];
        }
        $userParts[] = ['text' => $question];

        $contents[] = ['role' => 'user', 'parts' => $userParts];

        $response = Http::timeout(45)->post(
            "{$this->apiBase}/models/{$this->model}:generateContent?key={$this->apiKey}",
            [
                'system_instruction' => ['parts' => [['text' => $systemPrompt]]],
                'contents'           => $contents,
                'generationConfig'   => [
                    'temperature'     => 0.2,
                    'maxOutputTokens' => 1500,
                ],
            ]
        );

        if (!$response->ok()) {
            Log::error('Gemini generateContent error', [
                'status' => $response->status(),
                'body'   => $response->body(),
            ]);
            throw new \RuntimeException('Erreur Gemini : ' . $response->status());
        }

        return $response->json('candidates.0.content.parts.0.text')
            ?? 'Je n\'ai pas pu générer une réponse. Veuillez réessayer.';
    }
}
