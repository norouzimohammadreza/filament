<?php

namespace App\Livewire;

use App\Enums\LogLevelEnum;
use App\Models\ModelLog;
use Filament\Tables;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LogSettingWidget extends BaseWidget
{
    public function table(Table $table): Table
    {
        return $table
            ->heading('')
            ->query(ModelLog::all()->where('model_type', 'App')->toQuery())
            ->paginated(false)
            ->columns([
                TextColumn::make('model_type')->label('تنظیمات کلی برنامه'),
                ToggleColumn::make('is_enabled')->label('Enabled')->alignCenter()
                    ->inline(),
                SelectColumn::make('logging_level')->label('Level')->alignCenter()
                    ->options([
                        LogLevelEnum::LOW->value => 'Low',
                        LogLevelEnum::MEDIUM->value => 'Medium',
                        LogLevelEnum::HIGH->value => 'High',
                        LogLevelEnum::CRITICAL->value => 'Critical',
                    ])->selectablePlaceholder(false)
            ]);
    }
}
