<x-filament::page>

    <div class="grid grid-cols-2 gap-4">

        <!-- SELECT NAMA VOUCHER -->
        <select wire:model="paket_id" class="w-full border rounded p-2">
            <option value="">-- Pilih voucher yang akan digenerate --</option>

            @foreach(\App\Models\Paket::all() as $paket)
                <option value="{{ $paket->id }}">
                    {{ $paket->nama }}
                </option>
            @endforeach
        </select>

        <!-- INPUT JUMLAH -->
        <div class="flex gap-2">
            <input type="number"
                   wire:model="jumlah"
                   class="border rounded p-2 w-full"
                   placeholder="Masukan jumlah">

            <button wire:click="generate"
                    class="bg-blue-600 text-white px-4 rounded">
                Generate
            </button>
        </div>

    </div>

    <!-- EXPORT -->
    <div class="mt-4">
        <button wire:click="exportPdf"
                class="bg-purple-600 text-white px-4 py-2 rounded">
            Export PDF
        </button>
    </div>

    <!-- TABLE -->
    <div class="mt-6">
        <h2 class="text-lg font-bold">Voucher Yang Sudah Dibuat</h2>

        <table class="w-full mt-2 border">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>
                @foreach(\App\Models\Voucher::latest()->take(20)->get() as $v)
                    <tr>
                        <td>{{ $v->kode }}</td>
                        <td>{{ $v->is_used ? 'Dipakai' : 'Belum' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</x-filament::page>