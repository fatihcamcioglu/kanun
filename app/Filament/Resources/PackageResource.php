<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PackageResource\Pages;
use App\Models\Package;
use Filament\Actions;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class PackageResource extends Resource
{
    protected static ?string $model = Package::class;

    protected static ?string $navigationLabel = 'Paketler';

    public static function getNavigationIcon(): ?string
    {
        return 'heroicon-o-cube';
    }

    protected static ?string $modelLabel = 'Paket';

    protected static ?string $pluralModelLabel = 'Paketler';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\TextInput::make('name')
                    ->label('Paket Adı')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, Forms\Set $set) => $set('slug', Str::slug($state))),
                Forms\Components\TextInput::make('slug')
                    ->label('Slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('question_quota')
                    ->label('Soru Kotası')
                    ->numeric()
                    ->required()
                    ->default(0),
                Forms\Components\TextInput::make('voice_quota')
                    ->label('Ses Kotası')
                    ->numeric()
                    ->required()
                    ->default(0),
                Forms\Components\TextInput::make('validity_days')
                    ->label('Geçerlilik Süresi (Gün)')
                    ->numeric()
                    ->required()
                    ->default(30),
                Forms\Components\TextInput::make('price')
                    ->label('Fiyat')
                    ->numeric()
                    ->required()
                    ->prefix('₺')
                    ->step(0.01),
                Forms\Components\TextInput::make('currency')
                    ->label('Para Birimi')
                    ->default('TRY')
                    ->maxLength(3),
                Forms\Components\Toggle::make('is_active')
                    ->label('Aktif')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Paket Adı')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('question_quota')
                    ->label('Soru Kotası')
                    ->sortable(),
                Tables\Columns\TextColumn::make('voice_quota')
                    ->label('Ses Kotası')
                    ->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->label('Fiyat')
                    ->money('TRY')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Oluşturulma')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Aktif')
                    ->placeholder('Tümü')
                    ->trueLabel('Aktif')
                    ->falseLabel('Pasif'),
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
            'index' => Pages\ListPackages::route('/'),
            'create' => Pages\CreatePackage::route('/create'),
            'edit' => Pages\EditPackage::route('/{record}/edit'),
        ];
    }
}

