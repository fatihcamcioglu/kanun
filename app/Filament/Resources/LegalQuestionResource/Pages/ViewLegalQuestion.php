<?php

namespace App\Filament\Resources\LegalQuestionResource\Pages;

use App\Filament\Resources\LegalQuestionResource;
use App\Filament\Forms\Components\HtmlView;
use Filament\Actions;
use Filament\Forms;
use Filament\Schemas\Components\Section as SchemasSection;
use Filament\Schemas\Schema;
use Filament\Resources\Pages\ViewRecord;

class ViewLegalQuestion extends ViewRecord
{
    protected static string $resource = LegalQuestionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->label('Düzenle'),
        ];
    }

    public function mount(int | string $record): void
    {
        parent::mount($record);
        
        // Load relationships for display
        $this->record->load(['user', 'category', 'assignedLawyer', 'files']);
    }


    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                SchemasSection::make('Soru Bilgileri')
                    ->schema([
                        HtmlView::make('question_details')
                            ->label('')
                            ->html(view('filament.components.question-details', ['record' => $this->record])->render()),
                    ]),
                
                SchemasSection::make('Sesli Soru')
                    ->schema([
                        HtmlView::make('voice_player')
                            ->label('')
                            ->html(view('filament.components.audio-player', ['record' => $this->record])->render()),
                    ])
                    ->visible(fn () => $this->record->voice_path)
                    ->collapsible(),
                
                SchemasSection::make('Eklenen Dosyalar')
                    ->schema([
                        HtmlView::make('files_display')
                            ->label('')
                            ->html(view('filament.components.question-files', ['record' => $this->record])->render()),
                    ])
                    ->visible(fn () => $this->record->files && $this->record->files->count() > 0)
                    ->collapsible(),
            ]);
    }
}

