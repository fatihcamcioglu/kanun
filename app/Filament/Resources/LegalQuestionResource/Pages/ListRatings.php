<?php

namespace App\Filament\Resources\LegalQuestionResource\Pages;

use App\Filament\Resources\LegalQuestionResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ListRatings extends ListRecords
{
    protected static string $resource = LegalQuestionResource::class;

    public function getTitle(): string
    {
        return 'Oylar';
    }

    protected function getTableQuery(): Builder
    {
        return parent::getTableQuery()
            ->whereNotNull('lawyer_rating')
            ->where('status', 'closed')
            ->with(['assignedLawyer', 'user', 'category']);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('assignedLawyer.name')
                    ->label('Avukat Adı')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('title')
                    ->label('Soru')
                    ->searchable()
                    ->limit(50)
                    ->tooltip(fn ($record) => $record->title),
                Tables\Columns\TextColumn::make('lawyer_rating')
                    ->label('Puan')
                    ->badge()
                    ->color(fn (int $state): string => match (true) {
                        $state >= 4 => 'success',
                        $state >= 3 => 'warning',
                        default => 'danger',
                    })
                    ->formatStateUsing(fn (int $state): string => $state . '/5')
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Müşteri')
                    ->searchable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Kategori')
                    ->sortable(),
                Tables\Columns\TextColumn::make('rated_at')
                    ->label('Oylama Tarihi')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('closed_at')
                    ->label('Kapanış Tarihi')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('assigned_lawyer_id')
                    ->label('Avukat')
                    ->relationship('assignedLawyer', 'name')
                    ->searchable()
                    ->preload(),
            ])
            ->defaultSort('rated_at', 'desc')
            ->emptyStateHeading('Henüz oy verilmemiş');
    }
}

