<?php

namespace App\Filament\Resources;

use App\ActivityLogsFunctions\ActivityLogHelper;
use App\Enums\LogLevelEnum;
use App\Filament\Resources\TagResource\RelationManagers\PostsRelationManager;
use App\Models\Tag;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Collection;

class TagResource extends Resource
{
    protected static ?string $model = Tag::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    public static function getNavigationLabel(): string
    {
        return trans('filament\dashboard.tags');
    }
    public static function getPluralModelLabel(): string
    {
        return __('filament\dashboard.tags');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label(__('filament\tag.name'))
                    ->required()
                    ->maxLength(255)
                    ->minLength(3)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('filament\tag.name'))->searchable(),
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
                            ->withEvent('Bulk Delete Tags')
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
            'index' => TagResource\Pages\ListTag::route('/'),
            'create' => TagResource\Pages\CreateTag::route('/create'),
            'edit' => TagResource\Pages\EditTag::route('/{record}/edit'),
        ];
    }
}
