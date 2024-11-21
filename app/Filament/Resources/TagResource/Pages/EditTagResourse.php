<?php

namespace App\Filament\Resources\TagResource\Pages;

use App\Filament\Resources\TagResourseResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTagResourse extends EditRecord
{
    protected static string $resource = TagResourseResource::class;
    protected function getRedirectUrl() :string
    {
        return $this->getResource()::getUrl('index');
    }
    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
