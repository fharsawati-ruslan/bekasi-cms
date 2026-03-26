<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PengaturanResource\Pages;
use App\Models\Pengaturan;

use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;

use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PengaturanResource extends Resource
{
    protected static ?string $model = Pengaturan::class;

    protected static ?string $navigationGroup = 'Master';
    protected static ?string $navigationLabel = 'Pengaturan';
    protected static ?string $pluralLabel = 'Pengaturan';
    protected static ?string $navigationIcon = 'heroicon-o-adjustments-horizontal';
    protected static ?int $navigationSort = 1;

    // ❌ MATIKAN CREATE
    public static function canCreate(): bool
    {
        return false;
    }

    // 🔥 FORM (EDIT ONLY)
    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('nama')
                ->label('Nama')
                ->disabled(),

            TextInput::make('nilai')
                ->label('Nilai')
                ->required(),
        ]);
    }

    // 🔥 TABLE (BIAR TAMPIL)
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama')
                    ->searchable(),

                Tables\Columns\TextColumn::make('nilai')
                    ->label('Nilai'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->color('warning'),
            ])
            ->bulkActions([]); // ❌ hilangkan delete
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPengaturans::route('/'),
            // ❌ remove create page
            'edit' => Pages\EditPengaturan::route('/{record}/edit'),
        ];
    }
}
