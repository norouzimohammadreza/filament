<?php

namespace App\Filament\Resources;

use App\ActivityLogsFunctions\ActivityLogHelper;
use App\Filament\Resources\LogResource\Pages;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Spatie\Activitylog\Models\Activity;


class LogResource extends Resource
{
    protected static ?string $model = Activity::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('ip_address')
                    ->getStateUsing(function (Activity $activity) {
                        return inet_ntop($activity->ip);
                    }),
                TextColumn::make('url'),
                TextColumn::make('causer.name'),
                TextColumn::make('subject_id')->wrap(),
                TextColumn::make('subject_type'),
                TextColumn::make('created_at')->label('Time')
                    ->sortable()->dateTime()
                ,
            ])->defaultSort('created_at', 'desc')
            ->actions([
                Tables\Actions\DeleteAction::make(),
                Action::make('نمایش')
                    ->url(function (Activity $record) {
                        return ActivityLogHelper::getViewUrl($record);
                    })
                    ->icon('heroicon-o-eye')
                ->disabled(fn(Activity $record) => $record->log_name == 'HTTP SEARCH'),
                Tables\Actions\ViewAction::make('detail')
                    ->label('جزئیات')
                    ->form([
                   KeyValue::make('properties.old'),
                   KeyValue::make('properties.attributes'),
                ])->disabled(fn(Activity $record) => $record->subject_id == null),
            ])
            ->filters([
                //
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLogs::route('/'),
        ];
    }
}
