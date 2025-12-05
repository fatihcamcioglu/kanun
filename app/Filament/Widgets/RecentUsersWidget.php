<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentUsersWidget extends BaseWidget
{
    protected static ?int $sort = 2;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                User::query()
                    ->latest()
                    ->limit(10)
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Ad Soyad')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('E-posta')
                    ->searchable(),
                Tables\Columns\TextColumn::make('role')
                    ->label('Rol')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'ADMIN' => 'danger',
                        'LAWYER' => 'info',
                        'CUSTOMER' => 'success',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'ADMIN' => 'Admin',
                        'LAWYER' => 'Avukat',
                        'CUSTOMER' => 'Müşteri',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Kayıt Tarihi')
                    ->dateTime()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->heading('Son 10 Üye');
    }
}

