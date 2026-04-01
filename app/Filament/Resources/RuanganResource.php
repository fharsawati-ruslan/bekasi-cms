<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RuanganResource\Pages;
use App\Models\Ruangan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class RuanganResource extends Resource
{
    protected static ?string $model = Ruangan::class;

    protected static ?string $navigationGroup = 'Cabang';
    protected static ?string $navigationLabel = 'Ruangan';
    protected static ?string $pluralLabel = 'Ruangan';
    protected static ?string $label = 'Ruangan';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-group';
    protected static ?int $navigationSort = 4;

    // ✅ FORM CREATE / EDIT
    public static function form(Form $form): Form
    {
        return $form->schema([

            Forms\Components\Select::make('cabang_id')
                ->label('Cabang')
                ->relationship('cabang', 'nama')
                ->searchable()
                ->required(),

            Forms\Components\TextInput::make('nama')
                ->label('Nama Ruangan')
                ->required(),

            Forms\Components\Toggle::make('aktif')
                ->default(true),

        ]);
    }

    // ✅ TABLE + IMPORT
    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('nama', 'asc')
            ->headerActions([

                Tables\Actions\Action::make('import')
                    ->label('Import Excel')
                    ->icon('heroicon-o-arrow-up-tray')
                    ->modalHeading('Import Data Ruangan')
                    ->form([

                        Forms\Components\FileUpload::make('file')
                            ->label('File Excel')
                            ->disk('local') // 🔥 simpan ke storage
                            ->directory('imports') // 🔥 folder imports
                            ->preserveFilenames() // 🔥 WAJIB
                            ->required()
                            ->helperText('Format: cabang | nama'),

                    ])
                    ->action(function (array $data) {

                        $file = $data['file'];

                        // 🔥 cek file ada
                        if (!Storage::disk('local')->exists($file)) {
                            throw new \Exception('File tidak ditemukan: ' . $file);
                        }

                        // 🔥 path full
                        $filePath = storage_path('app/' . $file);

                        // 🔥 import
                        Excel::import(
                            new \App\Imports\RuanganImport,
                            $filePath
                        );

                    }),

            ])
            ->columns([

                Tables\Columns\TextColumn::make('cabang.nama')
                    ->label('Cabang')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\IconColumn::make('aktif')
                    ->boolean()
                    ->label('Aktif'),

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
            'index' => Pages\ListRuangans::route('/'),
            'create' => Pages\CreateRuangan::route('/create'),
            'edit' => Pages\EditRuangan::route('/{record}/edit'),
        ];
    }
}