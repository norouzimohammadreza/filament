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
            ActivityLogHelper::log('HTTP Response', LogLevelEnum::HIGH->value)
                ->withProperties([
                    'search' => $this->getTableSearch(),
                    'resource' => static::$resource,
                ])
                ->save();

        }

        return parent::applyColumnSearchesToTableQuery($query);
    }
}
