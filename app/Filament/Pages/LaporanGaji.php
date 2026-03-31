<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class LaporanGaji extends Page
{
    protected static ?string $navigationGroup = 'Laporan';

    protected static ?string $navigationLabel = 'Laporan Gaji';

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static ?int $navigationSort = 3;

    protected static string $view = 'filament.pages.laporan-gaji';
}
