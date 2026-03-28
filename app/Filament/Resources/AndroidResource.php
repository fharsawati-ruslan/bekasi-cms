<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AndroidResource\Pages;
use App\Filament\Resources\AndroidResource\RelationManagers;
use App\Models\Android;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AndroidResource extends Resource
{
    protected static ?string $model = Android::class;

    protected static ?string $navigationGroup = 'Member';

    protected static ?string $navigationLabel = 'Android';

    protected static ?string $navigationIcon = 'heroicon-o-device-phone-mobile';

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
            'index' => Pages\ListAndroids::route('/'),
            'create' => Pages\CreateAndroid::route('/create'),
            'edit' => Pages\EditAndroid::route('/{record}/edit'),
        ];
    }
}
