<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PoinResource\Pages;
use App\Models\Poin;

use Filament\Forms;
use Filament\Forms\Form;

use Filament\Resources\Resource;

use Filament\Tables;
use Filament\Tables\Table;

class PoinResource extends Resource
{
    protected static ?string $model = Poin::class;

    protected static ?string $navigationGroup = 'Member';
    protected static ?string $navigationLabel = 'Poin';
    protected static ?string $pluralLabel = 'Poin';
    protected static ?string $label = 'Poin';
    protected static ?string $navigationIcon = 'heroicon-o-star';
    protected static ?int $navigationSort = 4;

    /*
    |--------------------------------------------------------------------------
    | FORM (CREATE / EDIT)
    |--------------------------------------------------------------------------
    */
    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\TextInput::make('nama_member')
                    ->label('Nama Member')
                    ->required()
                    ->maxLength(100),

                Forms\Components\TextInput::make('poin')
                    ->label('Poin')
                    ->numeric()
                    ->required(),

                Forms\Components\Textarea::make('keterangan')
                    ->label('Keterangan')
                    ->rows(3),

                Forms\Components\DatePicker::make('tanggal')
                    ->label('Tanggal')
                    ->default(now()),

            ]);
    }

    /*
    |--------------------------------------------------------------------------
    | TABLE LIST
    |--------------------------------------------------------------------------
    */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('nama_member')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('poin')
                    ->label('Poin')
                    ->sortable(),

                Tables\Columns\TextColumn::make('keterangan')
                    ->label('Keterangan')
                    ->limit(30),

                Tables\Columns\TextColumn::make('tanggal')
                    ->label('Tanggal')
                    ->date('d M Y'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('d M Y H:i'),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    /*
    |--------------------------------------------------------------------------
    | RELATION
    |--------------------------------------------------------------------------
    */
    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | PAGES
    |--------------------------------------------------------------------------
    */
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPoins::route('/'),
            'create' => Pages\CreatePoin::route('/create'),
            'edit' => Pages\EditPoin::route('/{record}/edit'),
        ];
    }
}