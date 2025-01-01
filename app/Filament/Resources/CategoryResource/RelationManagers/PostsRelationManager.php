<?php

namespace App\Filament\Resources\CategoryResource\RelationManagers;

use App\Filament\Resources\PostResource;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Actions;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;

class PostsRelationManager extends RelationManager
{
    protected static string $relationship = 'posts';

    protected function getTableHeading(): string|Htmlable|null
    {
        return __('filament/post.posts');
    }

    public function form(Form $form): Form
    {
        return PostResource::form($form);
    }

    public function table(Table $table): Table
    {
        return PostResource::table($table)->headerActions([
            Tables\Actions\CreateAction::make()->label(__('filament/post.new_post'))
        ]);
    }
}
