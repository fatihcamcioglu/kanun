<?php

namespace App\Filament\Lawyer\Resources\AssignedQuestionResource\Pages;

use App\Filament\Lawyer\Resources\AssignedQuestionResource;
use App\Models\LegalMessage;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Pages\ViewRecord;

class ViewAssignedQuestion extends ViewRecord
{
    protected static string $resource = AssignedQuestionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('answer')
                ->label('Cevap Ver')
                ->icon('heroicon-o-chat-bubble-left-right')
                ->form([
                    Forms\Components\Textarea::make('message_body')
                        ->label('Cevabınız')
                        ->required()
                        ->rows(6)
                        ->placeholder('Soruyu cevaplayın...'),
                ])
                ->action(function (array $data) {
                    $question = $this->record;
                    
                    // Create message
                    LegalMessage::create([
                        'legal_question_id' => $question->id,
                        'sender_id' => auth()->id(),
                        'sender_role' => 'LAWYER',
                        'message_body' => $data['message_body'],
                    ]);

                    // If this is the first answer, update question status
                    $wasFirstAnswer = ($question->status === 'waiting_lawyer_answer' || $question->status === 'waiting_assignment') && !$question->answered_at;
                    
                    if ($wasFirstAnswer) {
                        $question->update([
                            'status' => 'answered',
                            'answered_at' => now(),
                        ]);
                    }
                    
                    // Refresh to get updated relationships
                    $question->refresh();
                    
                    // Send notification to customer - HER CEVAP İÇİN
                    if ($question->user && $question->user->email) {
                        $question->user->notify(new \App\Notifications\QuestionAnswered($question));
                    }

                    // Show success notification
                    \Filament\Notifications\Notification::make()
                        ->success()
                        ->title('Cevap gönderildi')
                        ->body('Cevabınız başarıyla gönderildi.')
                        ->send();
                })
                ->modalHeading('Soruyu Cevapla')
                ->modalSubmitActionLabel('Gönder')
                ->modalCancelActionLabel('İptal'),
        ];
    }
}

