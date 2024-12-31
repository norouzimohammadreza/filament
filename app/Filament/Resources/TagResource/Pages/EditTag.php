<?php

namespace App\Filament\Resources\TagResource\Pages;

use App\Filament\Resources\TagResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;

class EditTag extends EditRecord
{
    protected static string $resource = TagResource::class;
    protected function getRedirectUrl() :string
    {
        return $this->getResource()::getUrl('index');
    }
    public function getTitle(): string|Htmlable
    {
        return __('filament\tag.edit_tag');
    }
    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()->modalHeading( __('filament\tag.delete_tag')),
        ];
    }
}
