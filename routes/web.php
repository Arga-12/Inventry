<?php

use App\Http\Controllers\Admin\AlatbarangController as AdminAlat;
// Middleware

// Login
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
// Preferensi all role
use App\Http\Controllers\Admin\KategoriController as AdminKategori;
// Peminjam
use App\Http\Controllers\Admin\LogController as AdminLog;
use App\Http\Controllers\Admin\PeminjamanController as AdminPeminjaman;
use App\Http\Controllers\Admin\PengembalianController as AdminPengembalian;
use App\Http\Controllers\Admin\PenggunaController as AdminPengguna;
// Petugas
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Peminjam\AlatPinjamController as AlatPinjamPeminjaman;
use App\Http\Controllers\Peminjam\DashboardController as PeminjamDashboard;
use App\Http\Controllers\Peminjam\PeminjamanController as PeminjamPeminjaman;
// Admin
use App\Http\Controllers\Peminjam\PengembalianController as PeminjamPengembalian;
use App\Http\Controllers\Petugas\DashboardController as PetugasDashboard;
use App\Http\Controllers\Petugas\LaporanController as PetugasLaporan;
use App\Http\Controllers\Petugas\PeminjamanController as PetugasPeminjaman;
use App\Http\Controllers\Petugas\PengembalianController as PetugasPengembalian;
use App\Http\Controllers\ProfilController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route login woyyyyyyyyyy
Route::get('/login', [AuthController::class, 'loginView'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Route logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route middleware Admin
Route::middleware(['auth', 'role:admin'])->group(function () {

    // Dashboard
    Route::get('/admin/dashboard', [AdminDashboard::class, 'index'])->name('admin-home');

    // Log
    Route::get('/admin/log', [AdminLog::class, 'index'])->name('admin-log');

    // Kategori
    Route::get('/admin/kategori', [AdminKategori::class, 'index'])->name('admin-kategori');

    Route::get('/admin/kategori/create', [AdminKategori::class, 'create'])->name('admin-kategori-create');
    Route::post('/admin/kategori/create', [AdminKategori::class, 'store'])->name('admin-kategori-store');

    Route::get('admin/kategori/{kategori}/edit', [AdminKategori::class, 'edit'])->name('admin-kategori-edit');
    Route::put('admin/kategori/{kategori}', [AdminKategori::class, 'update'])->name('admin-kategori-update');

    Route::delete('/admin/kategori/{kategori}', [AdminKategori::class, 'destroy'])->name('admin-kategori-destroy');

    // Alat Peminajaman
    Route::get('/admin/alat', [AdminAlat::class, 'index'])->name('admin-alat');

    Route::get('/admin/alat/create', [AdminAlat::class, 'create'])->name('admin-alat-create');
    Route::post('/admin/alat/create', [AdminAlat::class, 'store'])->name('admin-alat-store');

    Route::get('admin/alat/{alat}/edit', [AdminAlat::class, 'edit'])->name('admin-alat-edit');
    Route::put('admin/alat/{alat}', [AdminAlat::class, 'update'])->name('admin-alat-update');

    Route::delete('/admin/alat/{alat}', [AdminAlat::class, 'destroy'])->name('admin-alat-destroy');

    // Peminjaman
    Route::get('admin/peminjaman', [AdminPeminjaman::class, 'index'])->name('admin-peminjaman');

    Route::get('/admin/peminjaman/create', [AdminPeminjaman::class, 'create'])->name('admin-peminjaman-create');
    Route::post('/admin/peminjaman/create', [AdminPeminjaman::class, 'store'])->name('admin-peminjaman-store');

    Route::get('/admin/peminjaman/{peminjaman}/edit', [AdminPeminjaman::class, 'edit'])->name('admin-peminjaman-edit');
    Route::put('/admin/peminjaman/{peminjaman}', [AdminPeminjaman::class, 'update'])->name('admin-peminjaman-update');

    Route::delete('/admin/peminjaman/{peminjaman}', [AdminPeminjaman::class, 'destroy'])->name('admin-peminjaman-destroy');

    // Pengembalian
    Route::get('admin/pengembalian', [AdminPengembalian::class, 'index'])->name('admin-pengembalian');

    Route::get('/admin/pengembalian/create', [AdminPengembalian::class, 'create'])->name('admin-pengembalian-create');
    Route::post('/admin/pengembalian/create', [AdminPengembalian::class, 'store'])->name('admin-pengembalian-store');

    Route::get('/admin/pengembalian/{pengembalian}/edit', [AdminPengembalian::class, 'edit'])->name('admin-pengembalian-edit');
    Route::put('/admin/pengembalian/{pengembalian}', [AdminPengembalian::class, 'update'])->name('admin-pengembalian-update');

    Route::delete('/admin/pengembalian/{pengembalian}', [AdminPengembalian::class, 'destroy'])->name('admin-pengembalian-destroy');

    // Pengguna
    Route::get('admin/pengguna', [AdminPengguna::class, 'index'])->name('admin-pengguna');

    Route::get('/admin/pengguna/create', [AdminPengguna::class, 'create'])->name('admin-pengguna-create');
    Route::post('/admin/pengguna/create', [AdminPengguna::class, 'store'])->name('admin-pengguna-store');

    Route::get('/admin/pengguna/{pengguna}/edit', [AdminPengguna::class, 'edit'])->name('admin-pengguna-edit');
    Route::put('/admin/pengguna/{pengguna}', [AdminPengguna::class, 'update'])->name('admin-pengguna-update');

    Route::delete('/admin/pengguna/{pengguna}', [AdminPengguna::class, 'destroy'])->name('admin-pengguna-destroy');
});

// Route middleware Petugas
Route::middleware(['auth', 'role:petugas'])->group(function () {

    // Dashboard
    Route::get('/petugas/dashboard', [PetugasDashboard::class, 'index'])->name('petugas-home');

    // Peminjaman
    Route::get('petugas/peminjaman', [PetugasPeminjaman::class, 'index'])->name('petugas-peminjaman');
    Route::put('petugas/peminjaman/{peminjaman}/update', [PetugasPeminjaman::class, 'update'])->name('petugas-peminjaman-update');
    Route::put('petugas/peminjaman/{peminjaman}/tolak', [PetugasPeminjaman::class, 'tolak'])->name('petugas-peminjaman-tolak');

    // Pengembalian
    Route::get('petugas/pengembalian', [PetugasPengembalian::class, 'index'])->name('petugas-pengembalian');
    Route::put('petugas/pengembalian/{pengembalian}/update', [PetugasPengembalian::class, 'update'])->name('petugas-pengembalian-update');

    // Laporan
    Route::get('petugas/laporan', [PetugasLaporan::class, 'index'])->name('petugas-laporan');
    Route::prefix('petugas/laporan')->group(function () {
        Route::get('/export-peminjaman-excel', [PetugasLaporan::class, 'exportPeminjamanExcel'])
            ->name('laporan-export-peminjaman-excel');
        Route::get('/export-peminjaman-pdf', [PetugasLaporan::class, 'exportPeminjamanPDF'])
            ->name('laporan-export-peminjaman-pdf');

        Route::get('/export-pengembalian-excel', [PetugasLaporan::class, 'exportPengembalianExcel'])
            ->name('laporan-export-pengembalian-excel');
        Route::get('/export-pengembalian-pdf', [PetugasLaporan::class, 'exportPengembalianPDF'])
            ->name('laporan-export-pengembalian-pdf');
    });
});

// Route middleware Peminjam
Route::middleware(['auth', 'role:peminjam'])->group(function () {

    // Home
    Route::get('/dashboard', [PeminjamDashboard::class, 'index'])->name('peminjam-home');
    Route::get('/peminjam/search-alat', [PeminjamDashboard::class, 'searchAlat'])->name('peminjam-search-alat');

    // AlatPinjam - pakai alias yang sudah didefinisikan
    Route::get('/alat-pinjam', [AlatPinjamPeminjaman::class, 'index'])->name('peminjam-alat');
    Route::post('/alat-pinjam/store', [AlatPinjamPeminjaman::class, 'store'])->name('peminjam-alat-store');

    // Peminjaman
    Route::get('/peminjaman', [PeminjamPeminjaman::class, 'index'])->name('peminjam-peminjaman');
    Route::post('/peminjaman/{kode_peminjaman}/kembalikan', [PeminjamPeminjaman::class, 'ajukanPengembalian'])->name('peminjam.pengembalian.ajukan');

    // Pengembalian
    Route::get('/pengembalian', [PeminjamPengembalian::class, 'index'])->name('peminjam-pengembalian');
});

// Profile / Preference (untuk semua role yang sudah login)
Route::middleware(['auth'])->group(function () {
    Route::get('/profil', [ProfilController::class, 'edit'])->name('profil-edit');
    Route::put('/profil', [ProfilController::class, 'update'])->name('profil-update');
});

Route::get('/home-admin', function () {
    return view('admin.dashboard');
})->name('test-admin-home');

Route::get('/logaktivitas-admin', function () {
    return view('admin.logaktivitas');
})->name('admin-logakivitas');

Route::get('/create-admin', function () {
    return view('admin.alatbarang.create');
})->name('admin-create');
