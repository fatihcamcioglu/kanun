<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NotificationLogResource\Pages;
use App\Models\NotificationLog;
use Filament\Actions;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class NotificationLogResource extends Resource
{
    protected static ?string $model = NotificationLog::class;

    protected static ?string $navigationLabel = 'Bildirim Logları';

    protected static ?string $modelLabel = 'Bildirim Logu';

    protected static ?string $pluralModelLabel = 'Bildirim Logları';

    protected static bool $shouldRegisterNavigation = true;

    public static function getNavigationIcon(): ?string
    {
        return 'heroicon-o-bell';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\Select::make('user_id')
                    ->label('Kullanıcı')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('channel')
                    ->label('Kanal')
                    ->options([
                        'mail' => 'E-posta',
                        'sms' => 'SMS',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('type')
                    ->label('Tip')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('status')
                    ->label('Durum')
                    ->options([
                        'sent' => 'Gönderildi',
                        'failed' => 'Başarısız',
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Kullanıcı')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('channel')
                    ->label('Kanal')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'mail' => 'E-posta',
                        'sms' => 'SMS',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('type')
                    ->label('Tip')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Durum')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'sent' => 'success',
                        'failed' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'sent' => 'Gönderildi',
                        'failed' => 'Başarısız',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tarih')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('channel')
                    ->label('Kanal')
                    ->options([
                        'mail' => 'E-posta',
                        'sms' => 'SMS',
                    ]),
                Tables\Filters\SelectFilter::make('status')
                    ->label('Durum')
                    ->options([
                        'sent' => 'Gönderildi',
                        'failed' => 'Başarısız',
                    ]),
            ])
            ->actions([
                Actions\ViewAction::make(),
            ])
            ->bulkActions([
                //
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListNotificationLogs::route('/'),
            'view' => Pages\ViewNotificationLog::route('/{record}'),
        ];
    }
}

