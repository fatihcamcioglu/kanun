<?php

namespace App\Filament\Widgets;

use App\Models\LegalQuestion;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentAnsweredQuestionsWidget extends BaseWidget
{
    protected static ?int $sort = 4;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                LegalQuestion::query()
                    ->where('status', 'answered')
                    ->with(['user', 'category', 'assignedLawyer'])
                    ->latest('answered_at')
                    ->limit(10)
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
                Tables\Columns\TextColumn::make('assignedLawyer.name')
                    ->label('Avukat')
                    ->formatStateUsing(fn ($state) => $state ?? 'Atanmadı'),
                Tables\Columns\TextColumn::make('answered_at')
                    ->label('Cevaplanma Tarihi')
                    ->dateTime()
                    ->sortable(),
            ])
            ->defaultSort('answered_at', 'desc')
            ->heading('Son 10 Cevaplanan Soru')
            ->emptyStateHeading('Henüz cevaplanan soru yok')
            ->emptyStateDescription('Şu anda cevaplanmış soru bulunmamaktadır.');
    }
}

