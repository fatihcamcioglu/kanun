<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ActivityLogResource\Pages;
use App\Models\ActivityLog;
use Filament\Actions;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ActivityLogResource extends Resource
{
    protected static ?string $model = ActivityLog::class;

    protected static ?string $navigationLabel = 'Aktivite Günlüğü';

    protected static ?string $modelLabel = 'Aktivite Logu';

    protected static ?string $pluralModelLabel = 'Aktivite Günlükleri';

    protected static bool $shouldRegisterNavigation = true;

    public static function getNavigationIcon(): ?string
    {
        return 'heroicon-o-clipboard-document-list';
    }

    protected static ?int $navigationSort = 99;

    public static function form(Schema $schema): Schema
    {
        // Read-only resource, form is used for viewing details
        return $schema
            ->components([
                \Filament\Forms\Components\Section::make('Aktivite Detayları')
                    ->schema([
                        \Filament\Forms\Components\TextInput::make('user.name')
                            ->label('Kullanıcı')
                            ->default('Sistem')
                            ->disabled(),
                        \Filament\Forms\Components\TextInput::make('action')
                            ->label('İşlem')
                            ->disabled(),
                        \Filament\Forms\Components\Textarea::make('description')
                            ->label('Açıklama')
                            ->disabled()
                            ->columnSpanFull(),
                        \Filament\Forms\Components\TextInput::make('created_at')
                            ->label('Tarih')
                            ->formatStateUsing(fn ($state) => $state?->format('d.m.Y H:i:s'))
                            ->disabled(),
                    ])
                    ->columns(2),
                \Filament\Forms\Components\Section::make('Ek Bilgiler')
                    ->schema([
                        \Filament\Forms\Components\TextInput::make('model_type')
                            ->label('Model Tipi')
                            ->formatStateUsing(fn (?string $state): string => $state ? class_basename($state) : '-')
                            ->disabled(),
                        \Filament\Forms\Components\TextInput::make('model_id')
                            ->label('Model ID')
                            ->disabled(),
                        \Filament\Forms\Components\TextInput::make('ip_address')
                            ->label('IP Adresi')
                            ->default('-')
                            ->disabled(),
                        \Filament\Forms\Components\Textarea::make('user_agent')
                            ->label('Tarayıcı')
                            ->default('-')
                            ->disabled()
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->collapsible()
                    ->collapsed(),
                \Filament\Forms\Components\Section::make('Değişiklikler')
                    ->schema([
                        \Filament\Forms\Components\KeyValue::make('changes')
                            ->label('')
                            ->disabled()
                            ->columnSpanFull(),
                    ])
                    ->visible(fn ($record) => !empty($record->changes))
                    ->collapsible()
                    ->collapsed(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Kullanıcı')
                    ->searchable()
                    ->sortable()
                    ->default('Sistem'),
                Tables\Columns\TextColumn::make('action')
                    ->label('İşlem')
                    ->searchable()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'assign_lawyer' => 'info',
                        'create_package', 'create_faq', 'create_video_category' => 'success',
                        'update_package', 'update_faq', 'update_video' => 'warning',
                        'close_question' => 'danger',
                        'publish_video', 'approve_order' => 'success',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'assign_lawyer' => 'Avukat Ata',
                        'create_package' => 'Paket Oluştur',
                        'update_package' => 'Paket Güncelle',
                        'close_question' => 'Soru Kapat',
                        'publish_video' => 'Video Yayınla',
                        'update_video' => 'Video Güncelle',
                        'create_faq' => 'SSS Oluştur',
                        'update_faq' => 'SSS Güncelle',
                        'create_video_category' => 'Video Kategorisi Oluştur',
                        'approve_order' => 'Sipariş Onayla',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('description')
                    ->label('Açıklama')
                    ->searchable()
                    ->wrap()
                    ->limit(100),
                Tables\Columns\TextColumn::make('model_type')
                    ->label('Model')
                    ->formatStateUsing(fn (?string $state): string => $state ? class_basename($state) : '-')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('model_id')
                    ->label('Model ID')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('ip_address')
                    ->label('IP Adresi')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tarih')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->since()
                    ->description(fn ($record) => $record->created_at?->format('d.m.Y H:i')),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('action')
                    ->label('İşlem')
                    ->options([
                        'assign_lawyer' => 'Avukat Ata',
                        'create_package' => 'Paket Oluştur',
                        'update_package' => 'Paket Güncelle',
                        'close_question' => 'Soru Kapat',
                        'publish_video' => 'Video Yayınla',
                        'update_video' => 'Video Güncelle',
                        'create_faq' => 'SSS Oluştur',
                        'update_faq' => 'SSS Güncelle',
                        'create_video_category' => 'Video Kategorisi Oluştur',
                        'approve_order' => 'Sipariş Onayla',
                    ]),
                Tables\Filters\Filter::make('created_at')
                    ->label('Tarih')
                    ->form([
                        \Filament\Forms\Components\DatePicker::make('created_from')
                            ->label('Başlangıç Tarihi'),
                        \Filament\Forms\Components\DatePicker::make('created_until')
                            ->label('Bitiş Tarihi'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
            ])
            ->actions([
                Actions\ViewAction::make()
                    ->label('Görüntüle'),
            ])
            ->bulkActions([
                // Read-only, no bulk actions
            ])
            ->defaultSort('created_at', 'desc')
            ->poll('30s'); // Auto-refresh every 30 seconds
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListActivityLogs::route('/'),
            'view' => Pages\ViewActivityLog::route('/{record}'),
        ];
    }

    public static function canCreate(): bool
    {
        return false; // Read-only
    }

    public static function canEdit($record): bool
    {
        return false; // Read-only
    }

    public static function canDelete($record): bool
    {
        return false; // Read-only
    }
}
