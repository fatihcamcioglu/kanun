<?php

namespace App\Filament\Widgets;

use App\Models\CustomerPackageOrder;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentOrdersWidget extends BaseWidget
{
    protected static ?int $sort = 3;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                CustomerPackageOrder::query()
                    ->with(['user', 'package'])
                    ->latest()
                    ->limit(10)
            )
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Müşteri')
                    ->searchable(),
                Tables\Columns\TextColumn::make('package.name')
                    ->label('Paket')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Durum')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending_payment' => 'warning',
                        'paid' => 'success',
                        'cancelled' => 'danger',
                        'expired' => 'gray',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending_payment' => 'Ödeme Bekliyor',
                        'paid' => 'Ödendi',
                        'cancelled' => 'İptal Edildi',
                        'expired' => 'Süresi Doldu',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('package.price')
                    ->label('Tutar')
                    ->money('TRY')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Sipariş Tarihi')
                    ->dateTime()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->heading('Son 10 Paket Satın Alma');
    }
}

