<?php

namespace App\Filament\Pages;

use App\Enums\LogLevelEnum;
use App\Filament\Widgets\LogSettingWidget;
use App\Models\ModelLog;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Pages\Page;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Filament\Tables;
class ModelActivity extends Page implements HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.model-activity';
    protected ?string $heading = 'Log Setting';
    public function getHeaderWidgetsColumns(): int | array
    {
        return 1;
    }
    protected function getHeaderWidgets(): array
    {
        return [
            \App\Livewire\LogSettingWidget::class,
        ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(ModelLog::all()->where('model_type','!=','App')->toQuery())
            ->paginated(false)
            ->columns([
                TextColumn::make('model_type')->label('Model'),
                ToggleColumn::make('is_enabled')->label('Enabled')->alignCenter()
                    ->inline(),
                SelectColumn::make('logging_level')->label('Level')->alignCenter()
                    ->options([
                        LogLevelEnum::LOW->value => 'Low',
                        LogLevelEnum::MEDIUM->value => 'Medium',
                        LogLevelEnum::HIGH->value => 'High',
                        LogLevelEnum::CRITICAL->value => 'Critical',
                    ])->selectablePlaceholder(false)

            ])
            ->actions([
                Tables\Actions\Action::make('جزئیات')
                ->form([
                    TextInput::make('Level')
                ])->action(fn() => LogLevelEnum::values()),
            ]);
    }
}
