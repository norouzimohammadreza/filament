<?php

namespace App\Filament\Resources\TransactionResource\Pages;

use App\Filament\Resources\TransactionResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;

class CreateTransaction extends CreateRecord
{
    protected static string $resource = TransactionResource::class;
    public function getTitle(): string|Htmlable
    {
        return __('filament\transaction.create_transaction');
    }

    protected function getRedirectUrl() :string
    {
        return $this->getResource()::getUrl('index');
    }
}
