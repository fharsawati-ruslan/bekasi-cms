<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NamaVoucherResource\Pages;
use App\Filament\Resources\NamaVoucherResource\RelationManagers;
use App\Models\NamaVoucher;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class NamaVoucherResource extends Resource
{
protected static ?string $model = NamaVoucher::class;

protected static ?string $navigationGroup = 'Voucher';

protected static ?string $navigationLabel = 'Nama Voucher';
protected static ?string $pluralLabel = 'Nama Voucher';
protected static ?string $label = 'Nama Voucher';

protected static ?string $navigationIcon = 'heroicon-o-ticket';
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
            'index' => Pages\ListNamaVouchers::route('/'),
            'create' => Pages\CreateNamaVoucher::route('/create'),
            'edit' => Pages\EditNamaVoucher::route('/{record}/edit'),
        ];
    }
}
