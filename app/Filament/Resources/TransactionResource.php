<?php

namespace App\Filament\Resources;


use App\Filament\Resources\TransactionResource\Pages;
use App\Models\Transaction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    public static function getNavigationLabel(): string
    {
        return trans('filament\dashboard.transactions');
    }
    public static function getPluralModelLabel(): string
    {
        return __('filament\dashboard.transactions');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('amount')
                    ->label(__('filament\transaction.amount'))
                    ->required()->maxLength(255)->numeric(),
                Forms\Components\TextInput::make('description')
                    ->label(__('filament\transaction.description'))
                    ->required()->maxLength(255),
                Forms\Components\Select::make('category_id')
                    ->label(__('filament\transaction.category'))
//                    ->options(Category::all()->pluck('name', 'id'))
                    ->relationship('category', 'name')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('amount')->sortable()->searchable()
                    ->label(__('filament\transaction.amount')),
                Tables\Columns\TextColumn::make('description')->searchable()
                    ->label(__('filament\transaction.description')),
                Tables\Columns\TextColumn::make('category.name')->searchable()
                    ->label(__('filament\transaction.category')),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable()
                ->label(__('filament\activities_page.when')),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransaction::route('/create'),
            'edit' => Pages\EditTransaction::route('/{record}/edit'),
        ];
    }

}
