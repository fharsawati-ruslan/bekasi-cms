<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class LaporanTransaksiBiaya extends Page
{
    protected static ?string $navigationGroup = 'Laporan';

    protected static ?string $navigationLabel = 'Laporan Transaksi & Biaya';

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';

    protected static ?int $navigationSort = 1;

    protected static string $view = 'filament.pages.laporan-transaksi-biaya';
}
