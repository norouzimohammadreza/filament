<?php

namespace App\Filament\Pages;

use App\Jobs\DbBackup;
use App\Jobs\FileAndDbBackup;
use App\Jobs\FileBackup;
use App\Models\BackupRecord;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Pages\Page;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;


class BackupPage extends Page implements HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';

    protected static string $view = 'filament.pages.backup-page';
    protected static ?string $slug = 'backup';
    public static ?array $x = [];

    public function getHeading(): string|Htmlable
    {
        return $this->heading = __('filament\dashboard.backup');
    }

    public static function getNavigationLabel(): string
    {
        return trans('filament\dashboard.backup');
    }
    public function mount()
    {
       Artisan::call('monitor');
       //dd(Cache::get('main_backup_table'));
    }

    public function table(Table $table): Table
    {
        return $table->query(BackupRecord::query())
            ->columns([
                TextColumn::make('name')
                    ->alignCenter()
                    ->label(__('filament\backup.name')),

                TextColumn::make('disk')
                    ->alignCenter()
                    ->label(__('filament\backup.disk')),

                TextColumn::make('path')
                    ->alignCenter()
                    ->label(__('filament\backup.path')),

                TextColumn::make('size')
                    ->badge()
                    ->color('info')
                    ->alignCenter()
                    ->label(__('filament\backup.size')),

                TextColumn::make('type')
                    ->alignCenter()
                    ->label(__('filament\backup.type'))
                    ->badge()
                    ->getStateUsing(function (BackupRecord $record) {
                        if ($record->is_file && $record->is_database_record) {
                            return __('filament\backup.files_database');
                        }
                        if ($record->is_file) {
                            return __('filament\backup.files');
                        }
                        return __('filament\backup.database');
                    }),

                TextColumn::make('created_at')
                    ->alignCenter()
                    ->label(__('filament\backup.time'))
                    ->getStateUsing(function (BackupRecord $record) {
                        return verta($record->created_at, 'Asia/Tehran');
                    }),
            ])
            ->headerActions([
                Action::make('Backup Overview')
                    ->label(__('filament/backup.backup_overview'))
                    ->color('danger')->infolist([
                        Section::make()->schema([
                            TextEntry::make('name')
                                ->label(__('filament/backup.name'))
                            ->getStateUsing(fn()=>Cache::get('main_backup_table')[0]),
                            TextEntry::make('disk')
                                ->label(__('filament/backup.disk'))
                                ->getStateUsing
                                (fn()=>Cache::get('main_backup_table')['disk']),
                            TextEntry::make('is reachable')
                                ->label(__('filament/backup.is_reachable'))
                                ->getStateUsing(fn()=>Cache::get('main_backup_table')[1]),
                            TextEntry::make('is Healthy')
                                ->label(__('filament/backup.is_healthy'))
                                ->getStateUsing(fn()=>Cache::get('main_backup_table')[2]),
                            TextEntry::make('amount')
                                ->label(__('filament/backup.amount'))
                                ->getStateUsing
                                (fn()=>Cache::get('main_backup_table')['amount']),
                            TextEntry::make('newest')
                                ->label(__('filament/backup.newest'))
                                ->getStateUsing
                                (fn()=>Cache::get('main_backup_table')['newest']),
                            TextEntry::make('usedStorage')
                                ->label(__('filament/backup.used_storage'))
                                ->getStateUsing
                                (fn()=>Cache::get('main_backup_table')['usedStorage']),
                            ])->columns(4)->columnSpan(12),

                        Section::make()
                        ->schema([
                            TextEntry::make('name')
                                ->label(__('filament/backup.name'))
                            ->getStateUsing(fn()=>Cache::get('failure_backup_table')[0]),
                            TextEntry::make('disk')
                                ->label(__('filament/backup.disk'))
                                ->getStateUsing(fn()=>Cache::get('failure_backup_table')[1]),
                            TextEntry::make('failed check')
                                ->label(__('filament/backup.failed_check'))
                                ->getStateUsing(fn()=>Cache::get('failure_backup_table')[2]),
                            TextEntry::make('description')
                                ->label(__('filament/backup.description'))
                                ->getStateUsing(fn()=>Cache::get('failure_backup_table')[3])
                            ->columnSpan(3),

                        ])->columns(3)->columnSpan(12),


                    ]),

                Action::make('Backup database')
                    ->label(__('filament\backup.backup_database'))
                    ->action(function () {
                        DbBackup::dispatch()->onQueue('dbBackup');
                    }),

                Action::make('Backup files')
                    ->label(__('filament\backup.backup_files'))
                    ->color('success')->action(function () {
                        FileBackup::dispatch()->onQueue('fileBackup');
                    }),

                Action::make('Backup both')
                    ->label(__('filament\backup.backup_both'))
                    ->color('info')->action(function () {
                        FileAndDbBackup::dispatch()->onQueue('backup');
                    }),
            ])
            ->actions([
                Action::make('download')
                    ->label(__('filament\backup.download'))
                    ->action(function (BackupRecord $record) {
                        return response()
                            ->download(public_path($record->path . $record->name));
                    })
            ]);
    }

}
