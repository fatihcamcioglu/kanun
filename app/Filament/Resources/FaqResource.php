<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FaqResource\Pages;
use App\Models\Faq;
use Filament\Actions;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class FaqResource extends Resource
{
    protected static ?string $model = Faq::class;

    protected static ?string $navigationLabel = 'Sıkça Sorulan Sorular';

    public static function getNavigationIcon(): ?string
    {
        return 'heroicon-o-question-mark-circle';
    }

    protected static ?string $modelLabel = 'SSS';

    protected static ?string $pluralModelLabel = 'Sıkça Sorulan Sorular';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\Textarea::make('question')
                    ->label('Soru')
                    ->required()
                    ->rows(3)
                    ->maxLength(500)
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('answer')
                    ->label('Cevap')
                    ->required()
                    ->rows(8)
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
                Tables\Columns\TextColumn::make('question')
                    ->label('Soru')
                    ->searchable()
                    ->limit(50)
                    ->wrap(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
                Tables\Columns\TextColumn::make('order')
                    ->label('Sıralama')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Oluşturulma Tarihi')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Güncellenme Tarihi')
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
            ])
            ->defaultSort('order', 'asc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFaqs::route('/'),
            'create' => Pages\CreateFaq::route('/create'),
            'edit' => Pages\EditFaq::route('/{record}/edit'),
        ];
    }
}

