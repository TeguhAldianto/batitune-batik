<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KategoriProdukResource\Pages;
use App\Filament\Resources\KategoriProdukResource\RelationManagers;
use App\Models\KategoriProduk;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str; 

class KategoriProdukResource extends Resource
{
    protected static ?string $model = KategoriProduk::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    protected static ?string $navigationGroup = 'Manajemen Produk';

    protected static ?string $recordTitleAttribute = 'nama_kategori';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
            Forms\Components\TextInput::make('nama_kategori')
                ->required()
                ->maxLength(255)
                ->live(onBlur: true) 
                ->afterStateUpdated(fn (Forms\Set $set, ?string $state) => $set('slug', Str::slug($state))),
            Forms\Components\TextInput::make('slug')
                ->required()
                ->maxLength(255)
                ->unique(KategoriProduk::class, 'slug', ignoreRecord: true), // Validasi unik
            Forms\Components\Textarea::make('deskripsi_kategori')
                ->columnSpanFull(), // Agar field ini memenuhi lebar form
        ]);
    }
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('nama_kategori')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable(),
                Tables\Columns\TextColumn::make('produks_count')->counts('produks')
                    ->label('Jumlah Produk')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListKategoriProduks::route('/'),
            'create' => Pages\CreateKategoriProduk::route('/create'),
            'view' => Pages\ViewKategoriProduk::route('/{record}'),
            'edit' => Pages\EditKategoriProduk::route('/{record}/edit'),
        ];
    }
}
