<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransaksiResource\Pages;
use App\Models\Member;
use App\Models\Transaksi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;

class TransaksiResource extends Resource
{
    protected static ?string $model = Transaksi::class;

    protected static ?string $navigationLabel = 'Transaksi';

    protected static ?string $pluralLabel = 'Transaksi';

    protected static ?string $label = 'Transaksi';

    protected static ?string $modelLabel = 'Transaksi';

    protected static ?string $pluralModelLabel = 'Transaksi';

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                // 🔥 JAM LIVE TARUH DI SINI
                Forms\Components\Placeholder::make('jam_sekarang')
                    ->label('Waktu Sekarang')
                    ->content(new HtmlString('
                    <div id="live-clock" class="text-lg font-bold flex items-center gap-2">
                        ⏱️ <span></span>
                    </div>

                    <script>
                        function updateClock() {
                            const now = new Date();
                            const formatted = now.toLocaleString("id-ID", {
                                day: "2-digit",
                                month: "2-digit",
                                year: "numeric",
                                hour: "2-digit",
                                minute: "2-digit",
                                second: "2-digit"
                            });

                            document.querySelector("#live-clock span").innerText = formatted;
                        }

                        setInterval(updateClock, 1000);
                        updateClock();
                    </script>
                ')),

                Forms\Components\Grid::make(2)->schema([

                    // AUTO FOCUS (INI PENTING 🔥)
                    Forms\Components\TextInput::make('nama_tamu')
                        ->label('Scan / Nama Tamu')
                        ->autofocus()
                        ->required(),

                    Forms\Components\DateTimePicker::make('waktu')
                        ->label('Waktu')
                        ->default(now()) // auto sekarang
                        ->seconds(false) // optional biar rapi
                        ->required(),

                    Forms\Components\TextInput::make('kode_transaksi')
                        ->label('ID Transaksi')
                        ->default(fn () => 'TRX-'.now()->format('YmdHis'))
                        ->disabled()
                        ->dehydrated(),

                    Forms\Components\Select::make('cabang_id')
                        ->label('Cabang')
                        ->relationship('cabang', 'nama')
                        ->searchable()
                        ->required(),

                    Forms\Components\Select::make('kasir_id')
                        ->label('Kasir')
                        ->relationship('kasir', 'name')
                        ->searchable()
                        ->required(),

                    Forms\Components\Select::make('kamar_id')
                        ->label('Kamar')
                        ->relationship('kamar', 'nama'),

                    // SCAN MEMBER (INPUT CEPAT 🔥)
                    Forms\Components\TextInput::make('member_scan')
                        ->label('Scan Member')
                        ->placeholder('Scan QR / input ID member...')
                        ->live()
                        ->afterStateUpdated(function ($state, $set) {
                            if ($state) {
                                $member = Member::where('kode_member', $state)->first();
                                if ($member) {
                                    $set('member_id', $member->id);
                                }
                            }
                        }),

                    Forms\Components\Select::make('member_id')
                        ->label('Member')
                        ->relationship('member', 'nama')
                        ->searchable(),

                    Forms\Components\Select::make('terapis_id')
                        ->label('Terapis')
                        ->relationship('terapis', 'nama'),

                    Forms\Components\Select::make('status')
                        ->options([
                            'pending' => 'Pending',
                            'selesai' => 'Selesai',
                            'batal' => 'Batal',
                        ])
                        ->default('pending')
                        ->required(),

                    Forms\Components\Select::make('pembayaran')
                        ->options([
                            'cash' => 'Cash',
                            'transfer' => 'Transfer',
                            'qris' => 'QRIS',
                        ])
                        ->required(),
                ]),

                Forms\Components\TextInput::make('voucher')
                    ->label('Voucher'),

                // HARGA SECTION
                Forms\Components\Grid::make(3)->schema([

                    Forms\Components\TextInput::make('harga')
                        ->numeric()
                        ->prefix('Rp')
                        ->live()
                        ->afterStateUpdated(function ($set, $get) {
                            $set('profit', (int) $get('harga') - (int) $get('biaya'));
                        })
                        ->required(),

                    Forms\Components\TextInput::make('biaya')
                        ->numeric()
                        ->prefix('Rp')
                        ->live()
                        ->afterStateUpdated(function ($set, $get) {
                            $set('profit', (int) $get('harga') - (int) $get('biaya'));
                        }),

                    Forms\Components\TextInput::make('profit')
                        ->numeric()
                        ->prefix('Rp')
                        ->disabled()
                        ->dehydrated(),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('waktu')->dateTime(),
                Tables\Columns\TextColumn::make('kode_transaksi')->label('ID'),
                Tables\Columns\TextColumn::make('cabang.nama'),
                Tables\Columns\TextColumn::make('kasir.name'),
                Tables\Columns\TextColumn::make('nama_tamu'),
                Tables\Columns\TextColumn::make('status'),
                Tables\Columns\TextColumn::make('pembayaran'),
                Tables\Columns\TextColumn::make('harga')->money('IDR'),
                Tables\Columns\TextColumn::make('profit')->money('IDR'),
            ])

            // 🔥 FILTER TANGGAL (SESUAI UI KAMU)
            ->filters([
                Tables\Filters\Filter::make('tanggal')
                    ->form([
                        Forms\Components\DatePicker::make('from'),
                        Forms\Components\DatePicker::make('to'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['from'], fn ($q) => $q->whereDate('waktu', '>=', $data['from']))
                            ->when($data['to'], fn ($q) => $q->whereDate('waktu', '<=', $data['to']));
                    }),
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
            'index' => Pages\ListTransaksis::route('/'),
            'create' => Pages\CreateTransaksi::route('/create'),
            'edit' => Pages\EditTransaksi::route('/{record}/edit'),
        ];
    }
}
