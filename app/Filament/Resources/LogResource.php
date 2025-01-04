<?php

namespace App\Filament\Resources;

use App\ActivityLogsFunctions\ActivityLogHelper;
use App\Enums\LogLevelEnum;
use App\Filament\Resources\LogResource\Pages;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Infolists\Components\KeyValueEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ViewEntry;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Activitylog\Models\Activity;

class LogResource extends Resource
{
    protected static ?string $model = Activity::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationGroup(): ?string
    {
        return __('filament\dashboard.log_settings');
    }

    public static function getNavigationLabel(): string
    {
        return trans('filament\dashboard.activities');
    }

    public static function getPluralModelLabel(): string
    {
        return __('filament\activities_page.activities');
    }

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
                    ->label(__('filament\activities_page.ip_address'))
                    ->getStateUsing(function (Activity $activity) {
                        return inet_ntop($activity->ip);
                    }),
                TextColumn::make('url')->label(__('filament\activities_page.url')),
                TextColumn::make('causer.name')->label(__('filament\activities_page.causer')),
                TextColumn::make('level')->label(__('filament\model_record_log_setting.level'))
                    ->getStateUsing(function (Activity $record){
                        switch ($record->level){
                            case  LogLevelEnum::LOW->value:
                                return LogLevelEnum::LOW->translation();
                            case  LogLevelEnum::MEDIUM->value:
                                return LogLevelEnum::MEDIUM->translation();
                            case  LogLevelEnum::HIGH->value:
                                return LogLevelEnum::HIGH->translation();
                            case  LogLevelEnum::CRITICAL->value:
                                return LogLevelEnum::CRITICAL->translation();
                        }
                    }),
                TextColumn::make('created_at')->label(__('filament\activities_page.when'))
                    ->sortable()->getStateUsing(function (Activity $activity) {
                        return verta($activity->created_at, 'Asia/Tehran');
                    }),
            ])->defaultSort('created_at', 'desc')
            ->actions([
                Tables\Actions\DeleteAction::make(),
                Action::make(__('filament\activities_page.show'))
                    ->url(function (Activity $record) {
                        return ActivityLogHelper::getInstance()->getViewUrl($record);
                    })
                    ->icon('heroicon-o-eye')
                    ->disabled(fn(Activity $record) => $record->event == 'HTTP SEARCH'),
                Tables\Actions\ViewAction::make('detail')
                    ->label(__('filament\activities_page.details'))
                    ->modalHeading(__('filament\activities_page.details'))
                ->infolist([

                    Section::make()->schema([
                        TextEntry::make('causer.name')->label(__('filament\activities_page.causer')),
                    ])->hidden(fn (Activity $activity)=> $activity->causer === null),

                    Section::make(__('filament\activities_page.access_event'))->schema([
                        TextEntry::make('url')->label(__('filament\activities_page.url')),
                        TextEntry::make('ip')->label(__('filament\activities_page.ip_address'))
                            ->getStateUsing(function (Activity $activity) {
                            return inet_ntop($activity->ip);
                        }),
                        TextEntry::make('event')->label(__('filament\activities_page.event')),
                        TextEntry::make('level')->label(__('filament\model_record_log_setting.level'))
                            ->getStateUsing(function (Activity $record){
                                switch ($record->level){
                                    case  LogLevelEnum::LOW->value:
                                        return LogLevelEnum::LOW->translation();
                                    case  LogLevelEnum::MEDIUM->value:
                                        return LogLevelEnum::MEDIUM->translation();
                                    case  LogLevelEnum::HIGH->value:
                                        return LogLevelEnum::HIGH->translation();
                                    case  LogLevelEnum::CRITICAL->value:
                                        return LogLevelEnum::CRITICAL->translation();
                                }
                            }),
                        TextEntry::make('created_at')->label(__('filament\activities_page.when'))
                            ->getStateUsing(function (Activity $activity) {
                                return verta($activity->created_at, 'Asia/Tehran');
                                }),
                    ])->columns(),

                    Section::make(__('filament\activities_page.subject_details'))->schema([
                        TextEntry::make('subject_type')
                            ->label(__('filament\activities_page.subject_type')),
                        TextEntry::make('subject_id')
                            ->label(__('filament\activities_page.subject_id')),
                        KeyValueEntry::make('properties.old')
                            ->keyLabel(__('filament\dashboard.key'))
                            ->valueLabel(__('filament\dashboard.value'))
                            ->label(__('filament\dashboard.old')),
                        KeyValueEntry::make('properties.attributes')
                            ->keyLabel(__('filament\dashboard.key'))
                            ->valueLabel(__('filament\dashboard.value'))
                            ->label(__('filament\dashboard.new')),
                    ])->hidden(fn (Activity $activity)=> $activity->subject === null)->columns(),
                ]),
            ])
            ->filters([
                Filter::make(__('filament\activities_page.event_subject'))
                    ->query(fn(Builder $query) => $query->where('subject_id', '!=', null)),
                Filter::make(__('filament\activities_page.log_search'))
                    ->query(fn(Builder $query) => $query->where('log_name', 'HTTP SEARCH')),
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
