<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RoleResource\Pages;
use App\Models\Role;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
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
                            'menu' => $item['menu'] ?? '',
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
                        ->disabled()
                        ->dehydrated(true), // penting biar tetap tersimpan

                    Grid::make(4)->schema([
                        Checkbox::make('view')->label('Lihat'),
                        Checkbox::make('create')->label('Tambah'),
                        Checkbox::make('update')->label('Edit'),
                        Checkbox::make('delete')->label('Hapus'),
                    ]),
                ])

                // 🔥 FIX UTAMA: kalau edit kosong → isi default
                ->afterStateHydrated(function ($component, $state) {
                    if (empty($state)) {
                        $component->state(self::getDefaultMenus());
                    }
                })

                ->default(self::getDefaultMenus())

                ->disableItemCreation()
                ->disableItemDeletion()
                ->columnSpanFull(),
        ]);
    }

    // 🔥 Helper biar rapi & reusable
    protected static function getDefaultMenus(): array
    {
        return collect([
            'Halaman Awal',
            'Transaksi',
            'Member',
            'Tipe Member',
            'Android',
            'Poin',
            'Ekstra Poin',
            'Karyawan',
            'Jabatan',
            'Riwayat Akses',
            'Daftar Biaya',
            'Daftar Pinjaman karyawan',
            'Daftar Gaji karyawan',
            'Transfer',
            'Kas',
            'Laporan Transaksi Dan Biaya',
            'Laporan Barang',
            'Laporan gaji',
            'Laporan Buku Besar',
            'Laporan Laba Rugi',
            'Barang Masuk',
            'Barang Keluar',
            'Stok',
            'Nama Voucher',
            'Generate Voucher',
            'Item',
            'Treatment',
            'Paket',
            'Wilayah',
            'Cabang',
            'Ruangan',
            'Kamar',
            'Pengaturan',
            'Supplier',
            'Bank',
            'Satuan',
            'Tipe Biaya',
            'Tipe Tranfer',
            'Tipe pinjaman',
            'Akses',
            'Developer',
        ])->map(fn ($menu) => [
            'menu' => $menu,
            'view' => false,
            'create' => false,
            'update' => false,
            'delete' => false,
        ])->toArray();
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
