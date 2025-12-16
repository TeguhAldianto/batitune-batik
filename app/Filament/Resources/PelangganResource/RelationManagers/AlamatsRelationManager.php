<?php

namespace App\Filament\Resources\PelangganResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AlamatsRelationManager extends RelationManager
{
    protected static string $relationship = 'alamats';

    // Opsional: Ganti judul tabel di relation manager
    protected static ?string $title = 'Daftar Alamat';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('label_alamat')
                    ->required()
                    ->maxLength(255)
                    ->label('Label Alamat (Contoh: Rumah, Kantor)'),
                Forms\Components\TextInput::make('nama_penerima')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('no_hp_penerima')
                    ->tel() // Tipe input telepon
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('alamat_lengkap')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('kota')->required(),
                Forms\Components\TextInput::make('provinsi')->required(),
                Forms\Components\TextInput::make('kode_pos')->required()->numeric(),
                Forms\Components\Toggle::make('is_alamat_utama')
                    ->required()
                    ->label('Jadikan Alamat Utama?'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('label_alamat')
            ->columns([
                Tables\Columns\TextColumn::make('label_alamat')->searchable(),
                Tables\Columns\TextColumn::make('nama_penerima')->searchable(),
                Tables\Columns\TextColumn::make('alamat_lengkap')->limit(40),
                Tables\Columns\IconColumn::make('is_alamat_utama')
                    ->boolean()
                    ->label('Utama'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}