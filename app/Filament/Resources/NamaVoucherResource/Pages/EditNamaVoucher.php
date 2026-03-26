<?php

namespace App\Filament\Resources\NamaVoucherResource\Pages;

use App\Filament\Resources\NamaVoucherResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditNamaVoucher extends EditRecord
{
    protected static string $resource = NamaVoucherResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
