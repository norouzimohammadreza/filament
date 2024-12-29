<?php

namespace App\Filament\Pages;

use App\ActivityLogsFunctions\ActivityLogHelper;
use App\Enums\LogLevelEnum;
use App\Livewire\CheckLogLevelState;
use App\Models\ModelLogSetting;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Pages\Page;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Attributes\On;

class ModelActivity extends Page implements HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    protected $listeners = [
        'global_settings_updated' => '$refresh',
    ];

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.model-activity';
    protected ?string $heading = 'Log Setting';

    public function getHeaderWidgetsColumns(): int|array
    {
        return 1;
    }

    protected function getHeaderWidgets(): array
    {
        return [
            \App\Livewire\GlobalLogSettingWidget::class,
//            \App\Livewire\LogSettingWidget2::class,
        ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(ModelLogSetting::all()->where('model_type', '!=', 'App')->toQuery())
            ->paginated(false)
            ->columns([
                TextColumn::make('model_type')->label('Model'),
                ToggleColumn::make('is_enabled')->label('Enabled')->alignCenter()
                    ->inline(),
                ToggleColumn::make('follow_global_config')
                    ->label('Follow Global Config')->alignCenter()->inline(),
                SelectColumn::make('logging_level')->label('Level')->alignCenter()
                    ->options([
                        LogLevelEnum::LOW->value => 'Low',
                        LogLevelEnum::MEDIUM->value => 'Medium',
                        LogLevelEnum::HIGH->value => 'High',
                        LogLevelEnum::CRITICAL->value => 'Critical',
                    ])
                    ->selectablePlaceholder(false)
                    ->disabled(fn(ModelLogSetting $record) => $record->follow_global_config == 1)
                    ->getStateUsing(function (ModelLogSetting $record) {
                        if ($record->follow_global_config == 1) {
                            return ActivityLogHelper::getInstance()->getAppMinimumLoggingLevel();
                        }
                        return $record->logging_level;
                    })
                ,
            ]);
    }
}
