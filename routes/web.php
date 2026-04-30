<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function() {
    return view('peminjam.dashboard');
})->name('peminjam-home');

Route::get('/peminjaman', function() {
    return view('peminjam.peminjaman');
})->name('peminjam-alat');

Route::get('/pengembalian', function() {
    return view('peminjam.pengembalian');
})->name('peminjam-pengembalian');

Route::get('/preferensi', function() {
    return view('peminjam.preferensi');
})->name('peminjam-preferensi');


// Petugas

Route::get('/home-petugas', function() {
    return view('petugas.dashboard');
})->name('petugas-home');

Route::get('/home-peminjaman', function() {
    return view('petugas.peminjaman');
})->name('petugas-peminjaman');

Route::get('/home-pengembalian', function() {
    return view('petugas.pengembalian');
})->name('petugas-pengembalian');

Route::get('/home-laporan', function() {
    return view('petugas.laporan');
})->name('petugas-laporan');

// Admin

Route::get('/home-admin', function() {
    return view('admin.dashboard');
})->name('admin-home');