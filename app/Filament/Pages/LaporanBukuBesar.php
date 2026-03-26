<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class LaporanBukuBesar extends Page
{
    protected static ?string $navigationGroup = 'Laporan';

    protected static ?string $navigationLabel = 'Laporan Buku Besar';

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static ?int $navigationSort = 4;

    protected static string $view = 'filament.pages.laporan-buku-besar';
}
