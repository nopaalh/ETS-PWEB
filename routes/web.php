<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GunungController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HistoryController;
use Illuminate\Http\Request;
use Carbon\Carbon;

Route::view('/', 'pages.home')->name('landing');
Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('/dashboard', 'dashboard')->name('dashboard');
    Route::get('/mountain', [GunungController::class, 'index'])->name('mountain.index');
    Route::get('/mountain/{id}', [GunungController::class, 'show'])->name('mountain.show');
    Route::get('/favorite', [FavoriteController::class, 'index'])->name('favorite.index');
    Route::post('/favorite/toggle/{gunung}', [FavoriteController::class, 'toggle'])->name('favorite.toggle');
    Route::get('/history', [HistoryController::class, 'index'])->name('history.index');
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::get('/checkout/create', [CheckoutController::class, 'create'])->name('checkout.create');
    Route::post('/checkout/store', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/success/{kodeBooking}', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('/checkout/edit/{kodeBooking}', [CheckoutController::class, 'edit'])->name('checkout.edit');
    Route::put('/checkout/update/{kodeBooking}', [CheckoutController::class, 'update'])->name('checkout.update');
    Route::get('/checkout/cancel/{kodeBooking}', [CheckoutController::class, 'cancelPage'])->name('checkout.cancel');
    Route::post('/checkout/cancel/{kodeBooking}', [CheckoutController::class, 'cancelProcess'])->name('checkout.cancel.process');
    Route::delete('/checkout/destroy/{kodeBooking}', [CheckoutController::class, 'destroy'])->name('checkout.destroy');

    Route::middleware(['admin'])->group(function () {
        Route::get('/admin-test', function () {
            return "🎉 HALO ADMIN! Middleware berhasil!";
        })->name('admin.test');

        Route::get('/admin/gunungs/create', [GunungController::class, 'create'])->name('admin.gunungs.create');
        Route::post('/admin/gunungs', [GunungController::class, 'store'])->name('admin.gunungs.store');
        Route::get('/admin/gunungs/{gunung}/edit', [GunungController::class, 'edit'])->name('admin.gunungs.edit');
        Route::get('/checkout/{kode_booking}', [CheckoutController::class, 'show'])->name('checkout.show');
        Route::put('/admin/gunungs/{gunung}', [GunungController::class, 'update'])->name('admin.gunungs.update');
        Route::delete('/admin/gunungs/{gunung}', [GunungController::class, 'destroy'])->name('admin.gunungs.destroy');
        Route::get('/admin/dashboard', [GunungController::class, 'dashboard'])->name('admin.dashboard');
        Route::post('/admin/checkout/update-status/{kodeBooking}', [CheckoutController::class, 'updateStatus'])->name('admin.checkout.update-status');
    });
});

require __DIR__.'/auth.php';