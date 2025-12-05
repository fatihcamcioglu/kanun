<?php

namespace App\Filament\Resources\CustomerPackageOrderResource\Pages;

use App\Filament\Resources\CustomerPackageOrderResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewCustomerPackageOrder extends ViewRecord
{
    protected static string $resource = CustomerPackageOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->label('Düzenle'),
        ];
    }
}

