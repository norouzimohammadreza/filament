<?php

namespace App\Filament\Pages;

use App\CronExpressionParser\CronExpression;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Pages\Page;

use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;

class Schedule extends Page implements HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-m-signal';

    protected static string $view = 'filament.pages.schedule';

    public static function getNavigationLabel(): string
    {
        return trans('filament\dashboard.schedule');
    }

    protected ?string $heading;

    public function getHeading(): string|Htmlable
    {
        return $this->heading = __('filament\schedules.schedule_tasks');
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(\App\Models\Schedule::query())
            ->headerActions([
                CreateAction::make()
                ->label(__('filament/schedules.create_new_schedule'))
                ->modalHeading(__('filament/schedules.create_new_schedule'))
                ->form([
                    Section::make()->schema([
                        TextInput::make('name')
                            ->label(__('filament/schedules.name'))
                            ->required(),
                        TextInput::make('cron')
                            ->label(__('filament/schedules.cron_pattern'))
                            ->required()
                        ->default('* * * * *'),
                    ])->columns()
                ]),
            ])
            ->columns([
                TextColumn::make('name')
                    ->alignCenter()
                ->label(__('filament/schedules.name')),
                TextColumn::make('cron')
                    ->alignCenter()
                    ->label(__('filament/schedules.cron_pattern')),
                TextColumn::make('translated')
                    ->alignCenter()
                    ->getStateUsing(fn(\App\Models\Schedule $schedule)
                    => (CronExpression::expressionToString($schedule->cron)))
                    ->label(__('filament/schedules.expression_pattern')),
            ])->actions([
                DeleteAction::make()

            ])->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
