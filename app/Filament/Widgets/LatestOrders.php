<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\PesananResource;
use App\Models\Pesanan;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestOrders extends BaseWidget
{
    protected static ?int $sort = 3; // Urutan widget di dashboard

    protected int | string | array $columnSpan = 'full'; // Agar widget ini memenuhi lebar dashboard

    public function table(Table $table): Table
    {
        return $table
            ->query(
                // Mengambil 5 pesanan terbaru
                Pesanan::latest()->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('kode_pesanan')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('pelanggan.user.name')
                    ->label('Pelanggan')
                    ->searchable()
                    ->sortable(),
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
                    ->money('IDR')
                    ->sortable(),
            ])
            ->actions([
                // Tambahkan aksi untuk melihat detail pesanan langsung dari widget
                Tables\Actions\Action::make('Lihat')
                    ->url(fn (Pesanan $record): string => PesananResource::getUrl('view', ['record' => $record]))
                    ->icon('heroicon-m-eye'),
            ]);
    }
}