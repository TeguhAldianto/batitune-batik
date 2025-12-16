<?php

namespace App\Filament\Resources\PesananResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Filament\Tables\Columns\ImageColumn;


class DetailPesanansRelationManager extends RelationManager
{
    protected static string $relationship = 'detailPesanans';

    // Opsional, untuk judul tabel di Relation Manager
    protected static ?string $title = 'Item Pesanan';

    public function form(Form $form): Form
    {
        // Biasanya item pesanan tidak diedit dari sini, tapi hanya dilihat
        // Atau jika diizinkan, pastikan logika update total harga pesanan juga berjalan
        return $form
            ->schema([
                Forms\Components\Select::make('produk_id')
                    ->relationship('produk', 'nama_produk')
                    ->searchable()
                    ->preload()
                    ->disabled() // Biasanya tidak diubah
                    ->required(),
                Forms\Components\TextInput::make('nama_produk_saat_pesan')
                    ->label('Nama Produk (Saat Pesan)')
                    ->disabled()
                    ->required(),
                Forms\Components\TextInput::make('harga_produk_saat_pesan')
                    ->numeric()
                    ->prefix('Rp')
                    ->label('Harga Satuan (Saat Pesan)')
                    ->disabled()
                    ->required(),
                Forms\Components\TextInput::make('kuantitas')
                    ->numeric()
                    ->disabled() // Atau bisa diedit dengan konsekuensi update total
                    ->required(),
                Forms\Components\TextInput::make('subtotal_item')
                    ->numeric()
                    ->prefix('Rp')
                    ->label('Subtotal')
                    ->disabled()
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nama_produk_saat_pesan') // Kolom yang dijadikan judul record
            ->columns([
                ImageColumn::make('produk.gambar_produk')->label('Gbr.')
                    ->defaultImageUrl(url('/images/default-placeholder.png')) // Jika tidak ada gambar
                    ->square()->height(40),
                Tables\Columns\TextColumn::make('nama_produk_saat_pesan')->label('Produk'),
                Tables\Columns\TextColumn::make('kuantitas'),
                Tables\Columns\TextColumn::make('harga_produk_saat_pesan')->numeric()->prefix('Rp')->label('Harga Satuan'),
                Tables\Columns\TextColumn::make('subtotal_item')->numeric()->prefix('Rp')->label('Subtotal'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make(), // Mungkin tidak perlu jika item ditambahkan saat checkout
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(), // Hati-hati, akan mempengaruhi total pesanan
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ]);
    }

    // Menonaktifkan Create, Edit, Delete jika hanya untuk tampilan
    public function canCreate(): bool { return false; }
    // public function canEdit(Model $record): bool { return false; }
    // public function canDelete(Model $record): bool { return false; }
    // public function canDeleteAny(): bool { return false; }

}