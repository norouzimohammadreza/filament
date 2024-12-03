<?php

namespace App\Filament\Trait;

use App\ActivityLogsFunctions\LogResponseBuilder;
use App\Enums\LogLevelEnum;
use App\Models\SearchLog;
use Illuminate\Database\Eloquent\Builder;
use phpDocumentor\Reflection\Types\Static_;

trait TableSearchQueriesLogTrait
{
    protected function applyColumnSearchesToTableQuery(Builder $query): Builder
    {
        if ($this->getTableSearch()) {

            $logger = new LogResponseBuilder();
            $logger->withName('HTTP SEARCH')->withEvent($this->getTableSearch())
                ->withDescription(static::$resource)
                ->withLevel(LogLevelEnum::MEDIUM->value)->log()->response();

        }

        return parent::applyColumnSearchesToTableQuery($query);
    }
}
