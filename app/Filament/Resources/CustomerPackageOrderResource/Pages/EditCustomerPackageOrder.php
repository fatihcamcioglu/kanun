<?php

namespace App\Filament\Resources\CustomerPackageOrderResource\Pages;

use App\Filament\Resources\CustomerPackageOrderResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCustomerPackageOrder extends EditRecord
{
    protected static string $resource = CustomerPackageOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make()
                ->label('Görüntüle'),
            Actions\DeleteAction::make()
                ->label('Sil'),
        ];
    }
}

