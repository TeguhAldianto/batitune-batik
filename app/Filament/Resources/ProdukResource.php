<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProdukResource\Pages;
use App\Filament\Resources\ProdukResource\RelationManagers;
use App\Models\Produk;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

// use App\Models\Ulasan; // Import ini tidak perlu jika tidak digunakan secara langsung di sini

class ProdukResource extends Resource
{
    protected static ?string $model = Produk::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';

    protected static ?string $navigationGroup = 'Manajemen Produk';

    protected static ?string $recordTitleAttribute = 'nama_produk';

    public static function form(Form $form): Form
    {
        // Bagian form Anda sudah benar
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Dasar Produk')
                    ->columns(2)
                    ->schema([
                        Forms\Components\Select::make('kategori_produk_id')
                            ->relationship('kategoriProduk', 'nama_kategori')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->label('Kategori Produk'),
                        Forms\Components\TextInput::make('nama_produk')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (Forms\Set $set, ?string $state) => $set('slug', Str::slug($state))),
                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(Produk::class, 'slug', ignoreRecord: true),
                        Forms\Components\RichEditor::make('deskripsi')
                            ->required()
                            ->columnSpanFull(),
                    ]),
                Forms\Components\Section::make('Detail Harga dan Stok')
                    ->columns(3)
                    ->schema([
                        Forms\Components\TextInput::make('harga')
                            ->required()
                            ->numeric()
                            ->prefix('Rp')
                            ->minValue(0),
                        Forms\Components\TextInput::make('stok')
                            ->required()
                            ->numeric()
                            ->minValue(0),
                        Forms\Components\TextInput::make('berat_gram')
                            ->numeric()
                            ->nullable()
                            ->suffix('gram')
                            ->minValue(0),
                    ]),
                Forms\Components\Section::make('Atribut Batik')
                    ->columns(2)
                    ->collapsible()
                    ->schema([
                        Forms\Components\TextInput::make('motif_batik')->maxLength(255)->nullable(),
                        Forms\Components\TextInput::make('jenis_kain')->maxLength(255)->nullable(),
                        Forms\Components\TextInput::make('ukuran')->maxLength(255)->nullable(),
                        Forms\Components\TextInput::make('warna_dominan')->maxLength(255)->nullable(),
                    ]),
                Forms\Components\Section::make('Media')
                    ->schema([
                        Forms\Components\FileUpload::make('gambar_produk')
                            ->image()
                            ->directory('produk-images')
                            ->imageEditor()
                            ->nullable()
                            ->label('Gambar Produk'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('gambar_produk')->square()->height(60),
                Tables\Columns\TextColumn::make('nama_produk')
                    ->searchable()
                    ->sortable()
                    ->description(fn (Produk $record): string => Str::limit($record->deskripsi, 40)),
                Tables\Columns\TextColumn::make('kategoriProduk.nama_kategori')
                    ->searchable()
                    ->sortable()
                    ->badge(),
                
                // --- BAGIAN YANG DIPERBAIKI ---
                Tables\Columns\TextColumn::make('harga')
                    ->money('IDR') // Gunakan ->money() untuk menampilkan format Rupiah
                    ->sortable(),
                // -----------------------------

                Tables\Columns\TextColumn::make('stok')
                    ->sortable(),
                Tables\Columns\BooleanColumn::make('is_visible')
                    ->label('Tampil')
                    ->getStateUsing(fn (Produk $record): bool => $record->stok > 0),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('kategori_produk_id')
                    ->relationship('kategoriProduk', 'nama_kategori')
                    ->label('Filter Kategori'),
                Tables\Filters\Filter::make('stok_rendah')
                    ->label('Stok Rendah (< 10)')
                    ->query(fn (Builder $query): Builder => $query->where('stok', '<', 10)),
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
            RelationManagers\UlasansRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProduks::route('/'),
            'create' => Pages\CreateProduk::route('/create'),
            'view' => Pages\ViewProduk::route('/{record}'),
            'edit' => Pages\EditProduk::route('/{record}/edit'),
        ];
    }
}