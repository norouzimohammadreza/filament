<?php

namespace App\Filament\Resources\TagResource\Pages;

use App\Filament\Resources\TagResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;

class CreateTag extends CreateRecord
{
    protected static string $resource = TagResource::class;
    public function getTitle(): string|Htmlable
    {
        return __('filament\tag.create_tag');
    }

    protected function getRedirectUrl() :string
    {
        return $this->getResource()::getUrl('index');
    }
}
