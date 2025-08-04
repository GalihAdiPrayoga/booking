<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        /**
         * Mendaftarkan schedule untuk dijalankan
         */
        $schedule->command('app:active-users-schedule')->monthly();
    }

    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');
    }
}
