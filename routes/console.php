<?php

use App\Jobs\FileBackup;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schedule;

$taskSchedules = \App\Models\Schedule::all();
foreach ($taskSchedules as $key => $taskSchedule) {
    Schedule::call(function () use ($taskSchedule) {
        FileBackup::dispatch();
        Log::info("{$taskSchedule->name} run at " . now());
    })->cron($taskSchedule->cron);
}
//Schedule::command('backup:run --only-db')->everyMinute();
Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();
