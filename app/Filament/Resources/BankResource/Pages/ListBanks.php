<?php

namespace App\Filament\Resources\BankResource\Pages;

use App\Filament\Resources\BankResource;
use Filament\Resources\Pages\ListRecords;

class ListBanks extends ListRecords
{
    protected static string $resource = BankResource::class;

    // 🔥 HAPUS tombol create bawaan
    protected function getHeaderActions(): array
    {
        return [];
    }
}