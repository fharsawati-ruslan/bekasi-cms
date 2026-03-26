<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SupplierResource\Pages;
use App\Models\Supplier;

use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;

use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SupplierResource extends Resource
{
    protected static ?string $model = Supplier::class;

    protected static ?string $navigationGroup = 'Master';
    protected static ?string $navigationLabel = 'Supplier';
    protected static ?string $pluralLabel = 'Supplier';
    protected static ?string $navigationIcon = 'heroicon-o-truck';
    protected static ?int $navigationSort = 2;

    // 🔥 FORM
    public static function form(Form $form): Form
    {
        return $form->schema([

            TextInput::make('nama')
                ->label('Nama')
                ->required()
                ->maxLength(100)
                ->live(onBlur: true)
                ->afterStateUpdated(fn ($state, $set) => $set('nama', strtoupper($state))),

            TextInput::make('telpon')
                ->label('Telpon')
                ->tel()
                ->required()
                ->maxLength(20),

            Textarea::make('alamat')
                ->label('Alamat')
                ->rows(3)
                ->maxLength(255),

        ]);
    }

    // 🔥 TABLE (INI YANG BIKIN KOSONG TADI)
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama')
                    ->searchable(),

                Tables\Columns\TextColumn::make('telpon')
                    ->label('Telpon'),

                Tables\Columns\TextColumn::make('alamat')
                    ->label('Alamat')
                    ->limit(30),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->modalHeading('Sunting Supplier')
                    ->modalSubmitActionLabel('Submit')
                    ->modalCancelActionLabel('Batal')
                    ->color('warning'),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSuppliers::route('/'),
            'create' => Pages\CreateSupplier::route('/create'),
            'edit' => Pages\EditSupplier::route('/{record}/edit'),
        ];
    }
}
