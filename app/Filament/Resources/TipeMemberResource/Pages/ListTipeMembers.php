<?php

namespace App\Filament\Resources\TipeMemberResource\Pages;

use App\Filament\Resources\TipeMemberResource;
use Filament\Resources\Pages\ListRecords;

use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;

use Maatwebsite\Excel\Facades\Excel;
use App\Imports\TipeMemberImport;

class ListTipeMembers extends ListRecords
{
    protected static string $resource = TipeMemberResource::class;

    protected function getHeaderActions(): array
    {
        return [
                 \Filament\Actions\CreateAction::make(), // ✅ TAMBAH INI

            Action::make('import')
                ->label('Import Excel')
                ->icon('heroicon-o-arrow-up-tray')
                ->form([
                    FileUpload::make('file')
                        ->required()
                        ->disk('public')
                        ->directory('imports')
                ])
                ->action(function (array $data) {

                    Excel::import(
                        new TipeMemberImport,
                        storage_path('app/public/' . $data['file'])
                    );

                }),

        ];
    }
}