<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerPackageOrderResource\Pages;
use App\Models\CustomerPackageOrder;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class CustomerPackageOrderResource extends Resource
{
    protected static ?string $model = CustomerPackageOrder::class;

    protected static ?string $navigationLabel = 'Siparişler';

    public static function getNavigationIcon(): ?string
    {
        return 'heroicon-o-shopping-cart';
    }

    protected static ?string $modelLabel = 'Sipariş';

    protected static ?string $pluralModelLabel = 'Siparişler';

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
                Forms\Components\Select::make('package_id')
                    ->label('Paket')
                    ->relationship('package', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('status')
                    ->label('Durum')
                    ->options([
                        'pending_payment' => 'Ödeme Bekliyor',
                        'paid' => 'Ödendi',
                        'cancelled' => 'İptal Edildi',
                        'expired' => 'Süresi Doldu',
                    ])
                    ->required(),
                Forms\Components\Select::make('payment_method')
                    ->label('Ödeme Yöntemi')
                    ->options([
                        'card' => 'Kredi Kartı',
                        'bank_transfer' => 'Havale/EFT',
                    ]),
                Forms\Components\Select::make('payment_status')
                    ->label('Ödeme Durumu')
                    ->options([
                        'waiting' => 'Bekliyor',
                        'success' => 'Başarılı',
                        'failed' => 'Başarısız',
                    ])
                    ->required(),
                Forms\Components\DateTimePicker::make('paid_at')
                    ->label('Ödeme Tarihi'),
                Forms\Components\DateTimePicker::make('starts_at')
                    ->label('Başlangıç Tarihi'),
                Forms\Components\DateTimePicker::make('expires_at')
                    ->label('Bitiş Tarihi'),
                Forms\Components\TextInput::make('remaining_question_count')
                    ->label('Kalan Soru Hakkı')
                    ->numeric()
                    ->required(),
                Forms\Components\TextInput::make('remaining_voice_count')
                    ->label('Kalan Ses Hakkı')
                    ->numeric()
                    ->required(),
                Forms\Components\FileUpload::make('bank_transfer_receipt_path')
                    ->label('Havale Makbuzu')
                    ->directory('bank-receipts')
                    ->visibility('private'),
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
                Tables\Columns\TextColumn::make('package.name')
                    ->label('Paket')
                    ->sortable(),
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
                Tables\Columns\TextColumn::make('payment_method')
                    ->label('Ödeme Yöntemi')
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'card' => 'Kredi Kartı',
                        'bank_transfer' => 'Havale/EFT',
                        default => '-',
                    }),
                Tables\Columns\TextColumn::make('payment_status')
                    ->label('Ödeme Durumu')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'waiting' => 'warning',
                        'success' => 'success',
                        'failed' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'waiting' => 'Bekliyor',
                        'success' => 'Başarılı',
                        'failed' => 'Başarısız',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('remaining_question_count')
                    ->label('Kalan Soru')
                    ->sortable(),
                Tables\Columns\TextColumn::make('expires_at')
                    ->label('Bitiş Tarihi')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Durum')
                    ->options([
                        'pending_payment' => 'Ödeme Bekliyor',
                        'paid' => 'Ödendi',
                        'cancelled' => 'İptal Edildi',
                        'expired' => 'Süresi Doldu',
                    ]),
                Tables\Filters\SelectFilter::make('payment_method')
                    ->label('Ödeme Yöntemi')
                    ->options([
                        'card' => 'Kredi Kartı',
                        'bank_transfer' => 'Havale/EFT',
                    ]),
                Tables\Filters\SelectFilter::make('payment_status')
                    ->label('Ödeme Durumu')
                    ->options([
                        'waiting' => 'Bekliyor',
                        'success' => 'Başarılı',
                        'failed' => 'Başarısız',
                    ]),
            ])
            ->actions([
                Actions\Action::make('approve_bank_transfer')
                    ->label('Havaleyi Onayla')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(function (CustomerPackageOrder $record) {
                        $record->update([
                            'status' => 'paid',
                            'payment_status' => 'success',
                            'paid_at' => now(),
                            'starts_at' => now(),
                            'expires_at' => now()->addDays($record->package->validity_days),
                            'remaining_question_count' => $record->package->question_quota,
                            'remaining_voice_count' => $record->package->voice_quota,
                        ]);
                        
                        // Log activity
                        \App\Services\ActivityLogService::logOrderApproval($record);
                    })
                    ->visible(fn (CustomerPackageOrder $record) => 
                        $record->payment_method === 'bank_transfer' && 
                        $record->payment_status === 'waiting' &&
                        $record->bank_transfer_receipt_path !== null
                    ),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCustomerPackageOrders::route('/'),
            'create' => Pages\CreateCustomerPackageOrder::route('/create'),
            'view' => Pages\ViewCustomerPackageOrder::route('/{record}'),
            'edit' => Pages\EditCustomerPackageOrder::route('/{record}/edit'),
        ];
    }
}

