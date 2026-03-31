<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TipeTransferResource\Pages;
use App\Models\TipeTransfer;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\TipeTransferImport;
use Illuminate\Support\Facades\Storage;

class TipeTransferResource extends Resource
{
    protected static ?string $model = TipeTransfer::class;

    protected static ?string $navigationGroup = 'Master';

    protected static ?string $navigationIcon = 'heroicon-o-arrow-path';

    protected static ?int $navigationSort = 6;

    // 🔥 FIX NAMA (HILANGIN S)
    protected static ?string $navigationLabel = 'Tipe Transfer';
    protected static ?string $pluralLabel = 'Tipe Transfer';
    protected static ?string $label = 'Tipe Transfer';

    // FORM
    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('nama')
                ->label('Nama')
                ->required()
                ->live(onBlur: true)
                ->afterStateUpdated(fn ($state, $set) => $set('nama', strtoupper($state))),
        ]);
    }

    // TABLE
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama')
                    ->searchable(),
            ])

            // 🔥 IMPORT EXCEL
            ->headerActions([
                Action::make('import')
                    ->label('Import Excel')
                    ->icon('heroicon-o-arrow-up-tray')
                    ->color('success')
                    ->form([
                        FileUpload::make('file')
                            ->label('File Excel / CSV')
                            ->required()
                            ->directory('imports')
                            ->disk('public')
                    ])
                    ->action(function (array $data) {
                        $path = Storage::disk('public')->path($data['file']);
                        Excel::import(new TipeTransferImport, $path);
                    })
                    ->successNotificationTitle('Import berhasil'),
            ])

            ->filters([
                //
            ])

            ->actions([
                Tables\Actions\EditAction::make()
                    ->color('warning'),
            ])

            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTipeTransfers::route('/'),
            'create' => Pages\CreateTipeTransfer::route('/create'),
            'edit' => Pages\EditTipeTransfer::route('/{record}/edit'),
        ];
    }
}