<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Actions\Action;

use App\Models\Paket;
use App\Models\Voucher;

class GenerateVoucher extends Page implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-bolt';
    protected static string $view = 'filament.pages.generate-voucher';

    protected static ?string $navigationGroup = 'Voucher';
    protected static ?string $navigationLabel = 'Generate Voucher';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    // ✅ FORM FILAMENT
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('paket_id')
                    ->label('Pilih Voucher')
                    ->options(Paket::pluck('nama', 'id'))
                    ->searchable()
                    ->required(),

                Forms\Components\TextInput::make('jumlah')
                    ->numeric()
                    ->default(1)
                    ->required(),
            ])
            ->statePath('data');
    }

    // ✅ ACTION GENERATE (INI TOMBOLNYA)
    protected function getFormActions(): array
    {
        return [
            Action::make('generate')
                ->label('Generate')
                ->color('primary')
                ->action(function () {

                    $paket_id = $this->data['paket_id'];
                    $jumlah = $this->data['jumlah'];

                    for ($i = 0; $i < $jumlah; $i++) {
                        Voucher::create([
                            'paket_id' => $paket_id,
                            'kode' => 'VCR-' . strtoupper(substr(uniqid(), -6)),
                        ]);
                    }

                    $this->notify('success', 'Voucher berhasil dibuat 🚀');
                }),

            Action::make('export')
                ->label('Export PDF')
                ->color('success')
                ->action(fn () => $this->exportPdf()),
        ];
    }

    public function exportPdf()
    {
        return response()->download(storage_path('app/voucher.pdf'));
    }
}