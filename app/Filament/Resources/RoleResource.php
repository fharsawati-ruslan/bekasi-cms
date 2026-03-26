<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RoleResource\Pages;
use App\Models\Role;

use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Toggle;

use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class RoleResource extends Resource
{
    protected static ?string $model = Role::class;

    protected static ?string $navigationLabel = 'Akses';
    protected static ?string $navigationGroup = 'Master';
    protected static ?string $navigationIcon = 'heroicon-o-key';

    public static function form(Form $form): Form
    {
        return $form->schema([

            TextInput::make('name')
                ->label('Nama Akses')
                ->required(),

            Toggle::make('select_all')
                ->label('Pilih Semua')
                ->reactive()
                ->afterStateUpdated(function ($state, Set $set, Get $get) {

                    $menus = collect($get('permissions'))->map(function ($item) use ($state) {
                        return [
                            'menu' => $item['menu'],
                            'view' => $state,
                            'create' => $state,
                            'update' => $state,
                            'delete' => $state,
                        ];
                    })->toArray();

                    $set('permissions', $menus);
                }),

            Repeater::make('permissions')
                ->label('Hak Akses')
                ->schema([

                    TextInput::make('menu')
                        ->disabled(),

                    Grid::make(4)->schema([
                        Checkbox::make('view')->label('Lihat'),
                        Checkbox::make('create')->label('Tambah'),
                        Checkbox::make('update')->label('Edit'),
                        Checkbox::make('delete')->label('Hapus'),
                    ]),
                ])
                ->default([
                    ['menu' => 'Halaman Awal'],
                    ['menu' => 'Transaksi'],
                    ['menu' => 'Member'],
                    ['menu' => 'Tipe Member'],
                    ['menu' => 'Android'],
                    ['menu' => 'Poin'],
                    ['menu' => 'Ekstra Poin'],
                    ['menu' => 'Karyawan'],
                    ['menu' => 'Jabatan'],
                    ['menu' => 'Riwayat Akses'],
                    ['menu' => 'Daftar Biaya'],
                    ['menu' => 'Daftar Pinjaman karyawan'],
                    ['menu' => 'Daftar Gaji karyawan'],
                    ['menu' => 'Transfer'],
                    ['menu' => 'Kas'],
                    ['menu' => 'Laporan Transaksi Dan Biaya'],
                    ['menu' => 'Laporan Barang'],
                    ['menu' => 'Laporan gaji'],
                    ['menu' => 'Laporan Buku Besar'],
                    ['menu' => 'Laporan Laba Rugi'],
                    ['menu' => 'Barang Masuk'],
                    ['menu' => 'Barang Keluar'],
                    ['menu' => 'Stok'],
                    ['menu' => 'Nama Voucher'],
                    ['menu' => 'Generate Voucher'],
                    ['menu' => 'Item'],
                    ['menu' => 'Treatment'],
                    ['menu' => 'Paket'],
                    ['menu' => 'Wilayah'],
                    ['menu' => 'Cabang'],
                    ['menu' => 'Ruangan'],
                    ['menu' => 'Kamar'],
                    ['menu' => 'Pengaturan'],
                    ['menu' => 'Supplier'],
                    ['menu' => 'Bank'],
                    ['menu' => 'Satuan'],
                    ['menu' => 'Tipe Biaya'],
                    ['menu' => 'Tipe Tranfer'],
                    ['menu' => 'Tipe pinjaman'],
                    ['menu' => 'Akses'],
                     ['menu' => 'Developer'],

                    ])
                ->disableItemCreation()
                ->disableItemDeletion(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Akses')
                    ->searchable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRoles::route('/'),
            'create' => Pages\CreateRole::route('/create'),
            'edit' => Pages\EditRole::route('/{record}/edit'),
        ];
    }
}
