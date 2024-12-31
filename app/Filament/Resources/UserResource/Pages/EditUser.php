<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;
    public function getTitle(): string|Htmlable
    {
        return __('filament\user.edit_user');
    }
    protected function getRedirectUrl() :string
    {
        return $this->getResource()::getUrl('index');
    }
    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()->modalHeading(__('filament\user.delete_user')),
        ];
    }
}
