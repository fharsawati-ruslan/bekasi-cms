<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaketResource\Pages;
use App\Models\Paket;

use Filament\Forms;
use Filament\Forms\Form;

use Filament\Resources\Resource;

use Filament\Tables;
use Filament\Tables\Table;

use Illuminate\Support\Facades\Storage;

class PaketResource extends Resource
{
    protected static ?string $model = Paket::class;

    protected static ?string $navigationGroup = 'Voucher';
    protected static ?string $navigationLabel = 'Nama Voucher';
    protected static ?string $label = 'Nama Voucher';
    protected static ?string $pluralLabel = 'Nama Voucher';
    protected static ?string $navigationIcon = 'heroicon-o-ticket';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama')
                    ->label('Nama')
                    ->required(),

                Forms\Components\Select::make('tipe_voucher')
                    ->label('Tipe Voucher')
                    ->options([
                        'item' => 'Item',
                        'paket' => 'Paket',
                        'treatment' => 'Treatment',
                        'diskon' => 'Diskon',
                        'potongan' => 'Potongan',
                    ])
                    ->required()
                    ->searchable()
                    ->native(false),

                Forms\Components\DatePicker::make('berlaku_hingga')
                    ->label('Berlaku Hingga')
                    ->displayFormat('d/m/Y'),

                Forms\Components\TextInput::make('jumlah_tukar_poin')
                    ->label('Jumlah Tukar Poin')
                    ->numeric()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->headerActions([
                Tables\Actions\Action::make('import')
                    ->label('Import CSV')
                    ->icon('heroicon-o-arrow-up-tray')

                    // ✅ GANTI FILEUPLOAD → SELECT FILE SERVER
                    ->form([
                        Forms\Components\Select::make('file')
                            ->label('Pilih File CSV (dari server)')
                            ->options(function () {
                                $files = Storage::files('imports');

                                $options = [];
                                foreach ($files as $file) {
                                    if (str_ends_with($file, '.csv')) {
                                        $options[$file] = basename($file);
                                    }
                                }

                                return $options;
                            })
                            ->required(),
                    ])

                    ->action(function (array $data) {

                        $path = storage_path('app/' . $data['file']);

                        // ✅ DEBUG SAFE
                        if (!file_exists($path)) {
                            throw new \Exception('File tidak ditemukan: ' . $path);
                        }

                        $file = fopen($path, 'r');

                        if (!$file) {
                            throw new \Exception('Gagal membuka file.');
                        }

                        // skip header
                        fgetcsv($file);

                        $total = 0;

                        while (($row = fgetcsv($file)) !== false) {

                            // ✅ SAFE GUARD (biar gak error index)
                            if (count($row) < 5) {
                                continue;
                            }

                            Paket::updateOrCreate(
                                ['nama' => $row[0]],
                                [
                                    'tipe_voucher' => strtolower($row[1]),
                                    'nilai' => $row[2] ?: null,
                                    'berlaku_hingga' => $row[3] ?: null,
                                    'jumlah_tukar_poin' => $row[4] ?: 0,
                                ]
                            );

                            $total++;
                        }

                        fclose($file);

                        // ✅ OPTIONAL: kasih notifikasi
                        \Filament\Notifications\Notification::make()
                            ->title('Import berhasil')
                            ->body("Total data: {$total}")
                            ->success()
                            ->send();
                    }),
            ])
            ->columns([
                Tables\Columns\TextColumn::make('nama')->searchable(),
                Tables\Columns\TextColumn::make('tipe_voucher'),
                Tables\Columns\TextColumn::make('berlaku_hingga')->date(),
                Tables\Columns\TextColumn::make('jumlah_tukar_poin'),
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
            'index' => Pages\ListPakets::route('/'),
            'create' => Pages\CreatePaket::route('/create'),
            'edit' => Pages\EditPaket::route('/{record}/edit'),
        ];
    }
}