<?php

use Illuminate\Support\Facades\Route;

// Halaman publik
Route::view('/', 'pages.home')->name('landing');
Route::view('/gunung', 'pages.gunung.index')->name('gunung.index');
Route::view('/pesanan', 'pages.pesanan.index')->name('pesanan.index');
Route::view('/favorit', 'pages.favorit.index')->name('favorit.index');
Route::view('/riwayat', 'pages.riwayat.index')->name('riwayat.index');

// Tambahkan route untuk dashboard di sini
Route::view('/dashboard', 'dashboard')->name('dashboard');

// Route default untuk login/register Breeze
require __DIR__.'/auth.php';
