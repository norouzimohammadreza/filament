<?php

namespace App\Filament\Trait;

use App\Models\SearchLog;
use Illuminate\Database\Eloquent\Builder;

trait TableSearchQueriesLogTrait
{
    protected function applyColumnSearchesToTableQuery(Builder $query): Builder
    {
        if ($this->getTableSearch()) {
            // Injecting Search Log creation
            SearchLog::create([
                'search_query' => $this->getTableSearch(),
                'ip' => inet_pton(request()->ip()),
                'resource' => static::$resource,
                'user_id' => auth()->id(),
            ]);
        }

        // Return to normal function execution
        return parent::applyColumnSearchesToTableQuery($query);
    }
}
