<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LegalQuestionResource\Pages;
use App\Filament\Resources\LegalQuestionResource\RelationManagers\MessagesRelationManager;
use App\Models\LegalQuestion;
use App\Models\User;
use App\Notifications\LawyerAssignedToCustomer;
use App\Notifications\QuestionAssignedToLawyer;
use Filament\Actions;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class LegalQuestionResource extends Resource
{
    protected static ?string $model = LegalQuestion::class;

    protected static ?string $navigationLabel = 'Hukuki Sorular';

    public static function getNavigationIcon(): ?string
    {
        return 'heroicon-o-chat-bubble-left-right';
    }

    protected static ?string $modelLabel = 'Soru';

    protected static ?string $pluralModelLabel = 'Sorular';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\Select::make('user_id')
                    ->label('Müşteri')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('order_id')
                    ->label('Sipariş')
                    ->relationship('order', 'id')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('category_id')
                    ->label('Kategori')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('assigned_lawyer_id')
                    ->label('Atanan Avukat')
                    ->relationship('assignedLawyer', 'name', fn (Builder $query) => $query->where('role', 'LAWYER'))
                    ->searchable()
                    ->preload(),
                Forms\Components\TextInput::make('title')
                    ->label('Başlık')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('question_body')
                    ->label('Soru İçeriği')
                    ->required()
                    ->rows(5),
                Forms\Components\TextInput::make('voice_path')
                    ->label('Sesli Soru Dosyası')
                    ->disabled()
                    ->dehydrated(false)
                    ->visible(fn ($record) => $record && $record->voice_path)
                    ->formatStateUsing(fn ($state) => $state ? 'Ses dosyası mevcut' : 'Yok'),
                Forms\Components\Select::make('status')
                    ->label('Durum')
                    ->options([
                        'waiting_assignment' => 'Atama Bekliyor',
                        'waiting_lawyer_answer' => 'Avukat Cevabı Bekliyor',
                        'answered' => 'Cevaplandı',
                        'closed' => 'Kapatıldı',
                    ])
                    ->required(),
                Forms\Components\DateTimePicker::make('asked_at')
                    ->label('Sorulma Tarihi'),
                Forms\Components\DateTimePicker::make('answered_at')
                    ->label('Cevaplanma Tarihi'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Müşteri')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('title')
                    ->label('Başlık')
                    ->searchable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Kategori')
                    ->sortable(),
                Tables\Columns\TextColumn::make('assignedLawyer.name')
                    ->label('Atanan Avukat')
                    ->formatStateUsing(fn ($state) => $state ?? 'Atanmadı')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Durum')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'waiting_assignment' => 'warning',
                        'waiting_lawyer_answer' => 'info',
                        'answered' => 'success',
                        'closed' => 'gray',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'waiting_assignment' => 'Atama Bekliyor',
                        'waiting_lawyer_answer' => 'Avukat Cevabı Bekliyor',
                        'answered' => 'Cevaplandı',
                        'closed' => 'Kapatıldı',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('asked_at')
                    ->label('Sorulma Tarihi')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('answered_at')
                    ->label('Cevaplanma Tarihi')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Durum')
                    ->options([
                        'waiting_assignment' => 'Atama Bekliyor',
                        'waiting_lawyer_answer' => 'Avukat Cevabı Bekliyor',
                        'answered' => 'Cevaplandı',
                        'closed' => 'Kapatıldı',
                    ]),
                Tables\Filters\SelectFilter::make('assigned_lawyer_id')
                    ->label('Atanan Avukat')
                    ->relationship('assignedLawyer', 'name')
                    ->searchable()
                    ->preload(),
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
                    })
                    ->visible(fn (LegalQuestion $record) => $record->status === 'waiting_assignment'),
                Actions\Action::make('close_question')
                    ->label('Soruyu Kapat')
                    ->icon('heroicon-o-lock-closed')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Soruyu Kapat')
                    ->modalDescription('Bu soruyu kapatmak istediğinize emin misiniz?')
                    ->action(function (LegalQuestion $record) {
                        $record->update([
                            'status' => 'closed',
                            'closed_at' => now(),
                        ]);
                        $record->refresh();
                        
                        // Log activity
                        \App\Services\ActivityLogService::logQuestionClosure($record);
                        
                        \Filament\Notifications\Notification::make()
                            ->success()
                            ->title('Soru kapatıldı')
                            ->body('Soru başarıyla kapatıldı.')
                            ->send();
                    })
                    ->visible(fn (LegalQuestion $record) => $record->status !== 'closed'),
                Actions\EditAction::make()
                    ->label('Düzenle'),
                Actions\ViewAction::make()
                    ->label('Görüntüle'),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make()
                        ->label('Sil'),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            MessagesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLegalQuestions::route('/'),
            'create' => Pages\CreateLegalQuestion::route('/create'),
            'ratings' => Pages\ListRatings::route('/ratings'),
            'view' => Pages\ViewLegalQuestion::route('/{record}'),
            'edit' => Pages\EditLegalQuestion::route('/{record}/edit'),
        ];
    }
}

