<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Ollama Service — chatbot IA local (gratuit, zéro config cloud)
 *
 * Utilise Ollama pour alimenter l'assistant RH dans la section requêtes.
 * Ollama doit être installé et actif sur le serveur :
 *   curl -fsSL https://ollama.com/install.sh | sh
 *   ollama pull llama3.2
 *
 * Configuration requise dans .env :
 *   OLLAMA_URL=http://localhost:11434
 *   OLLAMA_MODEL=llama3.2
 */
class OllamaService
{
    protected string $url;
    protected string $model;

    protected const SYSTEM_PROMPT = <<<'PROMPT'
Tu es un assistant RH virtuel intégré au Portail RH+.
Tu aides les responsables et chefs d'entreprise à trouver des réponses à leurs questions avant de contacter le support humain.

Tes domaines de compétence :
- Gestion des congés et absences (demandes, soldes, procédures)
- Bulletins de paie (disponibilité, téléchargement, contenu)
- Support technique du portail (connexion, navigation, fonctionnalités)
- Facturation et abonnements Portail RH+
- Questions générales sur la gestion RH

Règles :
- Réponds TOUJOURS en français
- Sois professionnel, clair et concis (3-5 phrases maximum)
- Si tu ne sais pas ou si la question nécessite une action manuelle d'un agent, dis-le honnêtement et suggère de contacter le support
- Ne fais jamais semblant de pouvoir effectuer des actions (modifier des données, envoyer des emails, etc.)
- Ne demande jamais d'informations personnelles sensibles
PROMPT;

    public function __construct()
    {
        $this->url   = rtrim(config('services.ollama.url', 'http://localhost:11434'), '/');
        $this->model = config('services.ollama.model', 'llama3.2');
    }

    /**
     * Envoyer un message et obtenir la réponse du bot.
     *
     * @param array $history Historique de la conversation [{role, content}, ...]
     *                       Sans le message système (ajouté automatiquement)
     * @return string Réponse générée par le modèle
     */
    public function chat(array $history): string
    {
        $messages = array_merge(
            [['role' => 'system', 'content' => self::SYSTEM_PROMPT]],
            $history
        );

        try {
            $response = Http::timeout(60)->post("{$this->url}/api/chat", [
                'model'    => $this->model,
                'messages' => $messages,
                'stream'   => false,
            ]);

            if ($response->successful()) {
                return $response->json('message.content')
                    ?? "Je n'ai pas pu générer une réponse. Veuillez réessayer.";
            }

            Log::error('Ollama: erreur API', [
                'status' => $response->status(),
                'body'   => $response->body(),
            ]);

        } catch (\Exception $e) {
            Log::error('Ollama: exception', ['error' => $e->getMessage()]);
        }

        return "Je rencontre des difficultés techniques. Vous pouvez soumettre votre requête directement à un agent.";
    }

    /**
     * Générer un résumé court de la conversation pour pré-remplir le formulaire
     */
    public function summarize(array $history): string
    {
        if (empty($history)) {
            return '';
        }

        $conversation = collect($history)
            ->where('role', '!=', 'system')
            ->map(fn($m) => ($m['role'] === 'user' ? 'Moi' : 'Assistant') . ' : ' . $m['content'])
            ->implode("\n\n");

        $summaryMessages = [
            [
                'role'    => 'system',
                'content' => 'Tu es un assistant qui résume des conversations de support. Sois très concis.',
            ],
            [
                'role'    => 'user',
                'content' => "Résume cette conversation en 2-3 phrases pour décrire le problème à un agent de support :\n\n{$conversation}",
            ],
        ];

        try {
            $response = Http::timeout(30)->post("{$this->url}/api/chat", [
                'model'    => $this->model,
                'messages' => $summaryMessages,
                'stream'   => false,
            ]);

            if ($response->successful()) {
                return $response->json('message.content', $conversation);
            }
        } catch (\Exception $e) {
            Log::error('Ollama: erreur summarize', ['error' => $e->getMessage()]);
        }

        // Fallback : retourner les 2 premiers messages utilisateur bruts
        return collect($history)
            ->where('role', 'user')
            ->take(2)
            ->pluck('content')
            ->implode(' — ');
    }

    public function isEnabled(): bool
    {
        return !empty($this->url) && !empty($this->model);
    }
}
