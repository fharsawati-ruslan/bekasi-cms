<?php

namespace App\Filament\Resources\PenguranganGajiResource\Pages;

use App\Filament\Resources\PenguranganGajiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPenguranganGajis extends ListRecords
{
    protected static string $resource = PenguranganGajiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
