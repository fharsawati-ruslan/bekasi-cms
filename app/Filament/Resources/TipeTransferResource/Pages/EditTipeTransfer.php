<?php

namespace App\Filament\Resources\TipeTransferResource\Pages;

use App\Filament\Resources\TipeTransferResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTipeTransfer extends EditRecord
{
    protected static string $resource = TipeTransferResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
