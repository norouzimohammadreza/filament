<?php

namespace App\Filament\Resources\LoggingDetailsResource\Pages;

use App\Filament\Resources\LoggingDetailsResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;

class CreateLoggingDetails extends CreateRecord
{
    protected static string $resource = LoggingDetailsResource::class;
    public function getTitle(): string|Htmlable
    {
        return __('filament\model_record_log_setting.create_model_record');
    }
    protected function getRedirectUrl() :string
    {
        return $this->getResource()::getUrl('index');
    }
}
