<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BankResource\Pages;
use App\Models\Bank;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\BankImport;

class BankResource extends Resource
{
    protected static ?string $model = Bank::class;

    protected static ?string $navigationGroup = 'Master';
    protected static ?string $navigationLabel = 'Bank';
    protected static ?string $pluralLabel = 'Bank';
    protected static ?string $navigationIcon = 'heroicon-o-credit-card';

    // =========================
    // FORM
    // =========================
    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            TextInput::make('nama')
                ->required(),

            TextInput::make('nomor_rekening')
                ->numeric()
                ->default(0),

            TextInput::make('potongan_transaksi')
                ->numeric()
                ->default(0),

            Toggle::make('tampilkan_di_kasir')
                ->label('Tampilkan di Kasir')
                ->default(true),

            Toggle::make('rekening_global')
                ->label('Rekening Global')
                ->default(false),
        ]);
    }

    // =========================
    // TABLE + IMPORT
    // =========================
    public static function table(Table $table): Table
    {
        return $table
           ->defaultSort('nama', 'asc') // 🔥 ascending
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->searchable(),

                Tables\Columns\TextColumn::make('nomor_rekening'),

                Tables\Columns\TextColumn::make('potongan_transaksi'),

                Tables\Columns\IconColumn::make('tampilkan_di_kasir')
                    ->boolean(),

                Tables\Columns\IconColumn::make('rekening_global')
                    ->boolean(),
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

                        Excel::import(new BankImport, $path);
                    })
                    ->successNotificationTitle('Import berhasil'),
            ])

            ->actions([
                Tables\Actions\EditAction::make()->color('warning'),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    // =========================
    // RELATION
    // =========================
    public static function getRelations(): array
    {
        return [];
    }

    // =========================
    // PAGES
    // =========================
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBanks::route('/'),
            'create' => Pages\CreateBank::route('/create'),
            'edit' => Pages\EditBank::route('/{record}/edit'),
        ];
    }
}