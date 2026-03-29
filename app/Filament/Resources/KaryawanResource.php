<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KaryawanResource\Pages;
use App\Models\Karyawan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
// ✅ TAMBAHAN
use Filament\Tables\Table;

class KaryawanResource extends Resource
{
    protected static ?string $model = Karyawan::class;

    protected static ?string $navigationGroup = 'Karyawan';

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationLabel = 'Karyawan';

    protected static ?string $modelLabel = 'Karyawan';

    protected static ?string $pluralModelLabel = 'Karyawan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Data Karyawan')
                    ->icon('heroicon-o-user')
                    ->schema([

                        Forms\Components\Grid::make(2)->schema([

                            // ✅ CABANG
                            Forms\Components\Select::make('cabang_id')
                                ->label('Cabang')
                                ->relationship('cabang', 'nama')
                                ->searchable()
                                ->preload()
                                ->required(),

                            // ✅ JABATAN
                            Forms\Components\Select::make('jabatan_id')
                                ->label('Jabatan')
                                ->relationship('jabatan', 'nama')
                                ->searchable()
                                ->preload(),

                            // 🔥 ROLE (FIX TOTAL)
                            Forms\Components\Select::make('role_id')
                                ->label('Role')
                                ->relationship('role', 'name')
                                ->searchable()
                                ->preload()
                                ->required(),

                            Forms\Components\TextInput::make('nama')->required(),
                            Forms\Components\TextInput::make('nik'),

                            Forms\Components\TextInput::make('tempat_lahir'),
                            Forms\Components\DatePicker::make('tanggal_lahir'),

                            Forms\Components\Textarea::make('alamat')->columnSpanFull(),

                            Forms\Components\TextInput::make('hp'),

                            Forms\Components\Select::make('jenis_kelamin')
                                ->options([
                                    'L' => 'Laki-laki',
                                    'P' => 'Perempuan',
                                ]),

                            Forms\Components\Toggle::make('menikah'),
                            Forms\Components\TextInput::make('jumlah_anak')->numeric(),

                            Forms\Components\Select::make('pendidikan')
                                ->options([
                                    'SD' => 'SD',
                                    'SMP' => 'SMP',
                                    'SMA' => 'SMA',
                                    'D3' => 'D3',
                                    'S1' => 'S1',
                                ]),

                            Forms\Components\TextInput::make('penyakit'),
                            Forms\Components\TextInput::make('nomor_darurat'),

                            Forms\Components\DatePicker::make('bergabung_pada'),

                            // 🔥 SESUAI MODEL (aktif & terapis)
                            Forms\Components\Toggle::make('is_terapis')
                                ->label('Terapis'),

                            Forms\Components\Toggle::make('is_active')
                                ->label('Aktif'),

                            Forms\Components\TextInput::make('gaji_pokok')
                                ->prefix('Rp')
                                ->numeric(),

                            Forms\Components\TextInput::make('komisi')
                                ->suffix('%')
                                ->numeric(),

                            Forms\Components\TextInput::make('email')->email(),

                            Forms\Components\TextInput::make('password')
                                ->password()
                                ->dehydrateStateUsing(fn ($state) => filled($state) ? bcrypt($state) : null)
                                ->dehydrated(fn ($state) => filled($state)),

                        ]),

                        Forms\Components\FileUpload::make('foto')
                            ->image()
                            ->directory('karyawan')
                            ->imagePreviewHeight('150')
                            ->downloadable()
                            ->openable(),

                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('foto')->circular(),

                TextColumn::make('nama')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('cabang.nama')
                    ->label('Cabang'),

                TextColumn::make('jabatan.nama')
                    ->label('Jabatan'),

                // 🔥 FIX ROLE
                TextColumn::make('role.name')
                    ->label('Role')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->label('Aktif'),

                TextColumn::make('hp'),

                TextColumn::make('created_at')->dateTime(),
                Tables\Columns\TextColumn::make('email')
                ->label('Email')
                ->searchable()
                 ->sortable(),





            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKaryawans::route('/'),
            'create' => Pages\CreateKaryawan::route('/create'),
            'edit' => Pages\EditKaryawan::route('/{record}/edit'),
        ];
    }
}
