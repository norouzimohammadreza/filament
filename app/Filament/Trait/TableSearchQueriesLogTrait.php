<?php

namespace App\Filament\Trait;

use App\ActivityLogsFunctions\ActivityLogHelper;
use App\Enums\LogLevelEnum;
use Illuminate\Database\Eloquent\Builder;

trait TableSearchQueriesLogTrait
{
    protected function applyColumnSearchesToTableQuery(Builder $query): Builder
    {
        if ($this->getTableSearch()) {
            ActivityLogHelper::getInstance()->log('HTTP Response', LogLevelEnum::HIGH->value)
                ->withEvent('HTTP SEARCH')
                ->withProperties([
                    'search' => $this->getTableSearch(),
                    'resource' => static::$resource,
                ])
                ->save();

        }

        return parent::applyColumnSearchesToTableQuery($query);
    }
}
