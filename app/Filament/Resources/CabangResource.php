<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CabangResource\Pages;
use App\Models\Cabang;

use Filament\Forms\Form;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;

use Filament\Resources\Resource;

use Filament\Tables\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;

use Filament\Tables\Actions\Action;
use Filament\Forms\Components\FileUpload;

use Maatwebsite\Excel\Facades\Excel;
use App\Imports\CabangImport;

use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
use Illuminate\Support\Facades\Storage;

use Filament\Notifications\Notification;

class CabangResource extends Resource
{
    protected static ?string $model = Cabang::class;

    protected static ?string $navigationGroup = 'Cabang';
    protected static ?string $navigationLabel = 'Cabang';
    protected static ?string $pluralLabel = 'Cabang';
    protected static ?string $label = 'Cabang';

    protected static ?string $navigationIcon = 'heroicon-o-building-office';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(2)
                    ->schema([
                        TextInput::make('nama')
                            ->required()
                            ->maxLength(100),

                        TextInput::make('kode')
                            ->required()
                            ->unique(ignoreRecord: true),

                        TextInput::make('wilayah'),

                        TextInput::make('telpon'),

                        TextInput::make('hp'),

                        TextInput::make('tanggal_tutup_buku')
                            ->numeric()
                            ->default(1),

                        Textarea::make('alamat')
                            ->rows(3)
                            ->columnSpan(2),

                        Toggle::make('aktif')
                            ->label('Aktif?')
                            ->default(true)
                            ->columnSpan(2),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama')->searchable(),
                TextColumn::make('kode')->searchable(),
                TextColumn::make('wilayah'),
                TextColumn::make('telpon'),
                IconColumn::make('aktif')->boolean(),
            ])
            ->headerActions([
                ExportAction::make()
                    ->label('Export Excel')
                    ->icon('heroicon-o-arrow-down-tray'),

                Action::make('import')
    ->label('Import Excel')
    ->icon('heroicon-o-arrow-up-tray')
    ->form([
        FileUpload::make('file')
            ->disk('public')
            ->directory('imports')  
            ->required()
    ])
    ->action(function (array $data) {

        $file = $data['file'];

        if (!str_starts_with($file, 'imports/')) {
            $file = 'imports/' . $file;
        }

        $path = \Illuminate\Support\Facades\Storage::disk('public')->path($file);

        \Maatwebsite\Excel\Facades\Excel::import(new \App\Imports\CabangImport, $path);

        \Filament\Notifications\Notification::make()
            ->title('Import berhasil')
            ->success()
            ->send();









                        Notification::make()
                            ->title('Import berhasil')
                            ->success()
                            ->send();
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCabangs::route('/'),
            'create' => Pages\CreateCabang::route('/create'),
            'edit' => Pages\EditCabang::route('/{record}/edit'),
        ];
    }
}