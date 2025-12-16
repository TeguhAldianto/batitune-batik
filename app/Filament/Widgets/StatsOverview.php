<?php

namespace App\Filament\Widgets;

use App\Models\Pelanggan;
use App\Models\Pesanan;
use App\Models\Produk;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Penjualan Selesai', 'Rp ' . number_format(Pesanan::where('status_pesanan', 'selesai')->sum('total_keseluruhan')))
                ->description('Total pendapatan dari pesanan yang selesai')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),

            Stat::make('Pesanan Baru (Bulan Ini)', Pesanan::where('created_at', '>=', now()->startOfMonth())->count())
                ->description('Jumlah pesanan yang masuk bulan ini')
                ->descriptionIcon('heroicon-m-shopping-cart')
                ->color('info'),

            Stat::make('Total Pelanggan', Pelanggan::count())
                ->description('Jumlah semua pelanggan yang terdaftar')
                ->descriptionIcon('heroicon-m-users')
                ->color('warning'),
        ];
    }
}