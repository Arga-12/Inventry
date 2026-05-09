<?php

use Illuminate\Support\Facades\Route;

//Middleware
use App\Http\Middleware\RoleMiddleware;

//Login
use App\Http\Controllers\AuthController;

//Peminjam
use App\Http\Controllers\Peminjam\DashboardController as PeminjamDashboard;
use App\Http\Controllers\Peminjam\PeminjamanController as PeminjamPeminjaman;
use App\Http\Controllers\Peminjam\PengembalianController as PeminjamPengembalian;

//Petugas
use App\Http\Controllers\Petugas\DashboardController as PetugasDashboard;

//Admin
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;

Route::get('/', function () {
    return view('welcome');
});

//Route login woyyyyyyyyyy
Route::get('/login', [AuthController::class, 'loginView'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

//Route logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

//Route middleware Admin
Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/admin/dashboard', [AdminDashboard::class, 'index'])->name('admin-home');
});

//Route middleware Petugas
Route::middleware(['auth', 'role:petugas'])->group(function () {

    Route::get('/petugas/dashboard', [PetugasDashboard::class, 'index']);
});

//Route middleware Peminjam
Route::middleware(['auth', 'role:peminjam'])->group(function () {

    Route::get('/dashboard', [PeminjamDashboard::class, 'index'])->name('peminjam-home');
    Route::get('/peminjaman', [PeminjamPeminjaman::class, 'index'])->name('peminjam-alat');
    Route::get('/pengembalian', [PeminjamPengembalian::class, 'index'])->name('peminjam-pengembalian');
});

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

Route::get('/users-admin', function() {
    return view('admin.users.index');
})->name('admin-users');

Route::get('/alat-admin', function() {
    return view('admin.alatbarang.index');
})->name('admin-alat');

Route::get('/peminjaman-admin', function() {
    return view('admin.peminjaman.index');
})->name('admin-peminjaman');

Route::get('/pengembalian-admin', function() {
    return view('admin.pengembalian.index');
})->name('admin-pengembalian');

Route::get('/logaktivitas-admin', function() {
    return view('admin.logaktivitas');
})->name('admin-logakivitas');

Route::get('/create-admin', function() {
    return view('admin.alatbarang.create');
})->name('admin-create');