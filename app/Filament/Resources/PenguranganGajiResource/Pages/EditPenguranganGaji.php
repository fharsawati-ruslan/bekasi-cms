<?php

namespace App\Filament\Resources\PenguranganGajiResource\Pages;

use App\Filament\Resources\PenguranganGajiResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPenguranganGaji extends EditRecord
{
    protected static string $resource = PenguranganGajiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
