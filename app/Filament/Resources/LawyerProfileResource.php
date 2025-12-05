<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LawyerProfileResource\Pages;
use App\Models\LawyerProfile;
use Filament\Actions;
use Filament\Forms;
use Filament\Schemas\Components\Section as SchemasSection;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class LawyerProfileResource extends Resource
{
    protected static ?string $model = LawyerProfile::class;

    protected static ?string $navigationLabel = 'Avukat Profilleri';

    public static function getNavigationIcon(): ?string
    {
        return 'heroicon-o-briefcase';
    }

    protected static ?string $modelLabel = 'Avukat Profili';

    protected static ?string $pluralModelLabel = 'Avukat Profilleri';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                SchemasSection::make('Avukat Bilgileri')
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->label('Avukat')
                            ->relationship('user', 'name', fn ($query) => $query->where('role', 'LAWYER'))
                            ->searchable()
                            ->preload()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->disabled(fn ($record) => $record !== null)
                            ->dehydrated()
                            ->live()
                            ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                                if ($state) {
                                    $user = \App\Models\User::find($state);
                                    if ($user) {
                                        $set('email', $user->email);
                                        $set('phone', $user->phone);
                                    }
                                } else {
                                    $set('email', null);
                                    $set('phone', null);
                                }
                            }),
                        Forms\Components\TextInput::make('email')
                            ->label('E-posta')
                            ->disabled()
                            ->dehydrated(false),
                        Forms\Components\TextInput::make('phone')
                            ->label('Telefon')
                            ->disabled()
                            ->dehydrated(false),
                    ])
                    ->columns(2),
                SchemasSection::make('Profil Bilgileri')
                    ->schema([
                        Forms\Components\TagsInput::make('specializations')
                            ->label('Uzmanlık Alanları')
                            ->placeholder('Uzmanlık alanı ekle'),
                        Forms\Components\Textarea::make('bio')
                            ->label('Biyografi')
                            ->rows(4)
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('bar_number')
                            ->label('Baro Numarası')
                            ->maxLength(255),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(true),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Avukat')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('bar_number')
                    ->label('Baro No')
                    ->searchable(),
                Tables\Columns\TextColumn::make('specializations')
                    ->label('Uzmanlıklar')
                    ->badge()
                    ->separator(','),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLawyerProfiles::route('/'),
            'create' => Pages\CreateLawyerProfile::route('/create'),
            'edit' => Pages\EditLawyerProfile::route('/{record}/edit'),
        ];
    }
}

