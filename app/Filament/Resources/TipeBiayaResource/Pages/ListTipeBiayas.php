<?php

namespace App\Filament\Resources\TipeBiayaResource\Pages;

use App\Filament\Resources\TipeBiayaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTipeBiayas extends ListRecords
{
    protected static string $resource = TipeBiayaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
