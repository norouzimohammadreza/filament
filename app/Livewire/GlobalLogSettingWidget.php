<?php

namespace App\Livewire;

use App\ActivityLogsFunctions\ActivityLogHelper;
use App\Enums\LogLevelEnum;
use App\Models\ModelLogSetting;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class GlobalLogSettingWidget extends BaseWidget
{
    public function table(Table $table): Table
    {
        return $table
            ->heading('')
            ->query(ModelLogSetting::all()->where('model_type', 'App')->toQuery())
            ->paginated(false)
            ->columns([
                TextColumn::make('model_type')->label(__('filament\model_activity.global_log_setting'))
                ->getStateUsing(fn() => __('filament\model_activity.app')),
                ToggleColumn::make('is_enabled')->label(__('filament\model_activity.enabled'))->alignCenter()
                    ->inline(),
                SelectColumn::make('logging_level')->label(__('filament\model_activity.level'))->alignCenter()
                    ->options([
                        LogLevelEnum::LOW->value => 'Low',
                        LogLevelEnum::MEDIUM->value => 'Medium',
                        LogLevelEnum::HIGH->value => 'High',
                        LogLevelEnum::CRITICAL->value => 'Critical',
                    ])->selectablePlaceholder(false)
                    ->afterStateUpdated(function ($record, $state) {
                        $this->dispatch('global_settings_updated');
                    })
            ]);
    }

}
