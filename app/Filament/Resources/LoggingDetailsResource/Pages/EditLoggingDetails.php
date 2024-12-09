<?php

namespace App\Filament\Resources\LoggingDetailsResource\Pages;

use App\Filament\Resources\LoggingDetailsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLoggingDetails extends EditRecord
{
    protected static string $resource = LoggingDetailsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
