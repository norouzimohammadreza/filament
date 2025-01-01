<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use App\Filament\Resources\LogResource;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;

class LogsRelationManager extends RelationManager
{
    protected static string $relationship = 'logs';

    public static function getTitle(\Illuminate\Database\Eloquent\Model $ownerRecord, string $pageClass): string
    {
        return __('filament/dashboard.log_settings');
    }

    public function table(Table $table): Table
    {
        return LogResource::table($table);
    }
}
