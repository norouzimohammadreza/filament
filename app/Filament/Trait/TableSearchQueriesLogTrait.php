<?php

namespace App\Filament\Trait;

use App\ActivityLogsFunctions\ActivityLogHelper;
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

            ActivityLogHelper::log('HTTP SEARCH',LogLevelEnum::Low->value)
                ->withProperties([
                    'status_code' => response()->getStatusCode(),
                ])
                ->save();

        }

        return parent::applyColumnSearchesToTableQuery($query);
    }
}
