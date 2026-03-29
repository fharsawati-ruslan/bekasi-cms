<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TipeMemberResource\Pages;
use App\Models\TipeMember;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TipeMemberResource extends Resource
{
    protected static ?string $model = TipeMember::class;

    protected static ?string $navigationGroup = 'Member';

    protected static ?string $navigationLabel = 'Tipe Member';

    protected static ?string $pluralLabel = 'Tipe Member';

    protected static ?string $label = 'Tipe Member';

    protected static ?string $navigationIcon = 'heroicon-o-identification';

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
            'index' => Pages\ListTipeMembers::route('/'),
            'create' => Pages\CreateTipeMember::route('/create'),
            'edit' => Pages\EditTipeMember::route('/{record}/edit'),
        ];
    }
}
