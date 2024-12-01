<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Filament\Trait\GlobalSearchQueriesLogTrait;
use App\Filament\Trait\TableSearchQueriesLogTrait;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUsers extends ListRecords
{
    use GlobalSearchQueriesLogTrait, TableSearchQueriesLogTrait;
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
