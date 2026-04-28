<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProdukResource\Pages;
use App\Models\Produk;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

use Filament\Resources\Resource;

class ProdukResource extends Resource
{
    protected static ?string $model = Produk::class;

    protected static ?string $navigationGroup = 'Produk';
    protected static ?string $navigationLabel = 'Produk';
    protected static ?string $pluralLabel = 'Produk';
    protected static ?string $label = 'Produk';
    protected static ?string $navigationIcon = 'heroicon-o-cube';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([

            // ✅ NAMA PRODUK
            TextInput::make('nama')
                ->label('Nama Produk')
                ->required()
                ->maxLength(255),

            // ✅ HARGA
            TextInput::make('harga')
                ->numeric()
                ->required()
                ->prefix('Rp'),

            // ✅ STOK
            TextInput::make('stok')
                ->numeric()
                ->default(0)
                ->required(),

            // ✅ DESKRIPSI
            Textarea::make('deskripsi')
                ->rows(3)
                ->columnSpanFull(),

        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('nama')
                    ->label('Nama Produk')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('harga')
                    ->money('IDR')
                    ->sortable(),

                TextColumn::make('stok')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->label('Tanggal'),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListProduks::route('/'),
            'create' => Pages\CreateProduk::route('/create'),
            'edit' => Pages\EditProduk::route('/{record}/edit'),
        ];
    }
}