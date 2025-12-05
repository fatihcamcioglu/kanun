<?php

namespace App\Filament\Lawyer\Resources\AssignedQuestionResource\Pages;

use App\Filament\Lawyer\Resources\AssignedQuestionResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ListRatings extends ListRecords
{
    protected static string $resource = AssignedQuestionResource::class;

    public function getTitle(): string
    {
        return 'Aldığım Oylar';
    }

    protected function getTableQuery(): Builder
    {
        return parent::getTableQuery()
            ->where('assigned_lawyer_id', auth()->id())
            ->whereNotNull('lawyer_rating')
            ->where('status', 'closed')
            ->with(['user', 'category']);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
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
            ->defaultSort('rated_at', 'desc')
            ->emptyStateHeading('Henüz oy almamışsınız');
    }
}

