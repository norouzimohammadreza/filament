<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;

class CreatePost extends CreateRecord
{
    protected static string $resource = PostResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->user()->id;

        return $data;
    }
    public function getTitle(): string|Htmlable
    {
        return (__('filament\post.create_post'));
    }

    protected function getRedirectUrl() :string
    {
        return $this->getResource()::getUrl('index');
    }

}
