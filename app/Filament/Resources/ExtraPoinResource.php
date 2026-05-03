<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExtraPoinResource\Pages;
use App\Models\PoinEkstra;
use App\Models\Poin;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;

use Filament\Resources\Resource;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\Action;

use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PoinEkstraImport;

use Filament\Notifications\Notification;

class ExtraPoinResource extends Resource
{
    protected static ?string $model = PoinEkstra::class;

    protected static ?string $navigationGroup = 'Member';
    protected static ?string $navigationLabel = 'Extra Poin';
    protected static ?string $pluralLabel = 'Extra Poin';
    protected static ?string $label = 'Extra Poin';
    protected static ?string $navigationIcon = 'heroicon-o-plus-circle';
    protected static ?int $navigationSort = 5;

    #️⃣ ================= FORM =================
    public static function form(Form $form): Form
    {
        return $form->schema([

            Select::make('poin_id')
                ->label('Tipe Poin')
                ->relationship('poin', 'nama')
                ->searchable()
                ->required(),

            TextInput::make('nama')
                ->label('Nama Promo')
                ->required(),

            DatePicker::make('tanggal_mulai')
                ->label('Tanggal Mulai')
                ->required(),

            DatePicker::make('tanggal_berakhir')
                ->label('Tanggal Berakhir')
                ->required(),

            TextInput::make('kelipatan_poin')
                ->label('Kelipatan Poin')
                ->numeric()
                ->required(),
        ]);
    }

    #️⃣ ================= TABLE =================
    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('nama')
                    ->label('Nama'),

                TextColumn::make('tanggal_mulai')
                    ->label('Tanggal Mulai Berlaku')
                    ->date('d F Y'),

                TextColumn::make('tanggal_berakhir')
                    ->label('Tanggal Berakhir')
                    ->date('d F Y'),

                TextColumn::make('kelipatan_poin')
                    ->label('Kelipatan Poin')
                    ->money('IDR'),

            ])

            ->headerActions([

                Action::make('import_csv')
                    ->label('CSV')
                    ->color('primary')
                    ->icon('heroicon-o-arrow-up-tray')
                    ->form([
                        FileUpload::make('file')
                            ->label('Upload CSV')
                            ->disk('public')
                            ->directory('imports')
                            ->required()
                            ->acceptedFileTypes(['text/csv', '.csv'])
                    ])
                    ->action(function ($data) {

                        // 🔥 FIX PATH BIAR TIDAK ERROR
                        $path = storage_path('app/public/' . $data['file']);

                        Excel::import(new PoinEkstraImport, $path);

                        Notification::make()
                            ->title('Import berhasil')
                            ->success()
                            ->send();
                    }),

            ])

            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])

            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    #️⃣ ================= RELATION =================
    public static function getRelations(): array
    {
        return [];
    }

    #️⃣ ================= PAGE =================
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListExtraPoins::route('/'),
            'create' => Pages\CreateExtraPoin::route('/create'),
            'edit' => Pages\EditExtraPoin::route('/{record}/edit'),
        ];
    }
}