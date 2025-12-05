<?php

namespace App\Filament\Widgets;

use App\Models\LegalQuestion;
use App\Models\User;
use App\Notifications\LawyerAssignedToCustomer;
use App\Notifications\QuestionAssignedToLawyer;
use Filament\Actions;
use Filament\Forms;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class PendingQuestionsWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                LegalQuestion::query()
                    ->where('status', 'waiting_assignment')
                    ->with(['user', 'category'])
                    ->latest()
            )
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Müşteri')
                    ->searchable(),
                Tables\Columns\TextColumn::make('title')
                    ->label('Başlık')
                    ->searchable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Kategori'),
                Tables\Columns\TextColumn::make('asked_at')
                    ->label('Sorulma Tarihi')
                    ->dateTime()
                    ->sortable(),
            ])
            ->actions([
                Actions\Action::make('assign_lawyer')
                    ->label('Avukat Ata')
                    ->icon('heroicon-o-user-plus')
                    ->form([
                        Forms\Components\Select::make('lawyer_id')
                            ->label('Avukat')
                            ->options(User::where('role', 'LAWYER')->pluck('name', 'id'))
                            ->searchable()
                            ->required(),
                    ])
                    ->action(function (LegalQuestion $record, array $data) {
                        $lawyer = User::find($data['lawyer_id']);
                        
                        $record->update([
                            'assigned_lawyer_id' => $data['lawyer_id'],
                            'status' => 'waiting_lawyer_answer',
                        ]);
                        
                        // Refresh record to get updated relationships
                        $record->refresh();
                        
                        // Log activity
                        \App\Services\ActivityLogService::logLawyerAssignment($record, $lawyer);
                        
                        // Send notification to lawyer
                        if ($lawyer && $lawyer->email) {
                            $lawyer->notify(new QuestionAssignedToLawyer($record));
                        }
                        
                        // Send notification to customer
                        if ($record->user && $record->user->email) {
                            $record->user->notify(new LawyerAssignedToCustomer($record));
                        }
                        
                        \Filament\Notifications\Notification::make()
                            ->success()
                            ->title('Avukat atandı')
                            ->body('Soru başarıyla avukata atandı. Bildirimler gönderildi.')
                            ->send();
                    }),
                Actions\Action::make('view')
                    ->label('Görüntüle')
                    ->icon('heroicon-o-eye')
                    ->url(fn (LegalQuestion $record): string => route('filament.admin.resources.legal-questions.view', $record)),
            ])
            ->defaultSort('asked_at', 'desc')
            ->heading('Avukat Ataması Bekleyen Sorular')
            ->description('En üstte gösterilen sorulara avukat ataması yapılmalıdır.')
            ->emptyStateHeading('Avukat ataması bekleyen soru yok')
            ->emptyStateDescription('Şu anda atama bekleyen soru bulunmamaktadır.');
    }
}

