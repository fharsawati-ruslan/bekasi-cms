<?php

namespace App\Filament\Resources\KaryawanResource\Pages;

use App\Filament\Resources\KaryawanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;

use Maatwebsite\Excel\Facades\Excel;
use App\Imports\KaryawanImport;

class ListKaryawans extends ListRecords
{
    protected static string $resource = KaryawanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),

            Action::make('import')
                ->label('Import Excel')
                ->icon('heroicon-o-arrow-up-tray')
                ->color('success')

                ->form([
                    FileUpload::make('file')
                        ->label('Upload Excel / CSV')
                        ->required()
                        ->disk('public')
                        ->directory('imports'),
                ])

                ->action(function (array $data) {

                    // 🔥 anti timeout
                    ini_set('max_execution_time', 300);

                    $filePath = storage_path('app/public/' . $data['file']);

                    Excel::import(new KaryawanImport, $filePath);
                })

                ->successNotificationTitle('Import karyawan berhasil 🚀')
                ->modalHeading('Import Data Karyawan')
                ->modalSubmitActionLabel('Import Sekarang'),
        ];
    }
}