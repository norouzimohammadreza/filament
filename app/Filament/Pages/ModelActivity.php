<?php

namespace App\Filament\Pages;

use App\Models\ModelLog;
use Filament\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;

class ModelActivity extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.model-activity';

    public function table(Table $table): Table
    {
        return $table
            ->query(ModelLog::query())
            ->columns([
                TextColumn::make('model_type')
                    ->getStateUsing(fn() => config('farda_activity_log.models'))
            ])
            ->filters([])
            ->actions([])
            ->bulkActions([]);

    }
}
