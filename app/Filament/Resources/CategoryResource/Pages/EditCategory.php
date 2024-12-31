<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use App\Filament\Resources\CategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;

class EditCategory extends EditRecord
{
    protected static string $resource = CategoryResource::class;
public function getTitle(): string|Htmlable
{
    return __('filament\category.edit_category');
}

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()->modalHeading(__('filament\category.delete_category')),
        ];

    }
    protected function getRedirectUrl() :string
    {
        return $this->getResource()::getUrl('index');
    }
}
