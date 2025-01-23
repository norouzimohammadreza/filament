<?php

namespace App\Filament\Pages;

use App\Models\BackupRecord;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Pages\Page;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;

class BackupPage extends Page implements HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;
    protected static ?string $navigationIcon = 'heroicon-m-x-mark';

    protected static string $view = 'filament.pages.backup-page';
    public function table(Table $table): Table
    {
        return $table->query(BackupRecord::query())
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('path'),
                TextColumn::make('size'),
                TextColumn::make('is_file'),
                TextColumn::make('is_database_record'),
                TextColumn::make('created_at'),
            ])
            ->headerActions([
                CreateAction::make()
            ])
            ->actions([
                EditAction::make()
            ]);
    }

}
