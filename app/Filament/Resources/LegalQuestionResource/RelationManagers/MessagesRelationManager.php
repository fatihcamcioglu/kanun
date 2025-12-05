<?php

namespace App\Filament\Resources\LegalQuestionResource\RelationManagers;

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
                    ->label('Mesaj İçeriği')
                    ->required()
                    ->rows(4),
                Forms\Components\FileUpload::make('voice_path')
                    ->label('Ses Dosyası')
                    ->acceptedFileTypes(['audio/*'])
                    ->directory('legal-messages/voice'),
                Forms\Components\FileUpload::make('attachment_path')
                    ->label('Ek Dosya')
                    ->directory('legal-messages/attachments'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('message_body')
            ->columns([
                Tables\Columns\TextColumn::make('sender.name')
                    ->label('Gönderen')
                    ->searchable(),
                Tables\Columns\TextColumn::make('sender_role')
                    ->label('Gönderen Rolü')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'CUSTOMER' => 'Müşteri',
                        'LAWYER' => 'Avukat',
                        'ADMIN' => 'Admin',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('message_body')
                    ->label('Mesaj')
                    ->limit(100)
                    ->wrap(),
                Tables\Columns\IconColumn::make('voice_path')
                    ->label('Ses')
                    ->boolean(),
                Tables\Columns\IconColumn::make('attachment_path')
                    ->label('Ek')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tarih')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Actions\CreateAction::make()
                    ->label('Yeni Mesaj'),
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

