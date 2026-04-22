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