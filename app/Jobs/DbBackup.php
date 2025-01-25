<?php

namespace App\Jobs;

use App\Models\BackupRecord;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class DbBackup implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Artisan::call('backup:run --only-db');
        $dirName = env('APP_NAME');
        $backupFiles = Storage::disk('local')->files($dirName);
        for ($i = 0; $i < sizeof($backupFiles) ?? 1; $i++) {
            $file = explode('/', $backupFiles[$i]);
            BackupRecord::firstOrCreate([
                'name' => end($file),
                'path' => $backupFiles[$i],
                'size' => Storage::size($backupFiles[$i]),
                'is_file' => 0
            ]);
        }


    }
}
