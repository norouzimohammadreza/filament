<?php

namespace App\BackupServices;

use Illuminate\Support\Collection;
use Spatie\Backup\BackupDestination\BackupDestinationFactory;
use Spatie\Backup\Config\Config;
use Spatie\Backup\Config\SourceFilesConfig;
use Spatie\Backup\Tasks\Backup\BackupJobFactory;
use Spatie\Backup\Tasks\Backup\DbDumperFactory;

class MyBackupJobFactory extends BackupJobFactory
{
    public static function createFromConfig(Config $config): MyBackupJob
    {
        return (new MyBackupJob($config))
            ->setFileSelection(static::createFileSelection($config->backup->source->files))
            ->setDbDumpers(static::createDbDumpers($config->backup->source->databases))
            ->setBackupDestinations(BackupDestinationFactory::createFromArray($config));
    }

    protected static function createFileSelection(SourceFilesConfig $sourceFiles): SelectionFile
    {
        return SelectionFile::create($sourceFiles->include)
            ->excludeFilesFrom($sourceFiles->exclude)
            ->shouldFollowLinks($sourceFiles->followLinks)
            ->shouldIgnoreUnreadableDirs($sourceFiles->ignoreUnreadableDirectories);
    }

    protected static function createDbDumpers(array $dbConnectionNames): Collection
    {
        return collect($dbConnectionNames)->mapWithKeys(
            fn(string $dbConnectionName): array => [$dbConnectionName => DbDumperFactory::createFromConnection($dbConnectionName)]
        );
    }
}
