<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WilayahResource\Pages;
use App\Models\Wilayah;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class WilayahResource extends Resource
{
    protected static ?string $model = Wilayah::class;

    protected static ?string $navigationGroup = 'Cabang';
    protected static ?string $navigationLabel = 'Wilayah';
    protected static ?string $pluralLabel = 'Wilayah';
    protected static ?string $label = 'Wilayah';
    protected static ?string $navigationIcon = 'heroicon-o-map';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('cabang_id')
                    ->label('Cabang')
                    ->relationship('cabang', 'nama')
                    ->searchable()
                    ->required(),

                Forms\Components\TextInput::make('nama')
                    ->label('Nama Wilayah')
                    ->required(),

                Forms\Components\Toggle::make('aktif')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('nama', 'asc') // 🔥 ascending
            ->headerActions([
                \Filament\Tables\Actions\Action::make('import')
                    ->label('Import Excel')
                    ->icon('heroicon-o-arrow-up-tray')
                    ->modalHeading('Import Data Wilayah')
                    ->modalDescription('Upload file Excel berisi daftar wilayah.')
                    ->form([

                        Forms\Components\Select::make('cabang_id')
                            ->label('Cabang')
                            ->relationship('cabang', 'nama')
                            ->required()
                            ->helperText('Pilih cabang tujuan. Semua wilayah akan masuk ke cabang ini.'),

                        Forms\Components\FileUpload::make('file')
                            ->label('File Excel')
                            ->required()
                            ->acceptedFileTypes([
                                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                                'text/csv'
                            ])
                            ->helperText('Format: 1 kolom saja dengan header "Nama". Contoh: Tangerang, Depok, Bandung'),
                    ])
                    ->action(function (array $data) {
                        \Maatwebsite\Excel\Facades\Excel::import(
                            new \App\Imports\WilayahImport($data['cabang_id']),
                            $data['file']
                        );
                    })
            ])
            ->columns([
                Tables\Columns\TextColumn::make('cabang.nama')
                    ->label('Cabang')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama Wilayah')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\IconColumn::make('aktif')
                    ->label('Aktif')
                    ->boolean(),
            ])
            ->filters([
                //
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
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWilayahs::route('/'),
            'create' => Pages\CreateWilayah::route('/create'),
            'edit' => Pages\EditWilayah::route('/{record}/edit'),
        ];
    }
}