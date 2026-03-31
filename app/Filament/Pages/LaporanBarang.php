<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class LaporanBarang extends Page
{
    protected static ?string $navigationGroup = 'Laporan';

    protected static ?string $navigationLabel = 'Laporan Barang';

    protected static ?string $navigationIcon = 'heroicon-o-cube';

    protected static ?int $navigationSort = 2;

    protected static string $view = 'filament.pages.laporan-barang';
}
