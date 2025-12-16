<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PelangganResource\Pages;
use App\Filament\Resources\PelangganResource\RelationManagers;
use App\Models\Pelanggan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Infolists;
use Filament\Infolists\Infolist;

class PelangganResource extends Resource
{
    protected static ?string $model = Pelanggan::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = 'Manajemen Pengguna';

    // Gunakan accessor di model untuk judul yang lebih baik
    public static function getRecordTitle(?\Illuminate\Database\Eloquent\Model $record): ?string
    {
        return $record->user->name ?? 'Pelanggan';
    }

    public static function form(Form $form): Form
    {
        // Form ini untuk mengedit detail Pelanggan yang sudah ada.
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Akun Pengguna (User)')
                    ->description('Informasi ini diambil dari data User yang terkait.')
                    ->schema([
                        // Field 'user_id' untuk memilih user. Disabled saat edit.
                        Forms\Components\Select::make('user_id')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->disabledOn('edit') // Tidak bisa diubah setelah dibuat
                            ->label('Akun User'),
                    ]),
                Forms\Components\Section::make('Detail Profil Pelanggan')
                    ->schema([
                        Forms\Components\TextInput::make('no_hp')
                            ->tel()
                            ->label('Nomor HP')
                            ->maxLength(255),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('user.name') // Mengambil nama dari relasi user
                    ->label('Nama Pelanggan')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.email') // Mengambil email dari relasi user
                    ->label('Email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('no_hp')
                    ->label('Nomor HP')
                    ->searchable(),
                Tables\Columns\TextColumn::make('pesanans_count')->counts('pesanans')
                    ->label('Jumlah Pesanan')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // Filter untuk pelanggan yang sudah pernah order
                Tables\Filters\Filter::make('pernah_order')
                    ->label('Sudah Pernah Order')
                    ->query(fn (Builder $query): Builder => $query->whereHas('pesanans')),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    // Gunakan Infolist untuk halaman View yang lebih detail
    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Informasi Personal')
                    ->columns(2)
                    ->schema([
                        Infolists\Components\TextEntry::make('user.name')->label('Nama'),
                        Infolists\Components\TextEntry::make('user.email')->label('Email'),
                        Infolists\Components\TextEntry::make('no_hp')->label('Nomor HP'),
                        Infolists\Components\TextEntry::make('user.created_at')->dateTime()->label('Tanggal Terdaftar'),
                    ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\AlamatsRelationManager::class,
            RelationManagers\PesanansRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPelanggans::route('/'),
            'create' => Pages\CreatePelanggan::route('/create'), // Dinonaktifkan
            'view' => Pages\ViewPelanggan::route('/{record}'),
            'edit' => Pages\EditPelanggan::route('/{record}/edit'),
        ];
    }

    // Menonaktifkan tombol "Create"
    public static function canCreate(): bool
    {
        return false;
    }
}