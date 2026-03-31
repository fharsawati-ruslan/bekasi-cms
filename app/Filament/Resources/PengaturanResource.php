<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PengaturanResource\Pages;
use App\Models\Pengaturan;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PengaturanImport;

class PengaturanResource extends Resource
{
    protected static ?string $model = Pengaturan::class;

    protected static ?string $navigationGroup = 'Master';
    protected static ?string $navigationLabel = 'Pengaturan';
    protected static ?string $pluralLabel = 'Pengaturan';
    protected static ?string $navigationIcon = 'heroicon-o-adjustments-horizontal';
    protected static ?int $navigationSort = 1;

    // ❌ MATIKAN CREATE
    public static function canCreate(): bool
    {
        return false;
    }

    // 🔥 FORM (EDIT ONLY)
    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('nama')
                ->label('Nama')
                ->disabled(),

            TextInput::make('nilai')
                ->label('Nilai')
                ->required(),
        ]);
    }

    // 🔥 TABLE + IMPORT CSV (FIXED)
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama')
                    ->searchable(),

                Tables\Columns\TextColumn::make('nilai')
                    ->label('Nilai'),
            ])

            ->headerActions([
                Action::make('import')
                    ->label('Import CSV')
                    ->icon('heroicon-o-arrow-up-tray')
                    ->color('success')
                    ->form([
                        FileUpload::make('file')
                            ->label('File CSV / Excel')
                            ->disk('public') // 🔥 FIX WAJIB
                            ->directory('imports') // 🔥 FIX WAJIB
                            ->required()
                            ->acceptedFileTypes([
                                'text/csv',
                                'application/vnd.ms-excel',
                                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                            ])
                    ])
                    ->action(function (array $data) {

                        // 🔥 AMBIL PATH FILE DARI STORAGE
                        $path = Storage::disk('public')->path($data['file']);

                        // 🔥 IMPORT
                        Excel::import(new PengaturanImport, $path);
                    })
                    ->successNotificationTitle('Import berhasil'),
            ])

            ->actions([
                Tables\Actions\EditAction::make()
                    ->color('warning'),
            ])

            ->bulkActions([]); // ❌ no delete
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPengaturans::route('/'),
            'edit' => Pages\EditPengaturan::route('/{record}/edit'),
        ];
    }
}