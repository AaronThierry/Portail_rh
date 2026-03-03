<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Import automatique des bulletins de paie : le 1er du mois à 01h00
        // Place les PDFs dans storage/app/imports/bulletins/{entreprise_id}/ avant l'exécution
        // $schedule->command('bulletins:import --notify')->monthlyOn(1, '01:00');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
