<?php

namespace App\Filament\Resources\VideoResource\Pages;

use App\Filament\Resources\VideoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditVideo extends EditRecord
{
    protected static string $resource = VideoResource::class;

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
            // Log video publication if status changed from inactive to active
            if (!($this->originalValues['is_active'] ?? false) && $this->record->is_active) {
                \App\Services\ActivityLogService::logVideoPublication($this->record);
            } else {
                // Log general update
                \App\Services\ActivityLogService::logVideoUpdate($this->record, $this->originalValues);
            }
        }
    }
}

