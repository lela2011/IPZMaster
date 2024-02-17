<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command('ldap:import users', [
            '--no-interaction',
            '--scopes' => 'App\Ldap\Scopes\OnlyIPZ'
        ])
        ->dailyAt('06:00')
        ->onSuccess(function () {
            Log::info('IPZ LDAP import successful');
        });

        $schedule->command('ldap:import users', [
            '--no-interaction',
            '--scopes' => 'App\Ldap\Scopes\OnlyPWI'
        ])
        ->dailyAt('06:10')
        ->onSuccess(function () {
            Log::info('PWI LDAP import successful');
        });

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
