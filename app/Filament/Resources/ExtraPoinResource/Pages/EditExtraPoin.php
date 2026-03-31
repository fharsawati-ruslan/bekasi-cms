<?php

namespace App\Filament\Resources\ExtraPoinResource\Pages;

use App\Filament\Resources\ExtraPoinResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditExtraPoin extends EditRecord
{
    protected static string $resource = ExtraPoinResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
