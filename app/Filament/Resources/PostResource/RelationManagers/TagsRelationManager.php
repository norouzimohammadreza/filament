<?php

namespace App\Filament\Resources\PostResource\RelationManagers;

use App\Filament\Resources\TagResource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TagsRelationManager extends RelationManager
{
    protected static string $relationship = 'tags';

    public static function getTitle(\Illuminate\Database\Eloquent\Model $ownerRecord, string $pageClass): string
    {
        return __('filament/dashboard.tags');
    }


    public function form(Form $form): Form
    {
        return TagResource::form($form);
    }

    public function table(Table $table): Table
    {
        return TagResource::table($table)->headerActions([
            Tables\Actions\CreateAction::make()->label(__('filament/tag.new_tag'))
        ]);
    }
}
