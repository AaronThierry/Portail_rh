<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiService
{
    private string $apiKey;
    private string $model;
    private string $apiBase = 'https://generativelanguage.googleapis.com/v1beta';

    public function __construct()
    {
        $this->apiKey = config('services.gemini.api_key');
        $this->model  = config('services.gemini.model', 'gemini-2.0-flash');
    }

    /**
     * Ask a question using pre-extracted document texts as context.
     * $docTexts = [['nom' => '...', 'texte' => '...']]
     * $history  = [['role'=>'user','content'=>'...'],['role'=>'model','content'=>'...']]
     */
    public function ask(string $question, array $docTexts, array $history = []): string
    {
        if (empty($docTexts)) {
            return 'Aucun document disponible. Veuillez contacter votre administrateur pour ajouter des documents à l\'assistant.';
        }

        $systemPrompt = "Tu es un assistant RH professionnel pour le Portail RH+. "
            . "Tu réponds exclusivement en français, de façon claire, concise et professionnelle. "
            . "Tu bases tes réponses uniquement sur les documents fournis ci-dessous. "
            . "Si une information n'est pas dans les documents, dis-le clairement sans inventer. "
            . "Utilise des listes à puces ou de la mise en forme quand c'est utile pour la lisibilité.";

        // Build context block from all documents
        $contextBlock = '';
        foreach ($docTexts as $doc) {
            $contextBlock .= "\n\n=== Document : {$doc['nom']} ===\n{$doc['texte']}";
        }

        $contents = [];

        // Conversation history
        foreach ($history as $msg) {
            $contents[] = [
                'role'  => $msg['role'],
                'parts' => [['text' => $msg['content']]],
            ];
        }

        // Current question with document context injected
        $contents[] = [
            'role'  => 'user',
            'parts' => [['text' => "Voici les documents de référence :{$contextBlock}\n\nQuestion : {$question}"]],
        ];

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
