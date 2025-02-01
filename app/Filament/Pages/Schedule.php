<?php

namespace App\Filament\Pages;

use App\CronExpressionParser\CronExpression;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;

class Schedule extends Page implements HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

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
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('cron'),
                TextColumn::make('translated')->getStateUsing(fn(\App\Models\Schedule $schedule) => (CronExpression::expressionToString($schedule->cron))),

            ]);
    }
}
