<?php

namespace App\Filament\Resources\TransactionResource\Pages;

use App\Filament\Resources\TransactionResource;
use App\Filament\Trait\GlobalSearchQueriesLogTrait;
use App\Filament\Trait\TableSearchQueriesLogTrait;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTransactions extends ListRecords
{
    use GlobalSearchQueriesLogTrait, TableSearchQueriesLogTrait;
    protected static string $resource = TransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label(__('filament\transaction.new_transaction')),
        ];
    }
}
