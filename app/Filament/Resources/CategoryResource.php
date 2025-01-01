<?php

namespace App\Filament\Resources;

use App\ActivityLogsFunctions\ActivityLogHelper;
use App\Enums\LogLevelEnum;
use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers\PostsRelationManager;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Collection;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    public static function getPluralModelLabel(): string
    {
        return __('filament\dashboard.categories');
    }

    public static function getNavigationLabel(): string
    {
        return trans('filament\dashboard.categories');
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->label(__('validation.attributes.name'))
                   ->minLength('3')->maxLength(255)->required()
                ->unique(ignoreRecord: true)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label(__('validation.attributes.name'))->sortable()
                ->searchable()

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->action(function (Collection $record) {
                        ActivityLogHelper::getInstance()->log('HTTP Response', LogLevelEnum::CRITICAL->value)
                            ->withEvent('Bulk Delete Model Record Logging')
                            ->withProperties([
                                'resources' => [
                                    'name' => $record->pluck('name'),
                                ],
                            ])
                            ->save();
                    }),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            PostsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
