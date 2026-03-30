<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * OllamaService — propulsé par Groq (modèles open-source Llama 3, gratuit)
 *
 * Groq sert les mêmes modèles open-source qu'Ollama (Llama 3.x, Mixtral…)
 * sans nécessiter d'installation serveur. API gratuite, ultra-rapide.
 *
 * Configuration requise dans .env :
 *   GROQ_API_KEY=gsk_...     (compte gratuit sur console.groq.com)
 *   GROQ_MODEL=llama-3.3-70b-versatile   (optionnel)
 *
 * Fallback : si Groq échoue, essaie Ollama local (OLLAMA_URL)
 */
class OllamaService
{
    protected string $groqKey;
    protected string $groqModel;
    protected string $ollamaUrl;
    protected string $ollamaModel;

    protected const SYSTEM_PROMPT = <<<'PROMPT'
Tu es un assistant RH virtuel intégré au Portail RH+.
Tu aides les employés, responsables et chefs d'entreprise à trouver des réponses à leurs questions avant de contacter le support humain.

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
        $this->groqKey     = config('services.groq.api_key', '');
        $this->groqModel   = config('services.groq.model', 'llama-3.3-70b-versatile');
        $this->ollamaUrl   = rtrim(config('services.ollama.url', 'http://localhost:11434'), '/');
        $this->ollamaModel = config('services.ollama.model', 'llama3.2');
    }

    /**
     * Envoyer un message et obtenir la réponse du bot.
     *
     * @param array $history Historique [{role, content}, ...] (sans message système)
     * @return string Réponse générée
     */
    public function chat(array $history): string
    {
        // Filtrer les doublons de messages système
        $messages = array_values(array_filter($history, fn($m) => $m['role'] !== 'system'));

        // ── 1. Essai Groq (open-source Llama 3, gratuit) ──
        if (!empty($this->groqKey)) {
            $result = $this->groqChat($messages, self::SYSTEM_PROMPT, 512);
            if ($result !== null) {
                return $result;
            }
        }

        // ── 2. Fallback Ollama local ──
        $result = $this->ollamaChat($messages);
        if ($result !== null) {
            return $result;
        }

        return "Je rencontre des difficultés techniques. Vous pouvez soumettre votre requête directement à un agent.";
    }

    /**
     * Générer un résumé court de la conversation.
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

        $messages = [[
            'role'    => 'user',
            'content' => "Résume cette conversation en 2-3 phrases pour décrire le problème à un agent de support :\n\n{$conversation}",
        ]];
        $system = 'Tu es un assistant qui résume des conversations de support. Sois très concis.';

        if (!empty($this->groqKey)) {
            $result = $this->groqChat($messages, $system, 200);
            if ($result !== null) {
                return $result;
            }
        }

        return collect($history)
            ->where('role', 'user')
            ->take(2)
            ->pluck('content')
            ->implode(' — ');
    }

    /**
     * Analyse l'historique et détecte si une escalade est nécessaire.
     */
    public function detectEscalation(array $history): array
    {
        $userText = strtolower(collect($history)
            ->where('role', 'user')
            ->pluck('content')
            ->implode(' '));

        $botText = strtolower(collect($history)
            ->where('role', 'assistant')
            ->pluck('content')
            ->implode(' '));

        $urgentKeywords = [
            'urgent', 'critique', 'bloquant', 'bloqué', 'panne', 'impossible',
            'immédiatement', 'maintenant', 'aujourd\'hui', 'grave', 'sérieux',
            'perdu', 'disparu', 'corrompu', 'inaccessible', 'ne peut plus',
        ];
        $isUrgent = collect($urgentKeywords)->contains(fn($k) => str_contains($userText, $k));

        $facturationKeywords = [
            'facture', 'paiement', 'abonnement', 'prix', 'tarif', 'remboursement',
            'facturation', 'double débit', 'prélevé', 'erreur de paiement', 'billing',
        ];
        $supportKeywords = [
            'bug', 'erreur', 'problème technique', 'ne fonctionne pas', 'ne s\'affiche pas',
            'connexion', 'login', 'mot de passe', 'accès refusé', 'crash', '500', '404',
            'lent', 'bloqué', 'page blanche',
        ];

        $categorie = 'question';
        if (collect($facturationKeywords)->contains(fn($k) => str_contains($userText, $k))) {
            $categorie = 'facturation';
        } elseif (collect($supportKeywords)->contains(fn($k) => str_contains($userText, $k))) {
            $categorie = 'support';
        }

        $lastUserMsg = strtolower(collect($history)->where('role', 'user')->last()['content'] ?? '');
        $explicitTicketKeywords = [
            'créer un ticket', 'creer un ticket', 'ouvrir un ticket', 'ouvre un ticket',
            'soumettre un ticket', 'faire un ticket', 'je veux un ticket',
            'je voudrais un ticket', 'un ticket stp', 'un ticket svp',
            'envoyer une demande', 'envoyer au support', 'contacter le support',
            'parler à un humain', 'parler a un humain', 'agent humain', 'agent rh',
            'prendre en charge', 'ticket de support',
        ];
        $userWantsTicket = collect($explicitTicketKeywords)->contains(
            fn($k) => str_contains($lastUserMsg, $k)
        );

        $escaladeKeywords = [
            'supprimer', 'modifier mes données', 'rembourse', 'annuler mon abonnement',
            'données perdues', 'bug bloquant', 'ne fonctionne pas du tout', 'panne totale',
            'depuis plusieurs jours', 'toujours pas résolu', 'plusieurs fois',
            'très en colère', 'insatisfait', 'inacceptable', 'honteux',
            'je vous recommande de', 'je vous suggère de contacter',
        ];

        $requiresTicket = $userWantsTicket || collect($escaladeKeywords)->contains(
            fn($k) => str_contains($userText, $k) || str_contains($botText, $k)
        );

        if (collect($history)->where('role', 'user')->count() >= 5) {
            $requiresTicket = true;
        }

        $firstUserMsg = collect($history)->where('role', 'user')->first()['content'] ?? '';
        $sujet = mb_strlen($firstUserMsg) > 100
            ? mb_substr($firstUserMsg, 0, 97) . '…'
            : $firstUserMsg;

        return [
            'requires_ticket'     => $requiresTicket,
            'suggested_sujet'     => $sujet,
            'suggested_categorie' => $categorie,
            'suggested_priorite'  => $isUrgent ? 'urgente' : 'normale',
        ];
    }

    public function isEnabled(): bool
    {
        return !empty($this->groqKey) || !empty($this->ollamaUrl);
    }

    // ──────────────────────────────────────────────────────────────────────────
    // Méthodes privées
    // ──────────────────────────────────────────────────────────────────────────

    private function groqChat(array $messages, string $system, int $maxTokens): ?string
    {
        try {
            $payload = [
                'model'       => $this->groqModel,
                'max_tokens'  => $maxTokens,
                'messages'    => array_merge(
                    [['role' => 'system', 'content' => $system]],
                    $messages
                ),
            ];

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->groqKey,
                'Content-Type'  => 'application/json',
            ])
            ->connectTimeout(5)
            ->timeout(30)
            ->post('https://api.groq.com/openai/v1/chat/completions', $payload);

            if ($response->successful()) {
                return $response->json('choices.0.message.content') ?? null;
            }

            Log::error('Groq API: erreur', [
                'status' => $response->status(),
                'body'   => $response->body(),
            ]);
        } catch (\Exception $e) {
            Log::error('Groq API: exception', ['error' => $e->getMessage()]);
        }

        return null;
    }

    private function ollamaChat(array $messages): ?string
    {
        try {
            $response = Http::connectTimeout(3)->timeout(20)->post("{$this->ollamaUrl}/api/chat", [
                'model'    => $this->ollamaModel,
                'messages' => array_merge(
                    [['role' => 'system', 'content' => self::SYSTEM_PROMPT]],
                    $messages
                ),
                'stream'   => false,
            ]);

            if ($response->successful()) {
                return $response->json('message.content') ?? null;
            }
        } catch (\Exception $e) {
            Log::error('Ollama: exception', ['error' => $e->getMessage()]);
        }

        return null;
    }
}
