<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BarangMasukResource\Pages;
use App\Models\BarangMasuk;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

use Filament\Resources\Resource;

class BarangMasukResource extends Resource
{
    protected static ?string $model = BarangMasuk::class;

    protected static ?string $navigationGroup = 'Gudang';
    protected static ?string $navigationLabel = 'Barang Masuk';
    protected static ?string $pluralLabel = 'Barang Masuk';
    protected static ?string $label = 'Barang Masuk';
    protected static ?string $navigationIcon = 'heroicon-o-arrow-down-tray';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([

            // ✅ ID TRANSAKSI AUTO
            TextInput::make('kode_transaksi')
                ->label('Id Transaksi')
                ->default(fn () => 'PST/BM/' . date('ymd') . '/' . str_pad(rand(1,99999),5,'0',STR_PAD_LEFT))
                ->disabled()
                ->dehydrated(),

            // ✅ PEMBAYARAN
            Select::make('pembayaran')
                ->placeholder('-- Pilih Pembayaran --')
                ->options([
                    'cash' => 'Cash',
                    'transfer' => 'Transfer',
                ])
                ->required(),

            // ✅ SUPPLIER
            Select::make('supplier_id')
                ->label('Supplier')
                ->placeholder('-- Pilih Supplier --')
                ->relationship('supplier', 'nama')
                ->searchable()
                ->required(),

            // ✅ DETAIL BARANG
            Repeater::make('items')
                ->relationship()
                ->label('Barang')
                ->schema([

                    Select::make('barang_id')
                        ->label('Barang')
                        ->relationship('barang', 'nama')
                        ->searchable()
                        ->required(),

                    TextInput::make('qty')
                        ->numeric()
                        ->required()
                        ->live(),

                    TextInput::make('harga')
                        ->numeric()
                        ->required()
                        ->live(),

                    TextInput::make('subtotal')
                        ->disabled()
                        ->numeric()
                        ->dehydrated()
                        ->afterStateUpdated(function ($state, callable $set, callable $get) {
                            $set('subtotal', $get('qty') * $get('harga'));
                        }),
                ])
                ->createItemButtonLabel('Tambah Barang')
                ->columns(4),

        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('kode_transaksi')->label('Id Transaksi'),
                TextColumn::make('total')->money('IDR'),
                TextColumn::make('pembayaran'),
                TextColumn::make('supplier.nama')->label('Supplier'),
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
            'index' => Pages\ListBarangMasuks::route('/'),
            'create' => Pages\CreateBarangMasuk::route('/create'),
            'edit' => Pages\EditBarangMasuk::route('/{record}/edit'),
        ];
    }
}