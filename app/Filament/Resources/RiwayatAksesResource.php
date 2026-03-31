<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RiwayatAksesResource\Pages;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Spatie\Activitylog\Models\Activity;

class RiwayatAksesResource extends Resource
{
    protected static ?string $model = Activity::class;

    protected static ?string $navigationGroup = 'Karyawan';

    protected static ?string $navigationLabel = 'Riwayat Akses';

    protected static ?string $pluralLabel = 'Riwayat Akses';

    protected static ?string $label = 'Riwayat Akses';

    protected static ?string $navigationIcon = 'heroicon-o-clock';

    protected static ?int $navigationSort = 3;

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
            'index' => Pages\ListRiwayatAkses::route('/'),
            'create' => Pages\CreateRiwayatAkses::route('/create'),
            'edit' => Pages\EditRiwayatAkses::route('/{record}/edit'),
        ];
    }
}
