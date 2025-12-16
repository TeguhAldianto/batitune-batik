<?php

namespace App\Filament\Widgets;

use App\Models\Pesanan;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class SalesChart extends ChartWidget
{
    protected static ?string $heading = 'Grafik Pesanan (30 Hari Terakhir)';

    protected static ?int $sort = 2; // Urutan widget di dashboard, setelah StatsOverview
    
    protected int | string | array $columnSpan = 'full'; // Agar widget ini memenuhi lebar dashboard

    protected function getData(): array
    {
        // Mengambil data tren dari model Pesanan
        $data = Trend::model(Pesanan::class)
            ->between(
                start: now()->subDays(30), // Mulai dari 30 hari yang lalu
                end: now(),               // Sampai hari ini
            )
            ->perDay() // Data dikelompokkan per hari
            ->count();  // Yang dihitung adalah jumlah pesanan (count)

        return [
            'datasets' => [
                [
                    'label' => 'Pesanan Masuk',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate), // Data untuk sumbu Y (jumlah pesanan)
                    'backgroundColor' => 'rgba(54, 162, 235, 0.2)',
                    'borderColor' => 'rgba(54, 162, 235, 1)',
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date), // Data untuk sumbu X (tanggal)
        ];
    }

    protected function getType(): string
    {
        return 'line'; // Tipe grafik: 'line', 'bar', 'pie', dll.
    }
}