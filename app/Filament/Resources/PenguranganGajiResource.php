<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PenguranganGajiResource\Pages;
use App\Models\PenguranganGaji;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PenguranganGajiResource extends Resource
{
    protected static ?string $model = PenguranganGaji::class;

    protected static ?string $navigationGroup = 'Keuangan';

    protected static ?string $navigationLabel = 'Pengurangan Gaji';

    protected static ?string $pluralLabel = 'Pengurangan Gaji';

    protected static ?string $label = 'Pengurangan Gaji';

    protected static ?string $navigationIcon = 'heroicon-o-minus-circle';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListPenguranganGajis::route('/'),
            'create' => Pages\CreatePenguranganGaji::route('/create'),
            'edit' => Pages\EditPenguranganGaji::route('/{record}/edit'),
        ];
    }
}
