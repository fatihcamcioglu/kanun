<?php

namespace App\Filament\Resources\VideoResource\Pages;

use App\Filament\Resources\VideoResource;
use Filament\Resources\Pages\CreateRecord;

class CreateVideo extends CreateRecord
{
    protected static string $resource = VideoResource::class;

    protected function afterCreate(): void
    {
        // Log video publication if active
        if ($this->record->is_active) {
            \App\Services\ActivityLogService::logVideoPublication($this->record);
        }
    }
}

