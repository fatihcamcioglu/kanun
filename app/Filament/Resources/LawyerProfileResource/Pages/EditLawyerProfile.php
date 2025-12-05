<?php

namespace App\Filament\Resources\LawyerProfileResource\Pages;

use App\Filament\Resources\LawyerProfileResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLawyerProfile extends EditRecord
{
    protected static string $resource = LawyerProfileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->label('Sil'),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $lawyerProfile = $this->record;
        
        if ($lawyerProfile && $lawyerProfile->user) {
            $data['email'] = $lawyerProfile->user->email;
            $data['phone'] = $lawyerProfile->user->phone;
        }
        
        return $data;
    }
}

