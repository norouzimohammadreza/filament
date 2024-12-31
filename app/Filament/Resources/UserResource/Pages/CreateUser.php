<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;

class CreateUser extends CreateRecord
{
    public function getTitle(): string|Htmlable
    {
        return __('filament\user.create_user');
    }

    protected function getRedirectUrl() :string
    {
        return $this->getResource()::getUrl('index');
    }
    protected static string $resource = UserResource::class;
}
