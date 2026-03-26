<?php

namespace App\Filament\Resources\ExtraPoinResource\Pages;

use App\Filament\Resources\ExtraPoinResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListExtraPoins extends ListRecords
{
    protected static string $resource = ExtraPoinResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
