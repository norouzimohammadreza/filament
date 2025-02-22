<?php

namespace App\Console\Commands;

use App\BackupServices\Cleanup\CleanupAsJob;
use Exception;
use Illuminate\Contracts\Console\Isolatable;
use Spatie\Backup\BackupDestination\BackupDestinationFactory;
use Spatie\Backup\Commands\BaseCommand;
use Spatie\Backup\Config\Config;
use Spatie\Backup\Events\CleanupHasFailed;
use Spatie\Backup\Tasks\Cleanup\CleanupStrategy;
use Spatie\Backup\Traits\Retryable;

class CleanupRunning extends BaseCommand implements Isolatable
{
    use Retryable;

    /** @var string */
    protected $signature = 'clean:backup {--disable-notifications} {--tries=}';

    /** @var string */
    protected $description = 'Remove all backups older than specified number of days in config.';

    public function __construct(
        protected CleanupStrategy $strategy,
        protected Config          $config,
    )
    {
        parent::__construct();
    }

    public function handle(): int
    {
        consoleOutput()->comment($this->currentTry > 1 ? sprintf('Attempt n°%d...', $this->currentTry) : 'Starting cleanup...');

        $disableNotifications = $this->option('disable-notifications');

        $this->setTries('cleanup');

        try {
            $backupDestinations = BackupDestinationFactory::createFromArray($this->config);

            $cleanupJob = new CleanupAsJob($backupDestinations, $this->strategy, $disableNotifications);

            $cleanupJob->run();

            consoleOutput()->comment('Cleanup completed!');

            return static::SUCCESS;
        } catch (Exception $exception) {
            if ($this->shouldRetry()) {
                if ($this->hasRetryDelay('cleanup')) {
                    $this->sleepFor($this->getRetryDelay('cleanup'));
                }

                $this->currentTry += 1;

                return $this->handle();
            }

            if (!$disableNotifications) {
                event(new CleanupHasFailed($exception));
            }

            return static::FAILURE;
        }
    }
}
