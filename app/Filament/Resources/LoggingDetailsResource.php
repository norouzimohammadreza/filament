<?php

namespace App\Filament\Resources;

use App\Enums\LogDetailsAsModelEnum;
use App\Enums\LogLevelEnum;
use App\Filament\Resources\LoggingDetailsResource\Pages;
use App\Models\Category;
use App\Models\ModelRecordLogSetting;
use App\Models\Post;
use App\Models\Tag;
use App\Models\Transaction;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class LoggingDetailsResource extends Resource
{
    protected static ?string $model = ModelRecordLogSetting::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    public static function getNavigationGroup(): ?string
    {
        return __('filament\dashboard.log_settings');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament\dashboard.model_instance_log_settings');
    }
    public static function getPluralModelLabel(): string
    {
        return __('filament\model_record_log_setting.model_record_log_setting');
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\MorphToSelect::make('model')
                    ->label(__('filament\model_record_log_setting.model'))
                    ->types([
                        Forms\Components\MorphToSelect\Type::make(Post::class)->titleAttribute('title'),
                        Forms\Components\MorphToSelect\Type::make(User::class)->titleAttribute('name'),
                        Forms\Components\MorphToSelect\Type::make(Tag::class)->titleAttribute('name'),
                        Forms\Components\MorphToSelect\Type::make(Category::class)->titleAttribute('name'),
                        Forms\Components\MorphToSelect\Type::make(Transaction::class)->titleAttribute('description'),
                    ])
                    ->disabledOn('edit')
                    ->required(),
                Forms\Components\Select::make('logging_level')
                    ->label(__('filament\model_record_log_setting.level'))
                    ->options([
                        LogLevelEnum::LOW->value => LogLevelEnum::LOW->translation(),
                        LogLevelEnum::MEDIUM->value => LogLevelEnum::MEDIUM->translation(),
                        LogLevelEnum::HIGH->value => LogLevelEnum::HIGH->translation(),
                        LogLevelEnum::CRITICAL->value => LogLevelEnum::CRITICAL->translation(),
                    ])->required(),
                Forms\Components\Select::make('is_enabled')
                    ->label(__('filament\model_record_log_setting.enabled'))
                    ->options([
                        1 =>  __('enums.enabled.enabled'),
                        0 =>  __('enums.enabled.disabled'),
                    ])->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('model_type')
                    ->label(__('filament\model_record_log_setting.model_type'))
                    ->getStateUsing(function (ModelRecordLogSetting $record) {
                        $modelString = explode('\\', $record->model_type);
                        return $modelString[2];
                    }),
                Tables\Columns\TextColumn::make('model_id')
                    ->label(__('filament\model_record_log_setting.model_id')),
                Tables\Columns\TextColumn::make('logging_level')
                    ->label(__('filament\model_record_log_setting.level'))
                    ->getStateUsing(function (ModelRecordLogSetting $record) {
                        switch ($record->logging_level) {
                            case LogLevelEnum::LOW->value:
                                return LogLevelEnum::LOW->translation();
                            case LogLevelEnum::MEDIUM->value:
                                return LogLevelEnum::MEDIUM->translation();
                            case LogLevelEnum::HIGH->value:
                                return LogLevelEnum::HIGH->translation();
                            case LogLevelEnum::CRITICAL->value:
                                return LogLevelEnum::CRITICAL->translation();
                            default:
                                return 'Unknown';
                        }
                    }),
                Tables\Columns\TextColumn::make('is_enabled')
                    ->label(__('filament\model_record_log_setting.enabled'))
                    ->getStateUsing(function (ModelRecordLogSetting $record) {
                        switch ($record->is_enabled) {
                            case 1:
                                return __('enums.enabled.enabled');
                            case 0:
                                return __('enums.enabled.disabled');
                            default:
                                return 'Unknown';
                        }
                    }),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListLoggingDetails::route('/'),
            'create' => Pages\CreateLoggingDetails::route('/create'),
            'edit' => Pages\EditLoggingDetails::route('/{record}/edit'),
        ];
    }
}
