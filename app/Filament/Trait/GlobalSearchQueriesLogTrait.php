<?php

namespace App\Filament\Trait;

use App\Models\SearchLog;

trait GlobalSearchQueriesLogTrait
{
    public static function getGlobalSearchResults(string $search): Collection
    {
        if ($search) {
            // Injecting Search Log creation
            SearchLog::create([
                'search_query' => $search,
                'ip' => inet_pton(request()->ip()),
                'resource' => static::class,
                'user_id' => auth()->id(),
            ]);
        }

        // Return to normal function execution
        return parent::getGlobalSearchResults($search);
    }
}
