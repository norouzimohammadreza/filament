<?php

namespace App\Filament\Trait;

use App\ActivityLogsFunctions\LogResponseBuilder;
use App\Models\SearchLog;
use Illuminate\Database\Eloquent\Builder;

trait TableSearchQueriesLogTrait
{
    protected function applyColumnSearchesToTableQuery(Builder $query): Builder
    {
        if ($this->getTableSearch()) {
            // Injecting Search Log creation
            $logger = new LogResponseBuilder();
            $logger->withName('HTTP')->withEvent('HTTP Error Response')
                ->withDescription('HTTP Error Response')->withProperties([
                    'old' => [
                        'search_query' => $this->getTableSearch(),
                        'resource' => static::$resource,
                    ]
                ])->withLevel(1)->log()->response();

        }

        // Return to normal function execution
        return parent::applyColumnSearchesToTableQuery($query);
    }
}
