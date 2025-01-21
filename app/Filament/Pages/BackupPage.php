<?php

namespace App\Filament\Pages;

use App\Models\BackupRecord;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Pages\Page;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Table;

class BackupPage extends Page
{
    use InteractsWithTable;
    use InteractsWithForms;
    protected static ?string $navigationIcon = 'heroicon-m-x-mark';

    protected static string $view = 'filament.pages.backup-page';

    public function table(Table $table): Table
    {
        return $table
            ->query(BackupRecord::query())
            ->columns([]);
    }
}
