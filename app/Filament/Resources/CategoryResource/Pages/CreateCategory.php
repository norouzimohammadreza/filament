<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use App\Filament\Resources\CategoryResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;

class CreateCategory extends CreateRecord
{
    protected static string $resource = CategoryResource::class;

    public function getTitle(): string|Htmlable
    {
        return __('filament\category.create_category');
    }

    protected function getRedirectUrl() :string
    {
        return $this->getResource()::getUrl('index');
    }
}
