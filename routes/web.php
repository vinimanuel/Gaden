<?php

use App\Http\Controllers\BarangGadaiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\RiwayatController;
use Illuminate\Support\Facades\Route;

// Dashboard
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Barang Gadai
Route::resource('barang', BarangGadaiController::class);
Route::get( '/barang/{barang}/tebus',       [BarangGadaiController::class, 'tebusForm'])      ->name('barang.tebus.form');
Route::post('/barang/{barang}/tebus',       [BarangGadaiController::class, 'tebusStore'])     ->name('barang.tebus.store');
Route::get( '/barang/{barang}/perpanjang',  [BarangGadaiController::class, 'perpanjangForm']) ->name('barang.perpanjang.form');
Route::post('/barang/{barang}/perpanjang',  [BarangGadaiController::class, 'perpanjangStore'])->name('barang.perpanjang.store');

// Riwayat
Route::get('/riwayat',  [RiwayatController::class,  'index'])->name('riwayat.index');

// Keuangan
Route::get('/keuangan', [KeuanganController::class, 'index'])->name('keuangan.index');
