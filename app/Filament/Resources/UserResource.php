<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Actions;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationLabel = 'Kullanıcılar';

    public static function getNavigationIcon(): ?string
    {
        return 'heroicon-o-users';
    }

    protected static ?string $modelLabel = 'Kullanıcı';

    protected static ?string $pluralModelLabel = 'Kullanıcılar';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\TextInput::make('name')
                    ->label('Ad Soyad')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->label('E-posta')
                    ->email()
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('password')
                    ->label('Şifre')
                    ->password()
                    ->required(fn (string $context): bool => $context === 'create')
                    ->minLength(8)
                    ->dehydrated(fn ($state) => filled($state))
                    ->dehydrateStateUsing(fn ($state) => bcrypt($state)),
                Forms\Components\Select::make('role')
                    ->label('Rol')
                    ->options([
                        'ADMIN' => 'Admin',
                        'LAWYER' => 'Avukat',
                        'CUSTOMER' => 'Müşteri',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('phone')
                    ->label('Telefon')
                    ->tel()
                    ->maxLength(255),
                Forms\Components\Select::make('status')
                    ->label('Durum')
                    ->options([
                        'active' => 'Aktif',
                        'inactive' => 'Pasif',
                        'suspended' => 'Askıya Alınmış',
                    ])
                    ->default('active')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Ad Soyad')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('E-posta')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('role')
                    ->label('Rol')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'ADMIN' => 'danger',
                        'LAWYER' => 'warning',
                        'CUSTOMER' => 'success',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'ADMIN' => 'Admin',
                        'LAWYER' => 'Avukat',
                        'CUSTOMER' => 'Müşteri',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('phone')
                    ->label('Telefon')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Durum')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'inactive' => 'gray',
                        'suspended' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'active' => 'Aktif',
                        'inactive' => 'Pasif',
                        'suspended' => 'Askıya Alınmış',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Oluşturulma')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('role')
                    ->label('Rol')
                    ->options([
                        'ADMIN' => 'Admin',
                        'LAWYER' => 'Avukat',
                        'CUSTOMER' => 'Müşteri',
                    ]),
                Tables\Filters\SelectFilter::make('status')
                    ->label('Durum')
                    ->options([
                        'active' => 'Aktif',
                        'inactive' => 'Pasif',
                        'suspended' => 'Askıya Alınmış',
                    ]),
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
            ]);
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}

