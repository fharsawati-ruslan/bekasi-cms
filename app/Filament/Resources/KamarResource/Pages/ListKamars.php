<?php

namespace App\Filament\Resources\KamarResource\Pages;

use App\Filament\Resources\KamarResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions;

use Filament\Forms\Components\FileUpload;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\KamarImport;

class ListKamars extends ListRecords
{
    protected static string $resource = KamarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),

            Actions\Action::make('import')
                ->label('Import Excel')
                ->icon('heroicon-o-arrow-up-tray')
                ->color('success')

                // 🔥 ini penting di v3
                ->form([
                    FileUpload::make('file')
                        ->label('File Excel')
                        ->required()
                        ->disk('local') // WAJIB kadang
                        ->directory('imports') // biar gak error
                        ->acceptedFileTypes([
                            '.xlsx',
                            '.csv',
                        ]),
                ])

                ->action(function (array $data) {
                    Excel::import(
                        new KamarImport,
                        storage_path('app/' . $data['file'])
                    );
                }),
        ];
    }
}