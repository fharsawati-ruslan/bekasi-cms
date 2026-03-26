<?php

namespace App\Filament\Resources\RiwayatAksesResource\Pages;

use App\Filament\Resources\RiwayatAksesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRiwayatAkses extends ListRecords
{
    protected static string $resource = RiwayatAksesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
