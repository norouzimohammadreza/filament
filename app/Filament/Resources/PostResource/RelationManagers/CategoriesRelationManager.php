<?php

namespace App\Filament\Resources\PostResource\RelationManagers;

use App\Filament\Resources\CategoryResource;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;
use Filament\Tables;
use Illuminate\Contracts\Support\Htmlable;

class CategoriesRelationManager extends RelationManager
{
    protected function getTableHeading(): string|Htmlable|null
    {
        return __('filament/dashboard.categories');
    }

    protected static string $relationship = 'categories';

    public function form(Form $form): Form
    {
        return CategoryResource::form($form);
    }

    public function table(Table $table): Table
    {
        return CategoryResource::table($table)->headerActions([
            Tables\Actions\CreateAction::make()->label(__('filament/category.new_category'))
        ]);
    }
}
