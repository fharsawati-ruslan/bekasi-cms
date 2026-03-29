<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TipeBiayaResource\Pages;
use App\Models\TipeBiaya;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TipeBiayaResource extends Resource
{
    protected static ?string $model = TipeBiaya::class;

    protected static ?string $navigationGroup = 'Master';

    protected static ?string $navigationIcon = 'heroicon-o-wallet';

    protected static ?int $navigationSort = 5;

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
            'index' => Pages\ListTipeBiayas::route('/'),
            'create' => Pages\CreateTipeBiaya::route('/create'),
            'edit' => Pages\EditTipeBiaya::route('/{record}/edit'),
        ];
    }
}
