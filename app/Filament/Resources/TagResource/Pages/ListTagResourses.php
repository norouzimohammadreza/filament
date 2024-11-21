<?php

namespace App\Filament\Resources\TagResource\Pages;

use App\Filament\Resources\TagResourseResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTagResourses extends ListRecords
{
    protected static string $resource = TagResourseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
