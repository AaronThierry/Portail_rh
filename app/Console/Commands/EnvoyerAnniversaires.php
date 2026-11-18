<?php

namespace App\Console\Commands;

use App\Models\Personnel;
use App\Notifications\AnniversaireNotification;
use Illuminate\Console\Command;

class EnvoyerAnniversaires extends Command
{
    protected $signature = 'anniversaires:envoyer';
    protected $description = "Envoie un message de joyeux anniversaire aux employés dont c'est le jour, aujourd'hui";

    public function handle(): int
    {
        $aujourdHui = now();

        $personnels = Personnel::query()
            ->where('is_active', true)
            ->whereNotNull('date_naissance')
            ->whereNotNull('user_id')
            ->whereHas('entreprise', fn ($q) => $q->where('is_active', true))
            ->whereMonth('date_naissance', $aujourdHui->month)
            ->whereDay('date_naissance', $aujourdHui->day)
            ->with('user')
            ->get();

        $envoyes = 0;

        foreach ($personnels as $personnel) {
            if (!$personnel->user) {
                continue;
            }

            $personnel->user->notify(new AnniversaireNotification($personnel));
            $envoyes++;
        }

        $this->info("{$envoyes} message(s) d'anniversaire envoyé(s).");

        return self::SUCCESS;
    }
}
