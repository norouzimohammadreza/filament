<?php

namespace App\Filament\Pages;

use App\Enums\LogLevelEnum;
use App\Models\ModelLog;
use Filament\Forms\Components\Toggle;
use Filament\Pages\Page;
use Filament\Tables\Actions\SelectAction;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
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
                TextColumn::make('model_type')->label('Model')
                    ->getStateUsing
                    (fn(ModelLog $record) => (explode('\\', $record->model_type)[2])),
                ToggleColumn::make('is_enabled')->label('Enabled'),
                SelectColumn::make('logging_level')->label('Level')
                    ->options([
                        LogLevelEnum::LOW->value => 'Low',
                        LogLevelEnum::MEDIUM->value => 'Medium',
                        LogLevelEnum::HIGH->value => 'High',
                        LogLevelEnum::CRITICAL->value => 'Critical',
                    ])
            ])
            ->filters([])
            ->actions([])
            ->bulkActions([]);

    }
}
