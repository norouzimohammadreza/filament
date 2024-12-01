<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use App\Filament\Resources\CategoryResource;
use App\Filament\Trait\GlobalSearchQueriesLogTrait;
use App\Filament\Trait\TableSearchQueriesLogTrait;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCategories extends ListRecords
{
    use GlobalSearchQueriesLogTrait, TableSearchQueriesLogTrait;
    protected static string $resource = CategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
