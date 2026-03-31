<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TipeBiayaResource\Pages;
use App\Models\TipeBiaya;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\TipeBiayaImport;

class TipeBiayaResource extends Resource
{
    protected static ?string $model = TipeBiaya::class;

    protected static ?string $navigationGroup = 'Master';
    protected static ?string $navigationLabel = 'Tipe Biaya';
    protected static ?string $pluralLabel = 'Tipe Biaya';
    protected static ?string $navigationIcon = 'heroicon-o-wallet';

    // =========================
    // FORM
    // =========================
    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            TextInput::make('nama')
                ->label('Nama Tipe Biaya')
                ->required()
                ->live(onBlur: true)
                ->afterStateUpdated(fn ($state, $set) => $set('nama', strtoupper($state))),
        ]);
    }

    // =========================
    // TABLE + IMPORT
    // =========================
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama')
                    ->searchable(),
            ])

            ->headerActions([
                Action::make('import')
                    ->label('Import CSV')
                    ->icon('heroicon-o-arrow-up-tray')
                    ->color('success')
                    ->form([
                        FileUpload::make('file')
                            ->label('File CSV / Excel')
                            ->disk('public')
                            ->directory('imports')
                            ->required()
                    ])
                    ->action(function (array $data) {

                        $path = Storage::disk('public')->path($data['file']);

                        Excel::import(new TipeBiayaImport, $path);
                    })
                    ->successNotificationTitle('Import berhasil'),
            ])

            ->actions([
                Tables\Actions\EditAction::make()->color('warning'),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTipeBiayas::route('/'),
            'create' => Pages\CreateTipeBiaya::route('/create'),
            'edit' => Pages\EditTipeBiaya::route('/{record}/edit'),
        ];
    }
}