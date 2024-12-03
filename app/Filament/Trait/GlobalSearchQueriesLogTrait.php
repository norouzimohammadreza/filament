<?php

namespace App\Filament\Trait;

use App\ActivityLogsFunctions\ActivityLogHelper;
use App\ActivityLogsFunctions\LogResponseBuilder;
use App\Enums\LogLevelEnum;

trait GlobalSearchQueriesLogTrait
{
    public static function getGlobalSearchResults(string $search): Collection
    {
        if ($search) {

            ActivityLogHelper::log('HTTP SEARCH', LogLevelEnum::MEDIUM->value)
                ->withProperties([
                    'search' => $search,
                    'resource' => static::$resource,
                ])
                ->save();
        }

        return parent::getGlobalSearchResults($search);
    }
}
