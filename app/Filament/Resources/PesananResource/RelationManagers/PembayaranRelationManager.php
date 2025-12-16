<?php

namespace App\Filament\Resources\PesananResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PembayaranRelationManager extends RelationManager
{
    protected static string $relationship = 'pembayaran';

    protected static ?string $title = 'Detail Pembayaran';

    public function form(Form $form): Form
    {
        // Form di sini untuk melihat detail atau konfirmasi pembayaran manual
        return $form
            ->schema([
                Forms\Components\Select::make('status_pembayaran')
                    ->options([
                        'pending' => 'Pending',
                        'sukses' => 'Sukses',
                        'gagal' => 'Gagal',
                        'kadaluarsa' => 'Kadaluarsa',
                        'refund' => 'Refund',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('metode_pembayaran')
                    ->disabled(),
                Forms\Components\TextInput::make('jumlah_dibayar')
                    ->numeric()
                    ->prefix('Rp')
                    ->disabled(),
                Forms\Components\DateTimePicker::make('tanggal_pembayaran')
                    ->label('Waktu Pembayaran'),
                Forms\Components\TextInput::make('id_transaksi_gateway')
                    ->label('ID Transaksi Gateway')
                    ->disabled(),
                Forms\Components\FileUpload::make('bukti_pembayaran')
                    ->image()
                    ->directory('bukti-pembayaran'),
            ]);
    }

    public function table(Table $table): Table
    {
        // Karena relasi hasOne, tabel ini hanya akan menampilkan satu baris
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                Tables\Columns\TextColumn::make('metode_pembayaran'),
                Tables\Columns\TextColumn::make('status_pembayaran')
                    ->badge()
                    ->color(fn (?string $state): string => match ($state) {
                        'pending' => 'warning',
                        'sukses' => 'success',
                        'gagal' => 'danger',
                        'kadaluarsa' => 'gray',
                        default => 'secondary',
                    }),
                Tables\Columns\TextColumn::make('jumlah_dibayar')->numeric()->prefix('Rp'),
                Tables\Columns\TextColumn::make('tanggal_pembayaran')->dateTime(),
                Tables\Columns\ImageColumn::make('bukti_pembayaran')->label('Bukti Bayar'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make(), // Pembayaran dibuat bersamaan pesanan
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()->label('Konfirmasi'), // Untuk konfirmasi manual
            ]);
    }

    // Menonaktifkan fitur create dan delete karena terkait langsung dengan pesanan
    public function canCreate(): bool { return false; }
    public function canDelete(\Illuminate\Database\Eloquent\Model $record): bool { return false; }
}