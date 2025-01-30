<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schedule;

$taskSchedules = \App\Models\Schedule::all();
foreach ($taskSchedules as $key => $taskSchedule) {
    $params = explode(",", $taskSchedule->params);
    Schedule::call(function () use ($taskSchedule) {
        \App\Jobs\FileBackup::dispatch();
        Log::info("{$taskSchedule->name} run at " . now());
    })->{$taskSchedule->frequency}(...$params)->name($taskSchedule->name);
    Schedule::call(function () use ($taskSchedule) {})->everyMinute();
    Schedule::call(function () use ($taskSchedule) {})->cron("* * * * *");
}
//Schedule::command('backup:run --only-db')->everyMinute();
Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();
