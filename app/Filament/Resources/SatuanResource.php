<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SatuanResource\Pages;
use App\Models\Satuan;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\SatuanImport;

class SatuanResource extends Resource
{
    protected static ?string $model = Satuan::class;

    protected static ?string $navigationGroup = 'Master';
    protected static ?string $navigationLabel = 'Satuan';
    protected static ?string $pluralLabel = 'Satuan';
    protected static ?string $navigationIcon = 'heroicon-o-scale';

    // =========================
    // FORM
    // =========================
    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('nama')
                ->label('Nama Satuan')
                ->required()
                ->maxLength(100)
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
            ->defaultSort('nama', 'asc') // 🔥 ascendin
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama Satuan')
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

                        Excel::import(new SatuanImport, $path);
                    })
                    ->successNotificationTitle('Import berhasil'),
            ])

            ->actions([
                Tables\Actions\EditAction::make()->color('warning'),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    // =========================
    public static function getRelations(): array
    {
        return [];
    }

    // =========================
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSatuans::route('/'),
            'create' => Pages\CreateSatuan::route('/create'),
            'edit' => Pages\EditSatuan::route('/{record}/edit'),
        ];
    }
}