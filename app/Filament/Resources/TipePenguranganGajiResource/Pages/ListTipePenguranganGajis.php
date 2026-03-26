<?php

namespace App\Filament\Resources\TipePenguranganGajiResource\Pages;

use App\Filament\Resources\TipePenguranganGajiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTipePenguranganGajis extends ListRecords
{
    protected static string $resource = TipePenguranganGajiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
