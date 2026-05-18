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
use App\Http\Controllers\Admin\KategoriController as AdminKategori;
use App\Http\Controllers\Admin\AlatbarangController as AdminAlat;
use App\Http\Controllers\Admin\PeminjamanController as AdminPeminjaman;
use App\Http\Controllers\Admin\PengembalianController as AdminPengembalian;

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

    //Dashboard
    Route::get('/admin/dashboard', [AdminDashboard::class, 'index'])->name('admin-home');

    //Kategori
    Route::get('/admin/kategori', [AdminKategori::class, 'index'])->name('admin-kategori');

    Route::get('/admin/kategori/create', [AdminKategori::class, 'create'])->name('admin-kategori-create');
    Route::post('/admin/kategori/create', [AdminKategori::class, 'store'])->name('admin-kategori-store');

    Route::get('admin/kategori/{kategori}/edit', [AdminKategori::class, 'edit'])->name('admin-kategori-edit');
    Route::put('admin/kategori/{kategori}', [AdminKategori::class, 'update'])->name('admin-kategori-update');

    Route::delete('/admin/kategori/{kategori}',[AdminKategori::class, 'destroy'])->name('admin-kategori-destroy');

    //Alat Peminajaman
    Route::get('/admin/alat', [AdminAlat::class, 'index'])->name('admin-alat');

    Route::get('/admin/alat/create', [AdminAlat::class, 'create'])->name('admin-alat-create');
    Route::post('/admin/alat/create', [AdminAlat::class, 'store'])->name('admin-alat-store');

    Route::get('admin/alat/{alat}/edit', [AdminAlat::class, 'edit'])->name('admin-alat-edit');
    Route::put('admin/alat/{alat}', [AdminAlat::class, 'update'])->name('admin-alat-update');

    Route::delete('/admin/alat/{alat}',[AdminAlat::class, 'destroy'])->name('admin-alat-destroy');

    //Peminjaman
    Route::get('admin/peminjaman', [AdminPeminjaman::class, 'index'])->name('admin-peminjaman');

    Route::get('/admin/peminjaman/create', [AdminPeminjaman::class, 'create'])->name('admin-peminjaman-create');
    Route::post('/admin/peminjaman/create', [AdminPeminjaman::class, 'store'])->name('admin-peminjaman-store');

    Route::get('/admin/peminjaman/{peminjaman}/edit', [AdminPeminjaman::class, 'edit'])->name('admin-peminjaman-edit');
    Route::put('/admin/peminjaman/{peminjaman}', [AdminPeminjaman::class, 'update'])->name('admin-peminjaman-update');

    Route::delete('/admin/peminjaman/{peminjaman}', [AdminPeminjaman::class, 'destroy'])->name('admin-peminjaman-destroy');

    //Pengembalian
    Route::get('admin/pengembalian', [AdminPengembalian::class, 'index'])->name('admin-pengembalian');

    Route::get('/admin/pengembalian/create', [AdminPengembalian::class, 'create'])->name('admin-pengembalian-create');
    Route::post('/admin/pengembalian/create', [AdminPengembalian::class, 'store'])->name('admin-pengembalian-store');

    Route::get('/admin/pengembalian/{pengembalian}/edit', [AdminPengembalian::class, 'edit'])->name('admin-pengembalian-edit');
    Route::put('/admin/pengembalian/{pengembalian}', [AdminPengembalian::class, 'update'])->name('admin-pengembalian-update');

    Route::delete('/admin/pengembalian/{pengembalian}', [AdminPengembalian::class, 'destroy'])->name('admin-pengembalian-destroy');
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

Route::get('/logaktivitas-admin', function() {
    return view('admin.logaktivitas');
})->name('admin-logakivitas');

Route::get('/create-admin', function() {
    return view('admin.alatbarang.create');
})->name('admin-create');