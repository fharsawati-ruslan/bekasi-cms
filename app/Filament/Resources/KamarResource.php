<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KamarResource\Pages;
use App\Models\Kamar;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class KamarResource extends Resource
{
    protected static ?string $model = Kamar::class;

    protected static ?string $navigationGroup = 'Cabang';
    protected static ?string $navigationLabel = 'Kamar';
    protected static ?string $pluralLabel = 'Kamar';
    protected static ?string $label = 'Kamar';
    protected static ?string $navigationIcon = 'heroicon-o-home-modern';
    protected static ?int $navigationSort = 5;

    // 🔥 FORM (INI YANG TADI KOSONG)
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('cabang_id')
                    ->label('Cabang')
                    ->relationship('cabang', 'nama')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->placeholder('-- Pilih Cabang --'),

                Forms\Components\TextInput::make('nama')
                    ->label('Nama')
                    ->required()
                    ->placeholder('masukan nama'),

                Forms\Components\TextInput::make('serial_timer')
                    ->label('Serial Timer')
                    ->placeholder('masukan serial timer'),
            ]);
    }

    // 🔥 TABLE (BIAR DATA KELIATAN)
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('cabang.nama')
                    ->label('Cabang')
                    ->searchable(),

                Tables\Columns\TextColumn::make('nama')
                    ->searchable(),

                Tables\Columns\TextColumn::make('serial_timer'),
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
            'index' => Pages\ListKamars::route('/'),
            'create' => Pages\CreateKamar::route('/create'),
            'edit' => Pages\EditKamar::route('/{record}/edit'),
        ];
    }
}