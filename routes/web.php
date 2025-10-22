<?php

use Illuminate\Support\Facades\Route;

// page for public
Route::view('/', 'pages.home')->name('landing');

// page after login
Route::middleware(['auth', 'verified'])->group(function () {

    Route::view('/dashboard', 'dashboard')->name('dashboard');
    Route::view('/mountain', 'pages.mountain.index')->name('mountain.index');
    Route::view('/checkout', 'pages.checkout.index')->name('checkout.index');
    Route::view('/favorite', 'pages.favorite.index')->name('favorite.index');
    Route::view('/history', 'pages.history.index')->name('history.index');
});

// Route default untuk login/register Breeze
require __DIR__.'/auth.php';
