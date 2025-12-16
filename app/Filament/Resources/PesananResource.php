<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PesananResource\Pages;
use App\Filament\Resources\PesananResource\RelationManagers;
use App\Models\Pesanan;
use App\Models\Produk; // Untuk Select di Form Detail Pesanan
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Infolists; // Untuk halaman View
use Filament\Infolists\Infolist;

class PesananResource extends Resource
{
    protected static ?string $model = Pesanan::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    protected static ?string $navigationGroup = 'Manajemen Pesanan';

    public static function form(Form $form): Form
    {
        // Membuat pesanan baru dari admin mungkin tidak umum,
        // Form ini lebih difokuskan untuk mengedit status atau detail pengiriman.
        return $form
            ->schema([
                Forms\Components\Wizard::make([ // Menggunakan Wizard untuk alur multi-step
                    Forms\Components\Wizard\Step::make('Informasi Pesanan')
                        ->schema([
                            Forms\Components\TextInput::make('kode_pesanan')
                                ->disabled()
                                ->dehydrated(false) // Jangan simpan jika disabled
                                ->columnSpanFull(),
                            Forms\Components\Select::make('pelanggan_id')
                                ->relationship('pelanggan.user', 'name') // Asumsi User punya 'name'
                                ->searchable()
                                ->preload()
                                ->disabled()
                                ->dehydrated(false)
                                ->label('Pelanggan'),
                            Forms\Components\Select::make('status_pesanan')
                                ->options([
                                    'menunggu_pembayaran' => 'Menunggu Pembayaran',
                                    'diproses' => 'Diproses',
                                    'dikirim' => 'Dikirim',
                                    'selesai' => 'Selesai',
                                    'dibatalkan' => 'Dibatalkan',
                                ])
                                ->required(),
                            Forms\Components\DateTimePicker::make('tanggal_pesanan')
                                ->disabled()
                                ->dehydrated(false),
                        ])->columns(2),
                    Forms\Components\Wizard\Step::make('Pengiriman')
                        ->schema([
                            Forms\Components\Select::make('alamat_pengiriman_id')
                                ->relationship('alamatPengiriman', 'label_alamat') // Sesuaikan dengan atribut di Alamat
                                ->options(function (Forms\Get $get) {
                                    $pelangganId = $get('pelanggan_id');
                                    if (!$pelangganId) return [];
                                    return \App\Models\Alamat::where('pelanggan_id', $pelangganId)->pluck('alamat_lengkap', 'id');
                                })
                                ->searchable()
                                ->preload()
                                ->disabled()
                                ->dehydrated(false)
                                ->label('Alamat Pengiriman'),
                            Forms\Components\TextInput::make('jasa_pengiriman')
                                ->maxLength(255)
                                ->nullable(),
                            Forms\Components\TextInput::make('no_resi_pengiriman')
                                ->maxLength(255)
                                ->nullable(),
                        ])->columns(2),
                    Forms\Components\Wizard\Step::make('Pembayaran & Total')
                        ->schema([
                            Forms\Components\TextInput::make('total_harga_produk')->numeric()->prefix('Rp')->disabled()->dehydrated(false),
                            Forms\Components\TextInput::make('biaya_pengiriman')->numeric()->prefix('Rp')->disabled()->dehydrated(false),
                            Forms\Components\TextInput::make('diskon')->numeric()->prefix('Rp')->disabled()->dehydrated(false),
                            Forms\Components\TextInput::make('total_keseluruhan')->numeric()->prefix('Rp')->disabled()->dehydrated(false),
                            // Info Pembayaran dari relasi
                            Forms\Components\Placeholder::make('status_pembayaran')
                                ->label('Status Pembayaran')
                                ->content(fn (?Pesanan $record): string => $record?->pembayaran?->status_pembayaran ?? '-'),
                            Forms\Components\Placeholder::make('metode_pembayaran')
                                ->label('Metode Pembayaran')
                                ->content(fn (?Pesanan $record): string => $record?->pembayaran?->metode_pembayaran ?? '-'),

                        ])->columns(2),
                ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kode_pesanan')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('pelanggan.user.name') // Asumsi User punya 'name'
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
                    })
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_keseluruhan')
                    ->numeric()
                    ->prefix('Rp')
                    ->sortable(),
                Tables\Columns\TextColumn::make('pembayaran.status_pembayaran')
                    ->label('Status Bayar')
                    ->badge()
                     ->color(fn (?string $state): string => match ($state) {
                        'pending' => 'warning',
                        'sukses' => 'success',
                        'gagal' => 'danger',
                        'kadaluarsa' => 'gray',
                        default => 'secondary',
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('tanggal_pesanan')
                    ->dateTime()
                    ->sortable(),
            ])

            ->filters([
                Tables\Filters\SelectFilter::make('status_pesanan')
                    ->options([
                        'menunggu_pembayaran' => 'Menunggu Pembayaran',
                        'diproses' => 'Diproses',
                        'dikirim' => 'Dikirim',
                        'selesai' => 'Selesai',
                        'dibatalkan' => 'Dibatalkan',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(), // Hati-hati menghapus pesanan
                // ]),
            ]);
    }

    // Halaman Detail (View) menggunakan Infolist
    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Informasi Pesanan')
                    ->columns(3)
                    ->schema([
                        Infolists\Components\TextEntry::make('kode_pesanan'),
                        Infolists\Components\TextEntry::make('pelanggan.user.name')->label('Pelanggan'),
                        Infolists\Components\TextEntry::make('tanggal_pesanan')->dateTime(),
                        Infolists\Components\TextEntry::make('status_pesanan')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'menunggu_pembayaran' => 'warning',
                                'diproses' => 'info',
                                'dikirim' => 'primary',
                                'selesai' => 'success',
                                'dibatalkan' => 'danger',
                                default => 'gray',
                            }),
                        Infolists\Components\TextEntry::make('catatan_pelanggan')->columnSpanFull()->placeholder('Tidak ada catatan.'),
                    ]),
                Infolists\Components\Section::make('Detail Pengiriman')
                    ->columns(2)
                    ->schema([
                        Infolists\Components\TextEntry::make('alamatPengiriman.alamat_lengkap_dengan_label') // Buat accessor di model Alamat
                            ->label('Alamat Pengiriman')->columnSpanFull(),
                        Infolists\Components\TextEntry::make('jasa_pengiriman')->placeholder('Belum diinput.'),
                        Infolists\Components\TextEntry::make('no_resi_pengiriman')->placeholder('Belum diinput.'),
                    ]),
                Infolists\Components\Section::make('Detail Pembayaran dan Total')
                    ->columns(3)
                    ->schema([
                        Infolists\Components\TextEntry::make('total_harga_produk')->numeric()->prefix('Rp'),
                        Infolists\Components\TextEntry::make('biaya_pengiriman')->numeric()->prefix('Rp'),
                        Infolists\Components\TextEntry::make('diskon')->numeric()->prefix('Rp'),
                        Infolists\Components\TextEntry::make('total_keseluruhan')->numeric()->prefix('Rp')->weight('bold'),
                        Infolists\Components\TextEntry::make('pembayaran.metode_pembayaran')->label('Metode Bayar')->placeholder('-'),
                        Infolists\Components\TextEntry::make('pembayaran.status_pembayaran')->label('Status Bayar')
                            ->badge()
                            ->color(fn (?string $state): string => match ($state) {
                                'pending' => 'warning',
                                'sukses' => 'success',
                                'gagal' => 'danger',
                                'kadaluarsa' => 'gray',
                                default => 'secondary',
                            })->placeholder('-'),
                        Infolists\Components\TextEntry::make('pembayaran.tanggal_pembayaran')->dateTime()->label('Tgl. Bayar')->placeholder('-'),
                    ]),
            ]);
    }


    public static function getRelations(): array
    {
        return [
            RelationManagers\DetailPesanansRelationManager::class,
            RelationManagers\PembayaranRelationManager::class, 
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPesanans::route('/'),
            // 'create' => Pages\CreatePesanan::route('/create'), // Biasanya pesanan dibuat oleh pelanggan
            'view' => Pages\ViewPesanan::route('/{record}'),
            'edit' => Pages\EditPesanan::route('/{record}/edit'),
        ];
    }

    // Nonaktifkan tombol create jika pesanan hanya bisa dibuat oleh pelanggan
    public static function canCreate(): bool
    {
        return false;
    }
}