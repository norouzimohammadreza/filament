<?php

namespace App\Filament\Resources\TransactionResource\Pages;

use App\Filament\Resources\TransactionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;

class EditTransaction extends EditRecord
{
    protected static string $resource = TransactionResource::class;
    protected function getRedirectUrl() :string
    {
        return $this->getResource()::getUrl('index');
    }
    public function getTitle(): string|Htmlable
    {
        return __('filament\transaction.edit_transaction');
    }
    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()->modalHeading(__('filament\transaction.delete_transaction')),
        ];
    }
}
