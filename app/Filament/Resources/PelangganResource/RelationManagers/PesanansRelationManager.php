<?php

namespace App\Filament\Resources\PelangganResource\RelationManagers;

use App\Filament\Resources\PesananResource; // Untuk link ke halaman pesanan
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PesanansRelationManager extends RelationManager
{
    protected static string $relationship = 'pesanans';

    protected static ?string $title = 'Riwayat Pesanan';

    public function form(Form $form): Form
    {
        // Biasanya form di sini tidak digunakan karena pesanan dibuat oleh pelanggan
        return $form
            ->schema([
                Forms\Components\TextInput::make('kode_pesanan')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('kode_pesanan')
            ->columns([
                Tables\Columns\TextColumn::make('kode_pesanan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status_pesanan')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'menunggu_pembayaran' => 'warning',
                        'diproses' => 'info',
                        'dikirim' => 'primary',
                        'selesai' => 'success',
                        'dibatalkan' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('total_keseluruhan')
                    ->numeric()
                    ->prefix('Rp'),
                Tables\Columns\TextColumn::make('tanggal_pesanan')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // CreateAction dinonaktifkan
            ])
            ->actions([
                // Tambahkan Aksi untuk melihat detail pesanan
                Tables\Actions\Action::make('Lihat Detail')
                    ->url(fn ($record): string => PesananResource::getUrl('view', ['record' => $record]))
                    ->icon('heroicon-o-eye'),
            ])
            ->bulkActions([
                //
            ]);
    }

    // Menonaktifkan semua aksi default (create, edit, delete) dari relation manager ini
    // karena manajemen pesanan lebih baik dilakukan di PesananResource utama.
    public function canCreate(): bool { return false; }
    public function canEdit(\Illuminate\Database\Eloquent\Model $record): bool { return false; }
    public function canDelete(\Illuminate\Database\Eloquent\Model $record): bool { return false; }
    public function canDeleteAny(): bool { return false; }
}