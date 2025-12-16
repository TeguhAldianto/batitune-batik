<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UlasanResource\Pages;
use App\Filament\Resources\UlasanResource\RelationManagers;
use App\Models\Ulasan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UlasanResource extends Resource
{
    protected static ?string $model = Ulasan::class;

    protected static ?string $navigationIcon = 'heroicon-o-star';

    protected static ?string $navigationGroup = 'Manajemen Batik';

    public static function form(Form $form): Form
    {
        // Form di sini lebih untuk moderasi (mengubah status 'is_approved')
        // daripada membuat atau mengedit konten ulasan.
        return $form
            ->schema([
                Forms\Components\Select::make('pelanggan_id')
                    ->relationship('pelanggan.user', 'name')
                    ->disabled()
                    ->label('Pelanggan'),
                Forms\Components\Select::make('produk_id')
                    ->relationship('produk', 'nama_produk')
                    ->disabled()
                    ->label('Produk'),
                Forms\Components\TextInput::make('rating')
                    ->disabled()
                    ->numeric(),
                Forms\Components\Textarea::make('komentar')
                    ->disabled()
                    ->columnSpanFull(),
                Forms\Components\Toggle::make('is_approved')
                    ->required()
                    ->label('Tampilkan Ulasan Ini?'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('produk.nama_produk')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('pelanggan.user.name')
                    ->label('Pelanggan')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('rating')
                    ->badge()
                    ->color(fn (int $state): string => match ($state) {
                        1, 2 => 'danger',
                        3 => 'warning',
                        4, 5 => 'success',
                        default => 'gray',
                    })
                    ->sortable(),
                Tables\Columns\BooleanColumn::make('is_approved')
                    ->label('Disetujui')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()->label('Moderasi'),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUlasans::route('/'),
            // 'create' => Pages\CreateUlasan::route('/create'), // Tidak perlu karena ulasan dari pelanggan
            'view' => Pages\ViewUlasan::route('/{record}'),
            'edit' => Pages\EditUlasan::route('/{record}/edit'),
        ];
    }

    // Menonaktifkan tombol "Create" karena admin tidak seharusnya membuat ulasan
    public static function canCreate(): bool
    {
        return false;
    }
}