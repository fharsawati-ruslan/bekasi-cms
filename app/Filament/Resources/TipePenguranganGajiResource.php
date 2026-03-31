<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TipePenguranganGajiResource\Pages;
use App\Models\TipePenguranganGaji;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use App\Imports\TipePenguranganGajiImport;

class TipePenguranganGajiResource extends Resource
{
    protected static ?string $model = TipePenguranganGaji::class;

    protected static ?string $navigationGroup = 'Master';

    protected static ?string $navigationLabel = 'Tipe Pengurangan Gaji';

    protected static ?string $pluralLabel = 'Tipe Pengurangan Gaji';

    protected static ?string $label = 'Tipe Pengurangan Gaji';

    protected static ?string $navigationIcon = 'heroicon-o-minus-circle';

    protected static ?int $navigationSort = 7;

    // 🔥 FORM SESUAI UI
    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('nama')
                ->label('Nama')
                ->required()
                ->live(onBlur: true)
                ->afterStateUpdated(fn ($state, $set) => $set('nama', strtoupper($state))),

            Toggle::make('diangsur')
                ->label('Diangsur?'),

            Toggle::make('memotong_kas')
                ->label('Memotong Kas?'),
        ]);
    }

    // 🔥 TABLE + IMPORT
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama')
                    ->searchable(),

                Tables\Columns\IconColumn::make('diangsur')
                    ->label('Diangsur')
                    ->boolean(),

                Tables\Columns\IconColumn::make('memotong_kas')
                    ->label('Potong Kas')
                    ->boolean(),
            ])

            // 🔥 IMPORT EXCEL
            ->headerActions([
                Action::make('import')
                    ->label('Import Excel / CSV')
                    ->icon('heroicon-o-arrow-up-tray')
                    ->color('success')
                    ->form([
                        FileUpload::make('file')
                            ->label('File Excel / CSV')
                            ->required()
                            ->directory('imports')
                            ->disk('public'),
                    ])
                    ->action(function (array $data) {
                        $path = Storage::disk('public')->path($data['file']);
                        Excel::import(new TipePenguranganGajiImport, $path);
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
            'index' => Pages\ListTipePenguranganGajis::route('/'),
            'create' => Pages\CreateTipePenguranganGaji::route('/create'),
            'edit' => Pages\EditTipePenguranganGaji::route('/{record}/edit'),
        ];
    }
}