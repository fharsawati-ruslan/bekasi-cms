<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KasirController;

Route::get('/', function () {
    return view('welcome');
});

// Kasir
Route::get('/kasir', [KasirController::class, 'index'])->name('kasir.index');
Route::post('/kasir/store', [KasirController::class, 'store'])->name('kasir.store');
Route::post('/kasir/bayar/{id}', [KasirController::class, 'bayar'])->name('kasir.bayar');

