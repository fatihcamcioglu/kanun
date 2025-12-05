<?php

namespace App\Filament\Resources\LegalQuestionResource\Pages;

use App\Filament\Resources\LegalQuestionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLegalQuestion extends EditRecord
{
    protected static string $resource = LegalQuestionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make()
                ->label('Görüntüle'),
            Actions\DeleteAction::make()
                ->label('Sil'),
        ];
    }

    protected function beforeSave(): void
    {
        // Store original status before update
        $this->originalStatus = $this->record->getOriginal('status');
    }

    protected function afterSave(): void
    {
        // Log if status changed to closed
        if (isset($this->originalStatus) && 
            $this->originalStatus !== 'closed' && 
            $this->record->status === 'closed') {
            \App\Services\ActivityLogService::logQuestionClosure($this->record);
        }
    }
}

