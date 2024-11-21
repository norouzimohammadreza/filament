<?php

namespace App\Filament\Resources\TagResourseResource\Pages;

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
