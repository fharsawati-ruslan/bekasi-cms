<?php

namespace App\Filament\Resources\TipeMemberResource\Pages;

use App\Filament\Resources\TipeMemberResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTipeMembers extends ListRecords
{
    protected static string $resource = TipeMemberResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
