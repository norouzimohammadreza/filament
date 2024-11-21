<?php

namespace App\Filament\Resources\TagResourseResource\Pages;

use App\Filament\Resources\TagResourseResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTagResourse extends EditRecord
{
    protected static string $resource = TagResourseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
