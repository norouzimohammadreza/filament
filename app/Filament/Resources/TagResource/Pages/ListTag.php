<?php

namespace App\Filament\Resources\TagResource\Pages;

use App\Filament\Resources\TagResource;
use App\Filament\Trait\GlobalSearchQueriesLogTrait;
use App\Filament\Trait\TableSearchQueriesLogTrait;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTag extends ListRecords
{
    use GlobalSearchQueriesLogTrait, TableSearchQueriesLogTrait;
    protected static string $resource = TagResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label(__('filament\tag.new_tag')),
        ];
    }
}
