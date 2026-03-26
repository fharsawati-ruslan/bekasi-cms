<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class LaporanLabaRugi extends Page
{
    protected static ?string $navigationGroup = 'Laporan';

    protected static ?string $navigationLabel = 'Laporan Laba Rugi';

    protected static ?string $navigationIcon = 'heroicon-o-presentation-chart-line';

    protected static ?int $navigationSort = 5;

    protected static string $view = 'filament.pages.laporan-laba-rugi';
}
