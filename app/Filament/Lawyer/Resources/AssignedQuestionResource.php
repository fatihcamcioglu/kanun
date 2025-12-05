<?php

namespace App\Filament\Lawyer\Resources;

use App\Filament\Lawyer\Resources\AssignedQuestionResource\Pages;
use App\Filament\Lawyer\Resources\AssignedQuestionResource\RelationManagers\MessagesRelationManager;
use App\Models\LegalQuestion;
use Filament\Actions;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class AssignedQuestionResource extends Resource
{
    protected static ?string $model = LegalQuestion::class;

    protected static ?string $navigationLabel = 'Bana Atanan Sorular';

    protected static ?string $modelLabel = 'Soru';

    protected static ?string $pluralModelLabel = 'Sorular';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\TextInput::make('title')
                    ->label('Başlık')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('category_id')
                    ->label('Kategori')
                    ->relationship('category', 'name')
                    ->required(),
                Forms\Components\Textarea::make('question_body')
                    ->label('Soru')
                    ->required()
                    ->rows(5),
                Forms\Components\Select::make('status')
                    ->label('Durum')
                    ->options([
                        'waiting_assignment' => 'Atama Bekliyor',
                        'waiting_lawyer_answer' => 'Avukat Cevabı Bekliyor',
                        'answered' => 'Cevaplandı',
                        'closed' => 'Kapalı',
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                // Only show questions assigned to the current lawyer
                return $query->where('assigned_lawyer_id', auth()->id());
            })
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Başlık')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Kategori')
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Müşteri')
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
                        'waiting_lawyer_answer' => 'Cevap Bekliyor',
                        'answered' => 'Cevaplandı',
                        'closed' => 'Kapalı',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('asked_at')
                    ->label('Sorulma Tarihi')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Durum')
                    ->options([
                        'waiting_assignment' => 'Atama Bekliyor',
                        'waiting_lawyer_answer' => 'Avukat Cevabı Bekliyor',
                        'answered' => 'Cevaplandı',
                        'closed' => 'Kapalı',
                    ]),
            ])
            ->actions([
                Actions\ViewAction::make()
                    ->label('Görüntüle'),
            ])
            ->defaultSort('asked_at', 'desc');
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
            'index' => Pages\ListAssignedQuestions::route('/'),
            'ratings' => Pages\ListRatings::route('/ratings'),
            'view' => Pages\ViewAssignedQuestion::route('/{record}'),
        ];
    }
}

