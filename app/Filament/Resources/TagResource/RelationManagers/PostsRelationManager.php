<?php

namespace App\Filament\Resources\TagResource\RelationManagers;

use App\Filament\Resources\PostResource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PostsRelationManager extends RelationManager
{
    protected static string $relationship = 'posts';
    public static function getTitle(\Illuminate\Database\Eloquent\Model $ownerRecord, string $pageClass): string
    {
        return __('filament/dashboard.posts');
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
