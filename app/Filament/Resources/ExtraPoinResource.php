<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExtraPoinResource\Pages;
use App\Models\ExtraPoin;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ExtraPoinResource extends Resource
{
    protected static ?string $model = ExtraPoin::class;

    protected static ?string $navigationGroup = 'Member';

    protected static ?string $navigationLabel = 'Extra Poin';

    protected static ?string $pluralLabel = 'Extra Poin';

    protected static ?string $label = 'Extra Poin';

    protected static ?string $navigationIcon = 'heroicon-o-plus-circle';

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
            'index' => Pages\ListExtraPoins::route('/'),
            'create' => Pages\CreateExtraPoin::route('/create'),
            'edit' => Pages\EditExtraPoin::route('/{record}/edit'),
        ];
    }
}
