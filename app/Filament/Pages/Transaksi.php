<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Transaksi extends Page
{
    protected static ?string $navigationLabel = 'Transaksi';

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    protected static ?int $navigationSort = -1; // 🔥 bikin paling atas

    protected static ?string $navigationGroup = null; // ⬅️ ini penting (biar gak masuk group)

    protected static string $view = 'filament.pages.transaksi';
}
