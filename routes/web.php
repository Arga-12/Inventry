<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function() {
    return view('peminjam.dashboard');
});

Route::get('/peminjaman', function() {
    return view('peminjam.peminjaman');
});