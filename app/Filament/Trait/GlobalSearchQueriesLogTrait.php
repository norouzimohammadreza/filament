<?php

namespace App\Filament\Trait;

use App\ActivityLogsFunctions\LogResponseBuilder;
use App\Enums\LogLevelEnum;

trait GlobalSearchQueriesLogTrait
{
    public static function getGlobalSearchResults(string $search): Collection
    {
        if ($search) {

            $logger = new LogResponseBuilder();
            $logger->withName('HTTP SEARCH')->withEvent($search)
                ->withDescription(static::$resource)
                ->withLevel(LogLevelEnum::MEDIUM->value)->log()->response();
        }

        return parent::getGlobalSearchResults($search);
    }
}
