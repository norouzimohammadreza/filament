<?php

namespace App\Filament\Resources\LoggingDetailsResource\Pages;

use App\Filament\Resources\LoggingDetailsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;

class EditLoggingDetails extends EditRecord
{
    protected static string $resource = LoggingDetailsResource::class;
    public function getTitle(): string|Htmlable
    {
        return __('filament\model_record_log_setting.edit_model_record');
    }
    protected function getRedirectUrl() :string
    {
        return $this->getResource()::getUrl('index');
    }
    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->modalHeading(__('filament\model_record_log_setting.delete_model_record')),
        ];
    }
}
