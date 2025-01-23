<?php

namespace App\Filament\Pages;

use App\Models\BackupRecord;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Pages\Page;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Artisan;

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

                TextColumn::make('type')
                    ->getStateUsing(function (BackupRecord $record) {
                    if ($record->is_file && $record->is_database_record) {
                        return 'file & database';
                    }
                    if ($record->is_file) {
                        return 'file';
                    }
                    if ($record->is_database_record) {
                        return 'database';
                    }
                }),

                TextColumn::make('created_at'),
            ])
            ->headerActions([
                CreateAction::make()
            ])
            ->actions([
                Action::make('download')
                ->action(function (){

                })
            ]);
    }

}
