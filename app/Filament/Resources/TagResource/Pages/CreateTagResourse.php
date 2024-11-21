<?php

namespace App\Filament\Resources\TagResource\Pages;

use App\Filament\Resources\TagResourseResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTagResourse extends CreateRecord
{
    protected static string $resource = TagResourseResource::class;
    protected function getRedirectUrl() :string
    {
        return $this->getResource()::getUrl('index');
    }
}
