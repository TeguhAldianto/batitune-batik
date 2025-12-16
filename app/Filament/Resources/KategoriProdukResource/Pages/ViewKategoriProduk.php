<?php

namespace App\Filament\Resources\KategoriProdukResource\Pages;

use App\Filament\Resources\KategoriProdukResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewKategoriProduk extends ViewRecord
{
    protected static string $resource = KategoriProdukResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
