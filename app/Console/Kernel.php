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
        // ทุก 30 นาทีจะแจ้งเตือน
        $schedule->command('run:systeminfo')->everyThirtyMinutes();

        // ทุก 5 นาทีจะแจ้งเตือน
        $schedule->command('run:error_pttype')->everyFiveMinutes();
    }

    /**
     * Register the commands for the application.
     */

    protected $commands = [
        // แจ้งเตือน CPU & RAM
        \App\Console\Commands\RunSystemInfoTask::class,

        // แจ้งเตือนสิทธิ์ผิด
        \App\Console\Commands\RunSendMessageErrorPttypeCommand::class,
    ];
}
