<?php

namespace App\Filament\Resources\TipeBiayaResource\Pages;

use App\Filament\Resources\TipeBiayaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTipeBiaya extends EditRecord
{
    protected static string $resource = TipeBiayaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
