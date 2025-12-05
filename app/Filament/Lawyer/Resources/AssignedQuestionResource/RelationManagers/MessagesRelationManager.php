<?php

namespace App\Filament\Lawyer\Resources\AssignedQuestionResource\RelationManagers;

use Filament\Actions;
use Filament\Forms;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class MessagesRelationManager extends RelationManager
{
    protected static string $relationship = 'messages';

    protected static ?string $title = 'Mesajlar';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\Textarea::make('message_body')
                    ->label('Mesaj')
                    ->required()
                    ->rows(6)
                    ->placeholder('Mesajınızı yazın...'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('message_body')
            ->columns([
                Tables\Columns\TextColumn::make('sender.name')
                    ->label('Gönderen')
                    ->sortable(),
                Tables\Columns\TextColumn::make('sender_role')
                    ->label('Rol')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'CUSTOMER' => 'Müşteri',
                        'LAWYER' => 'Avukat',
                        'ADMIN' => 'Admin',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('message_body')
                    ->label('Mesaj')
                    ->wrap()
                    ->limit(100),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tarih')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Actions\CreateAction::make()
                    ->label('Mesaj Gönder')
                    ->icon('heroicon-o-paper-airplane')
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['sender_id'] = auth()->id();
                        $data['sender_role'] = 'LAWYER';
                        return $data;
                    })
                    ->after(function ($record) {
                        // If this is the first answer, update question status
                        $question = $this->ownerRecord;
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
                    }),
            ])
            ->actions([
                Actions\EditAction::make()
                    ->label('Düzenle'),
                Actions\DeleteAction::make()
                    ->label('Sil'),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make()
                        ->label('Sil'),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}

