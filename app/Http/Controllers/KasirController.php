<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// ❗ Pakai try-catch biar tidak error kalau model belum ada
use App\Models\Transaksi;
use App\Models\Member;
use App\Models\Terapis;
use App\Models\Kamar;
use App\Models\Produk;

class KasirController extends Controller
{
    public function index()
    {
        // ✅ MEMBERS
        try {
            $members = Member::all();
        } catch (\Throwable $e) {
            $members = collect([
                (object)['id'=>1,'nama'=>'John Doe','no_hp'=>'08123'],
            ]);
        }

        // ✅ TERAPIS
        try {
            $terapis = Terapis::all();
        } catch (\Throwable $e) {
            $terapis = collect([
                (object)['id'=>1,'nama'=>'Budi'],
            ]);
        }

        // ✅ KAMAR
        try {
            $kamars = Kamar::all();
        } catch (\Throwable $e) {
            $kamars = collect([
                (object)['id'=>1,'nama'=>'LT 1'],
            ]);
        }

        // ✅ LAYANAN
        try {
            $layanans = Produk::all();
        } catch (\Throwable $e) {
            $layanans = collect([
                (object)['id'=>1,'nama'=>'Massage','harga'=>100000],
            ]);
        }

        // ✅ TRANSAKSI
        try {
            $transaksis = Transaksi::with(['kamar','terapis'])->latest()->get();
        } catch (\Throwable $e) {
            $transaksis = collect([]);
        }

        return view('kasir.index', compact(
            'members',
            'terapis',
            'kamars',
            'layanans',
            'transaksis'
        ));
    }

    public function store(Request $request)
    {
        try {
            $layanan = Produk::find($request->layanan_id);

            Transaksi::create([
                'kode_transaksi' => 'TRX-' . time(),
                'waktu' => now(),
                'member_id' => $request->member_id,
                'nama_tamu' => $request->nama_tamu,
                'terapis_id' => $request->terapis_id,
                'kamar_id' => $request->kamar_id,
                'harga' => $layanan->harga ?? 0,
                'status' => 'pending'
            ]);

            return back()->with('success', 'Booking berhasil');
        } catch (\Throwable $e) {
            return back()->with('error', 'Masih mode dummy (belum connect DB)');
        }
    }

    public function bayar($id)
    {
        try {
            $trx = Transaksi::findOrFail($id);
            $trx->status = 'lunas';
            $trx->save();

            return back()->with('success', 'Transaksi dibayar');
        } catch (\Throwable $e) {
            return back()->with('error', 'Data belum tersimpan di DB');
        }
    }
}