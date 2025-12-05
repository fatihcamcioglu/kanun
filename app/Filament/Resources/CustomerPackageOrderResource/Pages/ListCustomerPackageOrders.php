<?php

namespace App\Filament\Resources\CustomerPackageOrderResource\Pages;

use App\Filament\Resources\CustomerPackageOrderResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCustomerPackageOrders extends ListRecords
{
    protected static string $resource = CustomerPackageOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Yeni Sipariş'),
        ];
    }
}

