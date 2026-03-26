<?php

namespace App\Filament\Resources\TipeMemberResource\Pages;

use App\Filament\Resources\TipeMemberResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTipeMember extends EditRecord
{
    protected static string $resource = TipeMemberResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
