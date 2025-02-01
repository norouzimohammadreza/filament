<?php

namespace App\Filament\Pages;

use App\CronExpressionParser\CronExpression;
use Brofian\CronTranslator\CronTranslator;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;

class Schedule extends Page  implements HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.schedule';

    public function table(Table $table): Table
    {
        return $table
            ->query(\App\Models\Schedule::query())
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('cron'),
                TextColumn::make('translated')->getStateUsing(fn(\App\Models\Schedule $schedule)=>(CronExpression::expressionToString($schedule->cron))),

            ]);
    }
}
