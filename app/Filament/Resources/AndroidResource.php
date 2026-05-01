<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AndroidResource\Pages;
use App\Models\Android;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AndroidResource extends Resource
{
    protected static ?string $model = Android::class;

    protected static ?string $navigationGroup = 'Member';
    protected static ?string $navigationLabel = 'Android';
    protected static ?string $navigationIcon = 'heroicon-o-device-phone-mobile';

    public static function form(Form $form): Form
    {
        return $form->schema([

            Forms\Components\TextInput::make('nama')
                ->label('Nama')
                ->required()
                ->maxLength(255),

            Forms\Components\FileUpload::make('foto')
                ->label('Foto')
                ->image()
                ->disk('public') // 🔥 WAJIB
                ->directory('android')
                ->imagePreviewHeight('250')
                 ->panelAspectRatio('16:9') // biar landscape cakep
                  ->panelLayout('integrated') // UI lebih clean
                ->loadingIndicatorPosition('left')
                ->required(),

            Forms\Components\TextInput::make('link')
                ->label('Link')
                ->url()
                ->placeholder('https://example.com'),

            Forms\Components\Textarea::make('deskripsi')
                ->label('Deskripsi')
                ->rows(3)
                ->maxLength(128),

            Forms\Components\Toggle::make('aktif')
                ->label('Aktif')
                ->default(true),

        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\ImageColumn::make('foto')
                    ->label('Foto')
                    ->square(),

                Tables\Columns\TextColumn::make('nama')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('link')
                    ->limit(30)
                    ->url(fn ($record) => $record->link, true),

                Tables\Columns\IconColumn::make('aktif')
                    ->boolean(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d M Y'),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(), // tambah delete biar lengkap
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