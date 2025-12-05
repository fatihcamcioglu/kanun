<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VideoResource\Pages;
use App\Models\Video;
use Filament\Actions;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class VideoResource extends Resource
{
    protected static ?string $model = Video::class;

    protected static ?string $navigationLabel = 'Videolar';

    public static function getNavigationIcon(): ?string
    {
        return 'heroicon-o-video-camera';
    }

    protected static ?string $modelLabel = 'Video';

    protected static ?string $pluralModelLabel = 'Videolar';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\Select::make('video_category_id')
                    ->label('Video Kategorisi')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\TextInput::make('title')
                    ->label('Başlık')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('short_description')
                    ->label('Kısa Açıklama')
                    ->rows(3)
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('cover_image_path')
                    ->label('Kapak Resmi')
                    ->image()
                    ->disk('public')
                    ->directory('videos/cover')
                    ->maxSize(2048)
                    ->imageEditor()
                    ->imageEditorAspectRatios([
                        '16:9',
                    ])
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('vimeo_link')
                    ->label('Vimeo Linki')
                    ->required()
                    ->url()
                    ->placeholder('https://vimeo.com/123456789')
                    ->helperText('Vimeo video linkini girin (örn: https://vimeo.com/123456789)')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('order')
                    ->label('Sıralama')
                    ->numeric()
                    ->default(0)
                    ->required(),
                Forms\Components\Toggle::make('is_active')
                    ->label('Aktif')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('cover_image_path')
                    ->label('Kapak')
                    ->disk('public')
                    ->circular()
                    ->defaultImageUrl(url('/images/placeholder-video.png')),
                Tables\Columns\TextColumn::make('title')
                    ->label('Başlık')
                    ->searchable()
                    ->sortable()
                    ->limit(50)
                    ->wrap(),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Kategori')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('order')
                    ->label('Sıralama')
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
                Tables\Filters\SelectFilter::make('video_category_id')
                    ->label('Kategori')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload(),
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
            ])
            ->defaultSort('order', 'asc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVideos::route('/'),
            'create' => Pages\CreateVideo::route('/create'),
            'edit' => Pages\EditVideo::route('/{record}/edit'),
        ];
    }
}

