<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TipeTransferResource\Pages;
use App\Models\TipeTransfer;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TipeTransferResource extends Resource
{
    protected static ?string $model = TipeTransfer::class;

    protected static ?string $navigationGroup = 'Master';

    protected static ?string $navigationIcon = 'heroicon-o-arrow-path';

    protected static ?int $navigationSort = 6;

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
            'index' => Pages\ListTipeTransfers::route('/'),
            'create' => Pages\CreateTipeTransfer::route('/create'),
            'edit' => Pages\EditTipeTransfer::route('/{record}/edit'),
        ];
    }
}
