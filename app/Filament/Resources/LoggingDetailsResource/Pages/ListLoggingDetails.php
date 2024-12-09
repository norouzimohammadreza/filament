<?php

namespace App\Filament\Resources\LoggingDetailsResource\Pages;

use App\Filament\Resources\LoggingDetailsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLoggingDetails extends ListRecords
{
    protected static string $resource = LoggingDetailsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
