<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

/**
 * Affiche le statut détaillé (et la raison de rejet le cas échéant) de
 * chaque template WhatsApp créé via whatsapp:create-templates.
 *
 * Usage : php artisan whatsapp:template-status
 */
class WhatsAppTemplateStatus extends Command
{
    protected $signature = 'whatsapp:template-status';

    protected $description = 'Affiche le statut Meta (et raison de rejet) de chaque template WhatsApp';

    protected const API_BASE = 'https://api.zavu.dev/v1';

    public function handle(): int
    {
        $apiKey = config('services.zavu.api_key');

        if (empty($apiKey)) {
            $this->error('ZAVU_API_KEY manquant dans .env');
            return 1;
        }

        if (!\Storage::disk('local')->exists('zavu-templates.json')) {
            $this->error('storage/app/zavu-templates.json introuvable. Lancez d\'abord whatsapp:create-templates.');
            return 1;
        }

        $templates = json_decode(\Storage::disk('local')->get('zavu-templates.json'), true) ?? [];

        foreach ($templates as $name => $id) {
            $response = Http::withToken($apiKey)->get(self::API_BASE . "/templates/{$id}");

            $this->line("── {$name} ({$id}) " . str_repeat('─', 20));

            if (!$response->successful()) {
                $this->error("  Erreur {$response->status()} : {$response->body()}");
                continue;
            }

            $this->line(json_encode($response->json(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            $this->newLine();
        }

        return 0;
    }
}
