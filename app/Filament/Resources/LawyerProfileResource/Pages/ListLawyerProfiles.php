<?php

namespace App\Filament\Resources\LawyerProfileResource\Pages;

use App\Filament\Resources\LawyerProfileResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLawyerProfiles extends ListRecords
{
    protected static string $resource = LawyerProfileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Yeni Avukat Profili'),
        ];
    }
}

