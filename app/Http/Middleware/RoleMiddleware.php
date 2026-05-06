<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KasirController;

/*
|--------------------------------------------------------------------------
| ROOT
|--------------------------------------------------------------------------
*/

Route::get('/', function () {

    if (request()->getHost() == 'cashier.alunprima.co.id') {
        return redirect('/cashier/login');
    }

    return redirect('/admin/login');
});

/*
|--------------------------------------------------------------------------
| CMS / FILAMENT
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/admin-dashboard', function () {
        return view('admin.dashboard');
    });

});

/*
|--------------------------------------------------------------------------
| CASHIER
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:kasir'])->group(function () {

    Route::get('/kasir', [KasirController::class, 'index'])
        ->name('kasir.index');

    Route::post('/kasir/store', [KasirController::class, 'store'])
        ->name('kasir.store');

    Route::post('/kasir/bayar/{id}', [KasirController::class, 'bayar'])
        ->name('kasir.bayar');

});