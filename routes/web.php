<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GunungController;
use App\Http\Controllers\PesananTiketController;
use Illuminate\Http\Request;
use Carbon\Carbon;

// Page for public
Route::view('/', 'pages.home')->name('landing');

// Page after login
Route::middleware(['auth', 'verified'])->group(function () {

    // Routes untuk semua user yang login
    Route::view('/dashboard', 'dashboard')->name('dashboard');
    Route::get('/mountain', [GunungController::class, 'index'])->name('mountain.index');
    Route::get('/mountain/{id}', [GunungController::class, 'show'])->name('mountain.show');
    Route::view('/favorite', 'pages.favorite.index')->name('favorite.index');
    Route::view('/history', 'pages.history.index')->name('history.index');

    // Pesanan Tiket routes
    Route::resource('pesanan', PesananTiketController::class);

    // Checkout routes
    Route::get('/checkout', function () {
        $bookings = session('bookings', []);
        return view('pages.checkout.index', compact('bookings'));
    })->name('checkout.index');

    Route::view('/checkout/create', 'pages.checkout.create')->name('checkout.create');

    Route::post('/checkout/store', function (Request $request) {
        $request->validate([
            'name' => 'required',
            'ktp' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'mountain_id' => 'required',
            'date' => 'required|date',
            'climber' => 'required|numeric|min:1',
            'duration' => 'required|numeric|min:1',
            'metode' => 'required',
            'amount' => 'required|numeric|min:1',
            'proof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $bookingCode = 'BK' . strtoupper(uniqid());
        $bookings = session('bookings', []);

        $newBooking = [
            'code' => $bookingCode,
            'name' => $request->name,
            'mountain_id' => $request->mountain_id,
            'date' => $request->date,
            'climber' => $request->climber,
            'duration' => $request->duration,
            'metode' => $request->metode,
            'amount' => $request->amount,
            'status' => 'Active',
        ];

        $bookings[$bookingCode] = $newBooking;
        session()->put('bookings', $bookings);

        return redirect()->route('checkout.success')->with('booking', $newBooking);
    })->name('checkout.store');

    // Booking success page
    Route::get('/checkout/success', function (Request $request) {
        $booking = session('booking');

        if (!$booking) {
            return redirect()->route('checkout.create')->with('error', 'Booking data not found.');
        }

        $climbDate = Carbon::parse($booking['date']);
        if (Carbon::now()->greaterThan($climbDate->addDays(7))) {
            $booking['status'] = 'Expired';
        }

        return view('pages.checkout.success', compact('booking'));
    })->name('checkout.success');

    // Edit booking
    Route::get('/checkout/edit/{code}', function ($code) {
        $bookings = session('bookings', []);
        if (!isset($bookings[$code])) {
            return redirect()->route('checkout.index')->with('error', 'Booking not found.');
        }
        $booking = $bookings[$code];
        return view('pages.checkout.edit', compact('booking'));
    })->name('checkout.edit');

    Route::post('/checkout/update/{code}', function (Request $request, $code) {
        $bookings = session('bookings', []);
        if (!isset($bookings[$code])) {
            return redirect()->route('checkout.index')->with('error', 'Booking not found.');
        }

        $bookings[$code]['name'] = $request->name;
        $bookings[$code]['date'] = $request->date;
        $bookings[$code]['climber'] = $request->climber;
        $bookings[$code]['duration'] = $request->duration;
        $bookings[$code]['amount'] = $request->amount;
        session()->put('bookings', $bookings);

        return redirect()->route('checkout.index')->with('success', 'Booking updated successfully.');
    })->name('checkout.update');

    // Cancel booking with refund & reason (2-step)
    Route::get('/checkout/cancel/{code}', function ($code) {
        $bookings = session('bookings', []);
        if (!isset($bookings[$code])) {
            return redirect()->route('checkout.index')->with('error', 'Booking not found.');
        }

        $booking = $bookings[$code];
        return view('pages.checkout.cancel', compact('booking'));
    })->name('checkout.cancel');

    Route::post('/checkout/cancel/{code}', function (Request $request, $code) {
        $bookings = session('bookings', []);
        if (!isset($bookings[$code])) {
            return redirect()->route('checkout.index')->with('error', 'Booking not found.');
        }

        $refundRate = 0.7; 
        $bookings[$code]['status'] = 'Cancelled';
        $bookings[$code]['reason'] = $request->reason;
        $bookings[$code]['refund'] = round($bookings[$code]['amount'] * $refundRate, 0);
        $bookings[$code]['refund_rate'] = $refundRate * 100;

        session()->put('bookings', $bookings);
        return redirect()->route('checkout.index')->with('success', 'Booking cancelled with partial refund.');
    })->name('checkout.cancel.process');

    // 🔹 ROUTES ADMIN ONLY - TAMBAHKAN INI
    Route::middleware(['admin'])->group(function () {
        // Route test admin
        Route::get('/admin-test', function () {
            return "🎉 HALO ADMIN! Middleware berhasil!";
        })->name('admin.test');

        // Routes untuk manage gunung (admin only)
        Route::get('/admin/gunungs/create', [GunungController::class, 'create'])->name('admin.gunungs.create');
        Route::post('/admin/gunungs', [GunungController::class, 'store'])->name('admin.gunungs.store');
        Route::get('/admin/gunungs/{gunung}/edit', [GunungController::class, 'edit'])->name('admin.gunungs.edit');
        Route::put('/admin/gunungs/{gunung}', [GunungController::class, 'update'])->name('admin.gunungs.update');
        Route::delete('/admin/gunungs/{gunung}', [GunungController::class, 'destroy'])->name('admin.gunungs.destroy');
        Route::get('/admin/dashboard', [GunungController::class, 'dashboard'])->name('admin.dashboard');
    });
});

// Auth routes (from Breeze)
require __DIR__.'/auth.php';