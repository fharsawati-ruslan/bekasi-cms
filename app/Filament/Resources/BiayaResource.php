<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BiayaResource\Pages;
use App\Filament\Resources\BiayaResource\RelationManagers;
use App\Models\Biaya;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BiayaResource extends Resource
{
protected static ?string $model = Biaya::class;

protected static ?string $navigationGroup = 'Keuangan';

protected static ?string $navigationLabel = 'Biaya';
protected static ?string $pluralLabel = 'Biaya';
protected static ?string $label = 'Biaya';

protected static ?string $navigationIcon = 'heroicon-o-receipt-percent';
protected static ?int $navigationSort = 1;

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
            'index' => Pages\ListBiayas::route('/'),
            'create' => Pages\CreateBiaya::route('/create'),
            'edit' => Pages\EditBiaya::route('/{record}/edit'),
        ];
    }
}
