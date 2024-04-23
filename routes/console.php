<?php

use App\Console\Commands\CleanupOrphans;
use App\Jobs\DailyLinkReport;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

// Artisan::command('inspire', function () {
//     $this->comment(Inspiring::quote());
// })->purpose('Display an inspiring quote')->hourly();

Schedule::command(CleanupOrphans::class)->daily();
Schedule::job(new DailyLinkReport)->everyTenSeconds();
