<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\LoadFeeds::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('feed:load DeMorgen')->everyFiveMinutes();
        $schedule->command('feed:load VRT')->everyFiveMinutes();
        $schedule->command('feed:load HLN')->everyFiveMinutes();
        $schedule->command('feed:load GVA')->everyFiveMinutes();
        $schedule->command('feed:load HBVL')->everyFiveMinutes();
        $schedule->command('feed:load HetNieuwsblad')->everyFiveMinutes();
        $schedule->command('feed:load DeStandaard')->everyFiveMinutes();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
