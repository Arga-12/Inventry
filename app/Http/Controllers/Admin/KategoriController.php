<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\Log;
// Log
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // untuk logic search
        $search = $request->input('search');

        // eloquent untuk searchnya dengan where melalui nama_kategori
        $kategori = Kategori::when($search, function ($query, $search) {
            return $query->where('nama_kategori', 'like', '%' . $search . '%');
        })->get();

        // return view index
        return view('admin.kategori.index', compact('kategori'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // return view create
        return view('admin.kategori.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validate request penambahan kategori
        $valid = $request->validate([
            'nama_kategori' => 'required|string|max:100',
            'warna' => 'required|string|max:20',
        ]);

        // bikin unique id sendiri
        $last = Kategori::max('id') + 1;
        // ::max('id') untuk menghindari duplikasi saat ada data yang dihapus

        $kode = 'KTG-' . str_pad($last, 3, '0', STR_PAD_LEFT);
        // strpad() (string yang akan dimasukkan, panjang string, padding kosong diisi apa?,rata dari kiri atau kanan)

        // logic menambahkan data
        $valid['kode_kategori'] = $kode;
        // tambahin dulu column kode katagorinya

        // baru ::create()
        $kategori = Kategori::create($valid);

        Log::create([
            'user_id' => Auth::id(),
            'role' => Auth::user()->role,
            'modul' => 'kategori',
            'aksi' => 'create',
            'target' => $kategori->nama_kategori,
            'keterangan' => 'Admin menambahkan kategori baru dengan kode ' . $kategori->kode_kategori,
            'status' => 'success',
        ]);

        // return redirect jika sudah menjalankan semua baris functionnya
        return redirect()->route('admin-kategori')->with('success', 'Kategori baru berhasil ditambahkan');
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
    public function edit(Kategori $kategori)
    {
        // return view form edit
        return view('admin.kategori.edit', compact('kategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kategori $kategori)
    {
        // validate request seperti create
        $valid = $request->validate([
            'nama_kategori' => 'required|string|max:100',
            'warna' => 'required|string|max:20',
        ]);

        // update data nya langsung lewat bindingtadi
        $kategori->update($valid);

        Log::create([
            'user_id' => Auth::id(),
            'role' => Auth::user()->role,
            'modul' => 'kategori',
            'aksi' => 'update',
            'target' => $kategori->nama_kategori,
            'keterangan' => 'Admin memperbarui data kategori.',
            'status' => 'success',
        ]);

        // return redirect jika sudah menjalankan semua baris functionnya
        return redirect()->route('admin-kategori')->with('success', 'Kategori berhasil di update!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kategori $kategori)
    {
        // vcek apakah ada alat yang menggunakan kategori ini
        if ($kategori->alat()->exists()) {

            Log::create([
                'user_id' => Auth::id(),
                'role' => Auth::user()->role,
                'modul' => 'kategori',
                'aksi' => 'delete',
                'target' => $kategori->nama_kategori,
                'keterangan' => 'Gagal menghapus kategori karena masih memiliki alat.',
                'status' => 'warning',
            ]);

            return back()->with('error', "Gagal menghapus! Kategori '{$kategori->nama_kategori}' masih memiliki alat di dalamnya. Hapus atau pindahkan alatnya terlebih dahulu.");
        }

        Log::create([
            'user_id' => Auth::id(),
            'role' => Auth::user()->role,
            'modul' => 'kategori',
            'aksi' => 'delete',
            'target' => $kategori->nama_kategori,
            'keterangan' => 'Admin menghapus kategori.',
            'status' => 'warning',
        ]);

        // ifff kosong, baru hapus
        $kategori->delete();

        return redirect()->route('admin-kategori')->with('success', 'Kategori berhasil dihapus');
    }
}
