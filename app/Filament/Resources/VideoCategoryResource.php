<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VideoCategoryResource\Pages;
use App\Models\VideoCategory;
use Filament\Actions;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class VideoCategoryResource extends Resource
{
    protected static ?string $model = VideoCategory::class;

    protected static ?string $navigationLabel = 'Video Kategorileri';

    public static function getNavigationIcon(): ?string
    {
        return 'heroicon-o-folder';
    }

    protected static ?string $modelLabel = 'Video Kategorisi';

    protected static ?string $pluralModelLabel = 'Video Kategorileri';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\TextInput::make('name')
                    ->label('Kategori Adı')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, $set) => $set('slug', Str::slug($state))),
                Forms\Components\TextInput::make('slug')
                    ->label('Slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->disabled()
                    ->dehydrated()
                    ->helperText('Slug otomatik olarak oluşturulur'),
                Forms\Components\Textarea::make('description')
                    ->label('Açıklama')
                    ->rows(3),
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
                    ->label('Kategori Adı')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('slug')
                    ->label('Slug')
                    ->searchable(),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVideoCategories::route('/'),
            'create' => Pages\CreateVideoCategory::route('/create'),
            'edit' => Pages\EditVideoCategory::route('/{record}/edit'),
        ];
    }
}

