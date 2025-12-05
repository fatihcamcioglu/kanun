<?php

namespace App\Filament\Resources\LegalCategoryResource\Pages;

use App\Filament\Resources\LegalCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLegalCategories extends ListRecords
{
    protected static string $resource = LegalCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Yeni Kategori'),
        ];
    }
}

