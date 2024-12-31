<?php

namespace App\Filament\Pages;

use App\ActivityLogsFunctions\ActivityLogHelper;
use App\Enums\LogLevelEnum;
use App\Models\ModelLogSetting;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Pages\Page;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;

class ModelActivity extends Page implements HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    protected $listeners = [
        'global_settings_updated' => '$refresh',
    ];

    public static function getNavigationLabel(): string
    {
        return trans('filament\dashboard.model_log_settings');
    }

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.model-activity';
    protected ?string $heading;

    public static function getNavigationGroup(): ?string
    {
        return __('filament\dashboard.log_settings');
    }

    public function mount()
    {
        $this->heading = __('filament\model_activity.log_setting');
    }

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
                TextColumn::make('model_type')->label(__('filament\model_activity.models')),
                ToggleColumn::make('is_enabled')->label(__('filament\model_activity.enabled'))->alignCenter()
                    ->inline(),
                ToggleColumn::make('follow_global_config')
                    ->label(__('filament\model_activity.follow_global_config'))->alignCenter()->inline(),
                SelectColumn::make('logging_level')->label(__('filament\model_activity.level'))->alignCenter()
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
