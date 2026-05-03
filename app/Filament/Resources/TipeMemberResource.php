<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TipeMemberResource\Pages;
use App\Models\TipeMember;

use Filament\Forms;
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

    /*
    |--------------------------------------------------------------------------
    | FORM (CREATE / EDIT)
    |--------------------------------------------------------------------------
    */
    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\TextInput::make('nama_tipe')
                    ->label('Nama Tipe')
                    ->required()
                    ->maxLength(100),

                Forms\Components\TextInput::make('min_poin')
                    ->label('Min Poin')
                    ->numeric()
                    ->required(),

                Forms\Components\TextInput::make('max_poin')
                    ->label('Max Poin')
                    ->numeric()
                    ->required(),

                Forms\Components\Textarea::make('benefit')
                    ->label('Benefit')
                    ->rows(3),

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

                Tables\Columns\TextColumn::make('nama_tipe')
                    ->label('Tipe')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('min_poin')
                    ->label('Min')
                    ->sortable(),

                Tables\Columns\TextColumn::make('max_poin')
                    ->label('Max')
                    ->sortable(),

                Tables\Columns\TextColumn::make('benefit')
                    ->limit(30),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d M Y')
                    ->label('Created'),

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
            'index' => Pages\ListTipeMembers::route('/'),
            'create' => Pages\CreateTipeMember::route('/create'),
            'edit' => Pages\EditTipeMember::route('/{record}/edit'),
        ];
    }
}