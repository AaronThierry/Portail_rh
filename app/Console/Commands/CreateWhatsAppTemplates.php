<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

/**
 * Crée et soumet à l'approbation Meta les templates WhatsApp utilisés par
 * WhatsAppService, via l'API Zavu.
 *
 * Nécessaire car WhatsApp Business refuse tout message sortant non sollicité
 * en dehors de la fenêtre de 24h suivant le dernier message du client, sauf
 * s'il utilise un template pré-approuvé par Meta.
 *
 * Usage : php artisan whatsapp:create-templates
 */
class CreateWhatsAppTemplates extends Command
{
    protected $signature = 'whatsapp:create-templates';

    protected $description = "Crée et soumet à l'approbation Meta les templates WhatsApp du Portail RH+ (via Zavu)";

    protected const API_BASE = 'https://api.zavu.dev/v1';

    protected const TEMPLATES = [
        [
            'name'     => 'conge_decision',
            'category' => 'UTILITY',
            'language' => 'fr',
            'body'     => "Bonjour {{1}},\n\nVotre demande de congé du {{2}} au {{3}} ({{4}} jour(s)) a été *{{5}}*.\n\n{{6}}\n\nCordialement, Portail RH+",
            'footer'   => 'Portail RH+',
            'variables' => ['prenom', 'date_debut', 'date_fin', 'duree', 'decision', 'details'],
        ],
        [
            'name'     => 'absence_decision',
            'category' => 'UTILITY',
            'language' => 'fr',
            'body'     => "Bonjour {{1}},\n\nVotre déclaration d'absence ({{2}}) du {{3}} a été *{{4}}*.\n\n{{5}}\n\nCordialement, Portail RH+",
            'footer'   => 'Portail RH+',
            'variables' => ['prenom', 'type', 'date', 'decision', 'details'],
        ],
        [
            'name'     => 'nouvelle_demande_conge',
            'category' => 'UTILITY',
            'language' => 'fr',
            'body'     => "Bonjour {{1}},\n\nNouvelle demande de congé à traiter.\n\nEmployé : {{2}}\nType : {{3}}\nPériode : {{4}} au {{5}}\nDurée : {{6}} jour(s)",
            'footer'   => 'Portail RH+',
            'variables' => ['prenom_admin', 'employe', 'type', 'date_debut', 'date_fin', 'duree'],
        ],
        [
            'name'     => 'nouvelle_demande_absence',
            'category' => 'UTILITY',
            'language' => 'fr',
            'body'     => "Bonjour {{1}},\n\nNouvelle absence à traiter.\n\nEmployé : {{2}}\nType : {{3}}\nDate : {{4}}.\n\nMerci de traiter cette demande sur le portail.",
            'footer'   => 'Portail RH+',
            'variables' => ['prenom_admin', 'employe', 'type', 'date'],
        ],
        [
            'name'     => 'bulletin_paie',
            'category' => 'UTILITY',
            'language' => 'fr',
            'body'     => "Bonjour {{1}},\n\nVotre bulletin de paie de {{2}} {{3}} est disponible sur le portail (Mon Espace → Bulletins de paie).",
            'footer'   => 'Portail RH+',
            'variables' => ['prenom', 'mois', 'annee'],
        ],
        [
            'name'     => 'nouveau_document',
            'category' => 'UTILITY',
            'language' => 'fr',
            'body'     => "Bonjour {{1}},\n\nUn nouveau document a été ajouté à votre dossier : {{2}} ({{3}}).",
            'footer'   => 'Portail RH+',
            'variables' => ['prenom', 'titre', 'categorie'],
        ],
        [
            'name'     => 'creation_compte',
            'category' => 'UTILITY',
            'language' => 'fr',
            'body'     => "Bonjour {{1}},\n\nVotre accès au Portail RH+ a été créé.\n\nEmail : {{2}}\nMot de passe temporaire : {{3}}\n\nMerci de le modifier dès votre première connexion.",
            'footer'   => 'Portail RH+',
            'variables' => ['prenom', 'email', 'mot_de_passe'],
        ],
        [
            'name'     => 'message_personnalise',
            'category' => 'MARKETING',
            'language' => 'fr',
            'body'     => "*{{1}}*\n\n{{2}}\n\n— Portail RH+",
            'footer'   => 'Portail RH+',
            'variables' => ['titre', 'contenu'],
        ],
    ];

    public function handle(): int
    {
        $apiKey = config('services.zavu.api_key');

        if (empty($apiKey)) {
            $this->error('ZAVU_API_KEY manquant dans .env');
            return 1;
        }

        // Reprend les ids déjà créés lors d'un run précédent (évite les doublons)
        $results = [];
        if (Storage::disk('local')->exists('zavu-templates.json')) {
            $results = json_decode(Storage::disk('local')->get('zavu-templates.json'), true) ?? [];
        }

        foreach (self::TEMPLATES as $template) {
            $templateId = $results[$template['name']] ?? null;

            if ($templateId) {
                $this->info("→ « {$template['name']} » déjà créé (id: {$templateId}), soumission...");
            } else {
                $this->info("→ Création du template « {$template['name']} »...");

                $response = Http::withToken($apiKey)
                    ->post(self::API_BASE . '/templates', $template);

                if (!$response->successful()) {
                    $this->error("  Échec création : {$response->status()} — {$response->body()}");
                    continue;
                }

                $templateId = $response->json('id') ?? $response->json('template.id');

                if (!$templateId) {
                    $this->error('  Réponse inattendue, pas d\'id trouvé : ' . $response->body());
                    continue;
                }

                $this->info("  Créé (id: {$templateId}), soumission à l'approbation Meta...");
                $results[$template['name']] = $templateId;
            }

            $submit = Http::withToken($apiKey)
                ->post(self::API_BASE . "/templates/{$templateId}/submit");

            if (!$submit->successful()) {
                $this->warn("  Soumission échouée : {$submit->status()} — {$submit->body()}");
            } else {
                $this->info('  Soumis à Meta pour approbation.');
            }
        }

        Storage::disk('local')->put('zavu-templates.json', json_encode($results, JSON_PRETTY_PRINT));

        $this->newLine();
        $this->info('Résumé (sauvegardé dans storage/app/zavu-templates.json) :');
        foreach ($results as $name => $id) {
            $this->line("  {$name} => {$id}");
        }

        $this->newLine();
        $this->comment("L'approbation Meta prend généralement de quelques heures à 1 jour.");
        $this->comment('Vérifiez le statut sur https://dashboard.zavu.dev (Templates) avant utilisation.');

        return 0;
    }
}
