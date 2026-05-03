<?php

namespace App\Filament\Resources\PoinResource\Pages;

use App\Filament\Resources\PoinResource;
use Filament\Resources\Pages\ListRecords;

use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;

use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PoinImport;

class ListPoins extends ListRecords
{
    protected static string $resource = PoinResource::class;

    protected function getHeaderActions(): array
    {
        return [

            // ✅ tombol create
            \Filament\Actions\CreateAction::make(),

            // ✅ tombol import
            Action::make('import')
                ->label('Import CSV')
                ->icon('heroicon-o-arrow-up-tray')
                ->form([
                    FileUpload::make('file')
                        ->required()
                        ->disk('public')
                        ->directory('imports')
                ])
                ->action(function (array $data) {

                    Excel::import(
                        new PoinImport,
                        storage_path('app/public/' . $data['file'])
                    );

                }),

        ];
    }
}