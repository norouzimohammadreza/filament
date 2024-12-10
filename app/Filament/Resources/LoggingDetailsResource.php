<?php

namespace App\Filament\Resources;

use App\Enums\LogDetailsAsModelEnum;
use App\Enums\LogLevelEnum;
use App\Filament\Resources\LoggingDetailsResource\Pages;
use App\Models\LoggingInfo;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class LoggingDetailsResource extends Resource
{
    protected static ?string $model = LoggingInfo::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('model_type')
                    ->relationship('')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('model_type')
                    ->getStateUsing(function (LoggingInfo $record) {
                        $modelString = explode('\\', $record->model_type);
                        return $modelString[2];
                    }),
                Tables\Columns\TextColumn::make('model_id'),
                Tables\Columns\TextColumn::make('level')
                    ->getStateUsing(function (LoggingInfo $record) {
                        switch ($record->level) {
                            case LogLevelEnum::LOW->value:
                                return 'Low';
                            case LogLevelEnum::MEDIUM->value:
                                return 'Medium';
                            case LogLevelEnum::HIGH->value:
                                return 'High';
                            case LogLevelEnum::CRITICAL->value:
                                return 'Critical';
                            default:
                                return 'Unknown';
                        }
                    }),
                Tables\Columns\TextColumn::make('details')
                    ->getStateUsing(function (LoggingInfo $record) {
                        switch ($record->details) {
                            case LogDetailsAsModelEnum::ENABLED->value:
                                return 'Enabled';
                            case LogDetailsAsModelEnum::DISABLED->value:
                                return 'Disabled';
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
