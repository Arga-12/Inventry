<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //ambil semua data all()
        $kategori = Kategori::all();
    
        //return view index
        return view('admin.kategori.index', compact('kategori'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //return view create
        return view('admin.kategori.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //validate request penambahan kategori
        $valid = $request->validate([
            'nama_kategori' => 'required|string|max:100',
            'warna' => 'required|string|max:20',
        ]);

        //bikin unique id sendiri
        $last = Kategori::count() + 1;
        //::count() as menjumlahkan total baris yang ada di tabel kategori

        $kode = "KTG-" . str_pad($last, 3, '0', STR_PAD_LEFT);
        //strpad() (string yang akan dimasukkan, panjang string, padding kosong diisi apa?,rata dari kiri atau kanan)

        //logic menambahkan data
        $valid['kode_kategori'] = $kode;
        //tambahin dulu column kode katagorinya

        //baru ::create()
        Kategori::create($valid);

        //return redirect jika sudah menjalankan semua baris functionnya
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
        //return view form edit
        return view('admin.kategori.edit', compact('kategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kategori $kategori)
    {
        //validate request seperti create
        $valid = $request->validate([
            'nama_kategori' => 'required|string|max:100',
            'warna' => 'required|string|max:20',
        ]);

        //update data nya langsung lewat bindingtadi
        $kategori->update($valid);

        //return redirect jika sudah menjalankan semua baris functionnya
        return redirect()->route('admin-kategori')->with('success', 'Kategori berhasil di update!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kategori $kategori)
    {
        //langsung delete aja pake bninding
        $kategori->delete();

        //return redirect jika sudah menjalankan semua baris functionnya
        return redirect()->route('admin-kategori')->with('success', 'Kategori berhasil dihapus');
    }
}
