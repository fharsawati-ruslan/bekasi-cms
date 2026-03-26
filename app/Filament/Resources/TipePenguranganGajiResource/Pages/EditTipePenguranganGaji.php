<?php

namespace App\Filament\Resources\TipePenguranganGajiResource\Pages;

use App\Filament\Resources\TipePenguranganGajiResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTipePenguranganGaji extends EditRecord
{
    protected static string $resource = TipePenguranganGajiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
