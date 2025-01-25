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
                    ->suffix('Byte ')->color('info')

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
                Action::make('Backup database'),

                Action::make('Backup files')
                    ->color('success')->action(function () {
                        $s = Artisan::call('run:backup --only-files');
                        $this->dirName = env('APP_NAME');
                        $this->backupFiles = Storage::disk('local')->files($this->dirName);
                        for ($i = 0; $i < sizeof($this->backupFiles) ?? 1; $i++) {
                            $file = explode('/', $this->backupFiles[$i]);
                            BackupRecord::firstOrCreate([
                                'name' => end($file),
                                'path' => $this->backupFiles[$i],
                                'size' => Storage::size($this->backupFiles[$i]),
                                'is_database_record' => 0
                            ]);
                        }
                    }),

                Action::make('Backup both')
                    ->color('info')->action(function () {
                        DbBackup::dispatch()->onQueue('dbBackup');
                    }),


            ])
            ->actions([
                Action::make('download')
                    ->action(function () {

                    })
            ]);
    }

}
