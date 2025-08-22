<?php

namespace App\Console;

use App\Console\Commands\SyncProductImages;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Jobs\SyncImagesJob;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        $schedule->job(new SyncProductImages)->everyMinute();
    }

    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');
    }
}
