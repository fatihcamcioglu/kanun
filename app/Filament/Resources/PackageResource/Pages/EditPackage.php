<?php

namespace App\Filament\Resources\PackageResource\Pages;

use App\Filament\Resources\PackageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPackage extends EditRecord
{
    protected static string $resource = PackageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->label('Sil'),
        ];
    }

    protected function beforeSave(): void
    {
        // Store original values before update
        $this->originalValues = $this->record->getOriginal();
    }

    protected function afterSave(): void
    {
        if (isset($this->originalValues)) {
            \App\Services\ActivityLogService::logPackageUpdate($this->record, $this->originalValues);
        }
    }
}

