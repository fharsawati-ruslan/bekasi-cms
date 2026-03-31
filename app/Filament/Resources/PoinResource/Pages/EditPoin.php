<?php

namespace App\Filament\Resources\PoinResource\Pages;

use App\Filament\Resources\PoinResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPoin extends EditRecord
{
    protected static string $resource = PoinResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
