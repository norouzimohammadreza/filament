<?php

namespace App\Filament\Pages;

use App\Jobs\DbBackup;
use App\Jobs\TestJob;
use App\Models\BackupRecord;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Pages\Page;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;


class BackupPage extends Page implements HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-m-x-mark';

    protected static string $view = 'filament.pages.backup-page';
    private $backupFiles, $dirName;

    public function table(Table $table): Table
    {
        return $table->query(BackupRecord::query())
            ->columns([
                TextColumn::make('name'),

                TextColumn::make('path'),

                TextColumn::make('size')
                    ->badge()
                    ->color('info')

                ,

                TextColumn::make('type')
                    ->badge()
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
                Action::make('Backup database')->action(function () {
                    DbBackup::dispatch()->onQueue('dbBackup');
                }),

                Action::make('Backup files')
                    ->color('success')->action(function () {
                        Artisan::call('run:backup --only-files');
                    }),

                Action::make('Backup both')
                    ->color('info')->action(function () {
                        DbBackup::dispatch()->onQueue('Backup');
                    }),


            ])
            ->actions([
                Action::make('download')
                    ->action(function () {

                    })
            ]);
    }

}
