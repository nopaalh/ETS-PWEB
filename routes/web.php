<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GunungController;
use App\Http\Controllers\TicketBookingController;
use App\Http\Controllers\FavoriteController;

Route::view('/', 'pages.home')->name('landing');

Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard & gunung
    Route::view('/dashboard', 'dashboard')->name('dashboard');
    Route::get('/mountain', [GunungController::class, 'index'])->name('mountain.index');
    Route::get('/mountain/{id}', [GunungController::class, 'show'])->name('mountain.show');

    // Favorite
    Route::get('/favorite', [FavoriteController::class, 'index'])->name('favorite.index');
    Route::post('/favorite/toggle/{gunung}', [FavoriteController::class, 'toggle'])->name('favorite.toggle');

    // Semua proses pemesanan tiket (checkout)
    Route::controller(TicketBookingController::class)->group(function () {
        Route::get('/checkout', 'index')->name('checkout.index');
        Route::get('/checkout/create', 'create')->name('checkout.create');
        Route::post('/checkout/store', 'store')->name('checkout.store');
        Route::get('/checkout/success', 'success')->name('checkout.success');
        Route::get('/checkout/edit/{code}', 'edit')->name('checkout.edit');
        Route::post('/checkout/update/{code}', 'update')->name('checkout.update');
        Route::get('/checkout/cancel/{code}', 'cancelForm')->name('checkout.cancel');
        Route::post('/checkout/cancel/{code}', 'cancel')->name('checkout.cancel.post');
        Route::get('/checkout/{code}', 'show')->name('checkout.show');
    });

    // Riwayat pendakian
    Route::view('/history', 'pages.history.index')->name('history.index');
    Route::get('/history', [TicketBookingController::class, 'history'])->name('history.index');

    // Admin area
    Route::middleware(['admin'])->group(function () {
        Route::get('/admin-test', fn() => "🎉 HALO ADMIN! Middleware berhasil!")->name('admin.test');

        Route::get('/admin/gunungs/create', [GunungController::class, 'create'])->name('admin.gunungs.create');
        Route::post('/admin/gunungs', [GunungController::class, 'store'])->name('admin.gunungs.store');
        Route::get('/admin/gunungs/{gunung}/edit', [GunungController::class, 'edit'])->name('admin.gunungs.edit');
        Route::put('/admin/gunungs/{gunung}', [GunungController::class, 'update'])->name('admin.gunungs.update');
        Route::delete('/admin/gunungs/{gunung}', [GunungController::class, 'destroy'])->name('admin.gunungs.destroy');
        Route::get('/admin/dashboard', [GunungController::class, 'dashboard'])->name('admin.dashboard');
    });
});

require __DIR__.'/auth.php';