<?php

namespace App\Filament\Resources\ProdukResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UlasansRelationManager extends RelationManager
{
    protected static string $relationship = 'ulasans';

    // Opsional: Ganti judul tabel di relation manager
    protected static ?string $title = 'Ulasan Produk';

    public function form(Form $form): Form
    {
        // Ulasan biasanya tidak dibuat/diedit dari panel admin untuk produk,
        // tapi oleh pelanggan. Jadi form ini mungkin tidak terlalu kompleks
        // atau bahkan bisa di-disable untuk create/edit.
        return $form
            ->schema([
                Forms\Components\Select::make('pelanggan_id')
                    ->relationship('pelanggan.user', 'name') // Asumsi relasi pelanggan ke user untuk nama
                    ->searchable()
                    ->preload()
                    ->disabled() // Biasanya tidak diubah
                    ->label('Pelanggan'),
                Forms\Components\TextInput::make('rating')
                    ->numeric()
                    ->minValue(1)
                    ->maxValue(5)
                    ->disabled(), // Biasanya tidak diubah
                Forms\Components\Textarea::make('komentar')
                    ->columnSpanFull()
                    ->disabled(), // Biasanya tidak diubah
                Forms\Components\Toggle::make('is_approved')
                    ->label('Disetujui'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id') // Atau 'komentar' jika lebih deskriptif
            ->columns([
                Tables\Columns\TextColumn::make('pelanggan.user.name')->label('Pelanggan')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('rating')
                    ->badge()
                    ->color(fn (int $state): string => match ($state) {
                        1, 2 => 'danger',
                        3 => 'warning',
                        4, 5 => 'success',
                        default => 'gray',
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('komentar')->limit(50)->searchable(),
                Tables\Columns\BooleanColumn::make('is_approved')->label('Disetujui')->sortable(),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->label('Tanggal')->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('rating')
                    ->options([
                        1 => '1 Bintang',
                        2 => '2 Bintang',
                        3 => '3 Bintang',
                        4 => '4 Bintang',
                        5 => '5 Bintang',
                    ]),
                Tables\Filters\TernaryFilter::make('is_approved')
                    ->label('Status Persetujuan'),
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make(), // Ulasan biasanya dibuat oleh pelanggan
            ])
            ->actions([
                Tables\Actions\ViewAction::make(), // Untuk melihat detail ulasan
                Tables\Actions\EditAction::make(), // Mungkin hanya untuk mengubah status 'is_approved'
                // Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ]);
    }

    // Menonaktifkan tombol create jika ulasan hanya dari pelanggan
    // public function canCreate(): bool { return false; }
}