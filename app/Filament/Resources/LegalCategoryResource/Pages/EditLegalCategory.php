<?php

namespace App\Filament\Resources\LegalCategoryResource\Pages;

use App\Filament\Resources\LegalCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLegalCategory extends EditRecord
{
    protected static string $resource = LegalCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->label('Sil'),
        ];
    }
}

