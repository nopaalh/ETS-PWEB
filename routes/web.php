<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GunungController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\CheckoutController;
use Illuminate\Http\Request;
use Carbon\Carbon;

/*
|--------------------------------------------------------------------------
| 🌍 HALAMAN PUBLIC
|--------------------------------------------------------------------------
*/
Route::view('/', 'pages.home')->name('landing');

/*
|--------------------------------------------------------------------------
| 🔐 HALAMAN UNTUK USER YANG LOGIN
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard utama user
    Route::view('/dashboard', 'dashboard')->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | 🏔️ GUNUNG ROUTES
    |--------------------------------------------------------------------------
    */
    Route::get('/mountain', [GunungController::class, 'index'])->name('mountain.index');
    Route::get('/mountain/{id}', [GunungController::class, 'show'])->name('mountain.show');

    /*
    |--------------------------------------------------------------------------
    | 💚 FAVORITE ROUTES
    |--------------------------------------------------------------------------
    */
    Route::get('/favorite', [FavoriteController::class, 'index'])->name('favorite.index');
    Route::post('/favorite/toggle/{gunung}', [FavoriteController::class, 'toggle'])->name('favorite.toggle');

    /*
    |--------------------------------------------------------------------------
    | 🕒 HISTORY ROUTES
    |--------------------------------------------------------------------------
    */
    Route::view('/history', 'pages.history.index')->name('history.index');

    /*
    |--------------------------------------------------------------------------
    | 🎟️ CHECKOUT ROUTES (Database-based)
    |--------------------------------------------------------------------------
    */
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::get('/checkout/create', [CheckoutController::class, 'create'])->name('checkout.create');
    Route::post('/checkout/store', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/success/{kodeBooking}', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('/checkout/edit/{kodeBooking}', [CheckoutController::class, 'edit'])->name('checkout.edit');
    Route::put('/checkout/update/{kodeBooking}', [CheckoutController::class, 'update'])->name('checkout.update');
    Route::get('/checkout/cancel/{kodeBooking}', [CheckoutController::class, 'cancelPage'])->name('checkout.cancel');
    Route::post('/checkout/cancel/{kodeBooking}', [CheckoutController::class, 'cancelProcess'])->name('checkout.cancel.process');
    Route::delete('/checkout/destroy/{kodeBooking}', [CheckoutController::class, 'destroy'])->name('checkout.destroy');

    /*
    |--------------------------------------------------------------------------
    | 👑 ADMIN ROUTES
    |--------------------------------------------------------------------------
    */
    Route::middleware(['admin'])->group(function () {
        // Testing middleware admin
        Route::get('/admin-test', function () {
            return "🎉 HALO ADMIN! Middleware berhasil!";
        })->name('admin.test');

        // CRUD data gunung
        Route::get('/admin/gunungs/create', [GunungController::class, 'create'])->name('admin.gunungs.create');
        Route::post('/admin/gunungs', [GunungController::class, 'store'])->name('admin.gunungs.store');
        Route::get('/admin/gunungs/{gunung}/edit', [GunungController::class, 'edit'])->name('admin.gunungs.edit');
        Route::put('/admin/gunungs/{gunung}', [GunungController::class, 'update'])->name('admin.gunungs.update');
        Route::delete('/admin/gunungs/{gunung}', [GunungController::class, 'destroy'])->name('admin.gunungs.destroy');
        Route::get('/admin/dashboard', [GunungController::class, 'dashboard'])->name('admin.dashboard');
    });
});

/*
|--------------------------------------------------------------------------
| 🔑 AUTH ROUTES (BREEZE)
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';
