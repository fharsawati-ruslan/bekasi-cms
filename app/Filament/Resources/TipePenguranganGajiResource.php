<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TipePenguranganGajiResource\Pages;
use App\Filament\Resources\TipePenguranganGajiResource\RelationManagers;
use App\Models\TipePenguranganGaji;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TipePenguranganGajiResource extends Resource
{
    protected static ?string $model = TipePenguranganGaji::class;
    protected static ?string $navigationGroup = 'Master';
    protected static ?string $navigationLabel = 'Tipe Pengurangan Gaji';
    protected static ?string $pluralLabel = 'Tipe Pengurangan Gaji';
    protected static ?string $label = 'Tipe Pengurangan Gaji';



    protected static ?string $navigationIcon = 'heroicon-o-minus-circle';
    protected static ?int $navigationSort = 7;

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
            'index' => Pages\ListTipePenguranganGajis::route('/'),
            'create' => Pages\CreateTipePenguranganGaji::route('/create'),
            'edit' => Pages\EditTipePenguranganGaji::route('/{record}/edit'),
        ];
    }
}
