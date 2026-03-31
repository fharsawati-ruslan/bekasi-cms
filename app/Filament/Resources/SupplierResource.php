<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SupplierResource\Pages;
use App\Models\Supplier;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\SupplierImport;

class SupplierResource extends Resource
{
    protected static ?string $model = Supplier::class;

    protected static ?string $navigationGroup = 'Master';
    protected static ?string $navigationLabel = 'Supplier';
    protected static ?string $pluralLabel = 'Supplier';
    protected static ?string $navigationIcon = 'heroicon-o-truck';
    protected static ?int $navigationSort = 2;

    // =========================
    // FORM
    // =========================
    public static function form(Form $form): Form
    {
        return $form->schema([

            TextInput::make('nama')
                ->label('Nama')
                ->required()
                ->maxLength(100)
                ->live(onBlur: true)
                ->afterStateUpdated(fn ($state, $set) => $set('nama', strtoupper($state))),

            TextInput::make('telpon')
                ->label('Telpon')
                ->tel()
                ->maxLength(20)
                ->nullable(), // 🔥 FIX biar gak error import kosong

            Textarea::make('alamat')
                ->label('Alamat')
                ->rows(3)
                ->maxLength(255)
                ->nullable(),
        ]);
    }

    // =========================
    // TABLE + IMPORT CSV
    // =========================
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama')
                    ->searchable(),

                Tables\Columns\TextColumn::make('telpon')
                    ->label('Telpon'),

                Tables\Columns\TextColumn::make('alamat')
                    ->label('Alamat')
                    ->limit(30),
            ])

            ->headerActions([
                Action::make('import')
                    ->label('Import CSV')
                    ->icon('heroicon-o-arrow-up-tray')
                    ->color('success')
                    ->form([
                        FileUpload::make('file')
                            ->label('File CSV / Excel')
                            ->disk('public') // 🔥 WAJIB
                            ->directory('imports') // 🔥 WAJIB
                            ->required()
                    ])
                    ->action(function (array $data) {

                        $path = Storage::disk('public')->path($data['file']);

                        Excel::import(new SupplierImport, $path);
                    })
                    ->successNotificationTitle('Import berhasil'),
            ])

            ->actions([
                Tables\Actions\EditAction::make()
                    ->modalHeading('Sunting Supplier')
                    ->modalSubmitActionLabel('Submit')
                    ->modalCancelActionLabel('Batal')
                    ->color('warning'),

                Tables\Actions\DeleteAction::make(),
            ])

            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListSuppliers::route('/'),
            'create' => Pages\CreateSupplier::route('/create'),
            'edit' => Pages\EditSupplier::route('/{record}/edit'),
        ];
    }
}