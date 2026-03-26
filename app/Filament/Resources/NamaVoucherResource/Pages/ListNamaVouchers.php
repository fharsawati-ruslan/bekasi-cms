<?php

namespace App\Filament\Resources\NamaVoucherResource\Pages;

use App\Filament\Resources\NamaVoucherResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListNamaVouchers extends ListRecords
{
    protected static string $resource = NamaVoucherResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
