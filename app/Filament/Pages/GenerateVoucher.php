<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class GenerateVoucher extends Page
{
    protected static ?string $navigationGroup = 'Voucher';

    protected static ?string $navigationLabel = 'Generate Voucher';

    protected static ?string $navigationIcon = 'heroicon-o-bolt';

    protected static ?int $navigationSort = 2;

    protected static string $view = 'filament.pages.generate-voucher';
}
