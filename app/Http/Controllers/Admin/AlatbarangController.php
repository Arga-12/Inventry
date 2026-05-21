<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alat;
use App\Models\DetailPeminjaman;
use App\Models\Kategori;
use App\Models\Log;
use Illuminate\Http\Request;
// Log
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AlatbarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // return view dan data datanya
        // tangkap inputan dari URL karena pake method GET (?search=...&kategori_id=...)
        $search = $request->input('search');
        $kategori_id = $request->input('kategori_id');
        $durasi = $request->input('durasi');

        $search_stok = $request->input('search_stok');
        $kategori_stok = $request->input('kategori_stok');

        // ambil data kategori untuk dropdown filter & statistik
        $kategori = Kategori::withCount('alat')->get();

        // buat Base Query dengan Eager Loading
        $alat = Alat::with('kategori')
            ->when($search, function ($query, $search) {
                // pencarian berdasarkan nama_alat
                return $query->where('nama_alat', 'like', '%'.$search.'%');
            })
            ->when($kategori_id, function ($query, $kategori_id) {
                // filter berdasarkan kategori
                return $query->where('kategori_id', $kategori_id);
            })
            ->when($durasi, function ($query, $durasi) {
                // cari berdasarkan durasi
                return $query->where('durasi', $durasi);
            })
            // eksekusi langsung search nya
            ->latest()
            ->get();

        // eksekusi query untuk Stok Menipis (tetap pakai base query yang sudah difilter)
        $stokmenipisRaw = Alat::with('kategori')->where('stok', '<=', 7)
            ->when($search_stok, function ($query, $search_stok) {
                return $query->where('nama_alat', 'like', '%'.$search_stok.'%');
            })
            ->when($kategori_stok, function ($query, $kategori_stok) {
                return $query->where('kategori_id', $kategori_stok);
            })->get();

        // view untuk stok menipis
        $totalstokmenipis = $stokmenipisRaw->count();

        $stokmenipis = $stokmenipisRaw;

        // view total stok yang ada
        $stoktotal = Alat::sum('stok');

        // view kategori yang ada dan count ada berapa item yang memiliki 1 kategori
        $kategori = Kategori::withCount('alat')->get();

        // total stok yang sedah dipoinjam
        $totalSedangDipinjam = DetailPeminjaman::whereHas('peminjaman', function ($query) {
            $query->whereIn('status', ['dipinjam', 'jatuh_tempo', 'terlambat']);
        })->sum('jumlah');

        return view('admin.alatbarang.index', compact('alat', 'stokmenipis', 'totalstokmenipis', 'stoktotal', 'kategori', 'totalSedangDipinjam'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // return view form create
        $kategori = Kategori::all();

        return view('admin.alatbarang.create', compact('kategori'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validate request an admin
        $valid = $request->validate([
            'nama_alat' => 'required|string',
            'kategori_id' => 'required|exists:kategori,id',
            'stok' => 'required|integer|min:1',
            'gambar' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:10240',
            'durasi' => 'required|integer',
        ], [
            'gambar.max' => 'File melebihi batas 10MB!',
        ]);

        // buat form kosong atau blueprint seperti model alat / table alat
        $alat = new Alat;

        // isi setiap kolom sesuai valid-request
        $alat->nama_alat = $valid['nama_alat'];
        $alat->kategori_id = $valid['kategori_id'];
        $alat->stok = $valid['stok'];
        $alat->durasi = $valid['durasi'];

        // logic upload gambar ke storage
        if ($request->hasFile('gambar')) {
            // simpan di folder public yang udah di symlink dengan folder storage
            $path = $request->file('gambar')->store('gambar_alat', 'public');

            $alat->gambar = $path;
        }

        // logic untuk membuat unique kode alat
        $last = Alat::max('id') + 1;
        $kategori = Kategori::find($valid['kategori_id']);

        // substr() ambil char tertentu, mula dari index 0 kosong hingga 1, terambil 1 char
        $inisial = strtoupper(substr($kategori->nama_kategori, 0, 1));
        $kode = $inisial.str_pad($last, 3, '0', STR_PAD_LEFT);

        $alat->kode_alat = $kode;

        // masukin ke tabel
        $alat->save();

        Log::create([
            'user_id' => Auth::id(),
            'role' => Auth::user()->role,
            'modul' => 'alat',
            'aksi' => 'create',
            'target' => $alat->nama_alat,
            'keterangan' => 'Admin menambahkan alat baru dengan kode '.$alat->kode_alat,
            'status' => 'success',
        ]);

        // we backl
        return redirect()->route('admin-alat')->with('success', 'Alat baru berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Alat $alat)
    {
        // return view data alat dari binding route model, dan kategori untuk form select kategori
        $kategori = Kategori::all();

        return view('admin.alatbarang.edit', compact('alat', 'kategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Alat $alat)
    {
        // validate request an admin
        $valid = $request->validate([
            'nama_alat' => 'required|string',
            'kategori_id' => 'required|exists:kategori,id',
            'stok' => 'required|integer|min:1',
            'gambar' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:10240',
            'durasi' => 'required|integer',
        ], [
            'gambar.max' => 'File melebihi batas 10MB!',
        ]);

        // isi setiap kolom sesuai valid-request
        $alat->nama_alat = $valid['nama_alat'];
        $alat->kategori_id = $valid['kategori_id'];
        $alat->stok = $valid['stok'];
        $alat->durasi = $valid['durasi'];

        // logic upload gambar ke storage
        if ($request->hasFile('gambar')) {
            // hapus fiile lama jika ada
            if ($alat->gambar) {
                Storage::disk('public')->delete($alat->gambar);
            }

            // simpan di folder public yang udah di symlink dengan folder storage
            $path = $request->file('gambar')->store('gambar_alat', 'public');

            $alat->gambar = $path;
        }

        // simpan lagi ke database langsung
        $alat->save();

        Log::create([
            'user_id' => Auth::id(),
            'role' => Auth::user()->role,
            'modul' => 'alat',
            'aksi' => 'update',
            'target' => $alat->nama_alat,
            'keterangan' => 'Admin memperbarui data alat.',
            'status' => 'success',
        ]);

        // return kembali ke laman admin-alat
        return redirect()->route('admin-alat')->with('success', 'Data alat berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Alat $alat)
    {
        // cek apakah alat ini punya relasi di tabel detail_peminjaman
        // yang statusnya belum 'dikembalikan'
        $sedangDipinjam = $alat->detailPeminjaman()
            ->whereIn('status', ['menunggu', 'dipinjam', 'jatuh_tempo', 'terlambat'])
            ->exists();

        if ($sedangDipinjam) {

            Log::create([
                'user_id' => Auth::id(),
                'role' => Auth::user()->role,
                'modul' => 'alat',
                'aksi' => 'delete',
                'target' => $alat->nama_alat,
                'keterangan' => 'Gagal menghapus alat karena masih dipinjam.',
                'status' => 'warning',
            ]);

            return back()->with('error', 'Alat tidak bisa dihapus karena masih dalam status dipinjam atau menunggu persetujuan!');
        }

        // iffff aman, baru hapus gambar dan datanya
        if ($alat->gambar) {
            Storage::disk('public')->delete($alat->gambar);
        }

        Log::create([
            'user_id' => Auth::id(),
            'role' => Auth::user()->role,
            'modul' => 'alat',
            'aksi' => 'delete',
            'target' => $alat->nama_alat,
            'keterangan' => 'Admin menghapus alat.',
            'status' => 'warning',
        ]);

        $alat->delete();

        return redirect()->route('admin-alat')->with('success', 'Data alat berhasil dihapus');
    }
}
