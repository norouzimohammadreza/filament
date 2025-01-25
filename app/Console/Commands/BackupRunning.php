<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Contracts\Console\Isolatable;
use Spatie\Backup\Commands\BaseCommand;
use Spatie\Backup\Config\Config;
use Spatie\Backup\Events\BackupHasFailed;
use Spatie\Backup\Exceptions\BackupFailed;
use Spatie\Backup\Exceptions\InvalidCommand;
use Spatie\Backup\Traits\Retryable;

class BackupRunning extends BaseCommand implements Isolatable
{

    use Retryable;

    protected $signature = 'run:backup {--filename=} {--only-db} {--db-name=*} {--only-files} {--only-to-disk=} {--disable-notifications} {--timeout=} {--tries=}';

    protected $description = 'Run the backup.';

    public function __construct(protected Config $config)
    {
        parent::__construct();
    }

    public function handle()
    {
        consoleOutput()->comment($this->currentTry > 1 ? sprintf('Attempt n°%d...', $this->currentTry) : 'Starting backup...');

        $disableNotifications = $this->option('disable-notifications');

        if ($this->option('timeout') && is_numeric($this->option('timeout'))) {
            set_time_limit((int) $this->option('timeout'));
        }

        try {
            $this->guardAgainstInvalidOptions();

            $backupJob = BackupJobFactory::createFromConfig($this->config);

            if ($this->option('only-db')) {
                $backupJob->dontBackupFilesystem();
            }

            if ($this->option('db-name')) {
                $backupJob->onlyDbName($this->option('db-name'));
            }

            if ($this->option('only-files')) {
                $backupJob->dontBackupDatabases();
            }

            if ($this->option('only-to-disk')) {
                $backupJob->onlyBackupTo($this->option('only-to-disk'));
            }

            if ($this->option('filename')) {
                $backupJob->setFilename($this->option('filename'));
            }

            $this->setTries('backup');

            if ($disableNotifications) {
                $backupJob->disableNotifications();
            }

            if (! $this->getSubscribedSignals()) {
                $backupJob->disableSignals();
            }

            $backupJob->run();

            consoleOutput()->comment('Backup completed!');

            return static::SUCCESS;
        } catch (Exception $exception) {
            if ($this->shouldRetry()) {
                if ($this->hasRetryDelay('backup')) {
                    $this->sleepFor($this->getRetryDelay('backup'));
                }

                $this->currentTry += 1;

                return $this->handle();
            }

            consoleOutput()->error("Backup failed because: {$exception->getMessage()}.");

            report($exception);

            if (! $disableNotifications) {
                event(
                    $exception instanceof BackupFailed
                        ? new BackupHasFailed($exception->getPrevious(), $exception->backupDestination)
                        : new BackupHasFailed($exception)
                );
            }

            return static::FAILURE;
        }
    }
    protected function guardAgainstInvalidOptions(): void
    {
        if (! $this->option('only-db')) {
            return;
        }

        if (! $this->option('only-files')) {
            return;
        }

        throw InvalidCommand::create('Cannot use `only-db` and `only-files` together');
    }
}
