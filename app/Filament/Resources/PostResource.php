<?php

namespace App\Filament\Resources;

use App\ActivityLogsFunctions\ActivityLogHelper;
use App\Enums\LogLevelEnum;
use App\Filament\Resources\PostResource\Pages;
use App\Filament\Resources\PostResource\RelationManagers\CategoriesRelationManager;
use App\Filament\Resources\PostResource\RelationManagers\TagsRelationManager;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Collection;
use Spatie\Activitylog\Models\Activity;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    public static function getNavigationLabel(): string
    {
        return trans('filament\dashboard.posts');
    }
    public static function getPluralModelLabel(): string
    {
        return __('filament\post.posts');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label(__('filament\post.title'))
                    ->required()
                    ->maxLength(255)
                    ->placeholder('Title'),
                Forms\Components\Select::make('tags')
                    ->label(__('filament\dashboard.tags'))
                    ->preload()
                    ->multiple()
                    ->relationship('tags', 'name'),
                Forms\Components\Select::make('categories')
                    ->label(__('filament\dashboard.categories'))
                    ->preload()
                    ->multiple()
                    ->relationship('categories', 'name')
                    ->required()

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->searchable()->label(__('filament\post.title')),
                TextColumn::make('user.name')->label('Author')->searchable()
                    ->label(__('filament\post.author')),
                TextColumn::make('created_at')->label('Published')
                    ->label(__('filament\post.published'))->sortable()
                    ->getStateUsing(function (Post $record) {
                        return verta($record->created_at, 'Asia/Tehran');
                    })
            ])
            ->
            filters([
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
                                    'title' => $record->pluck('title'),
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
            TagsRelationManager::class,
            CategoriesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
