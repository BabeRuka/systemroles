<?php

namespace BabeRuka\SystemRoles\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Spatie\ShortSchedule\ShortSchedule;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */

    protected $commands = [ 
        \BabeRuka\SystemRoles\Console\Commands\CreateRoutePermissionsCommand::class,
        \BabeRuka\SystemRoles\Console\Commands\RepositoryMakeCommand::class,
        \BabeRuka\SystemRoles\Console\Commands\MigrateSystemRolesCommand::class,
    ];

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
