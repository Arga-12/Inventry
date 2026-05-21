<?php

namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use App\Models\Alat;
use App\Models\Pengembalian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengembalianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $durasiOptions = Alat::whereNotNull('durasi')
            ->select('durasi')
            ->distinct()
            ->orderBy('durasi')
            ->get();

        $durasiList = [];
        foreach ($durasiOptions as $d) {
            $hours = floor($d->durasi / 60);
            $mins = $d->durasi % 60;
            $label = $hours > 0 ? $hours.' Jam '.($mins > 0 ? $mins.' Menit' : '') : $mins.' Menit';
            $durasiList[] = [
                'value' => $d->durasi,
                'label' => trim($label),
            ];
        }

        // query menunggu verifikasi
        $menunggu = Pengembalian::with([
            'peminjaman.peminjam',
            'detailPengembalian.detailPeminjaman.alat.kategori',
        ])
            ->whereHas('peminjaman', function ($q) {
                $q->where('peminjam_id', Auth::id());
            })
            ->where('status', 'menunggu_verifikasi')
            ->when($request->filled('search_menunggu'), function ($q) use ($request) {
                $q->where('kode_pengembalian', 'like', '%'.$request->search_menunggu.'%');
            })
            ->when($request->filled('durasi_menunggu'), function ($q) use ($request) {
                $q->whereHas('peminjaman.detailPeminjaman.alat', function ($q2) use ($request) {
                    $q2->where('durasi', $request->durasi_menunggu);
                });
            })
            ->latest()
            ->get();

        // query selesai
        $selesai = Pengembalian::with([
            'peminjaman.peminjam',
            'detailPengembalian.detailPeminjaman.alat.kategori',
        ])
            ->whereHas('peminjaman', function ($q) {
                $q->where('peminjam_id', Auth::id());
            })
            ->where('status', 'selesai')
            ->when($request->filled('search_selesai'), function ($q) use ($request) {
                $q->where('kode_pengembalian', 'like', '%'.$request->search_selesai.'%');
            })
            ->when($request->filled('durasi_selesai'), function ($q) use ($request) {
                $q->whereHas('peminjaman.detailPeminjaman.alat', function ($q2) use ($request) {
                    $q2->where('durasi', $request->durasi_selesai);
                });
            })
            ->when($request->filled('kondisi_selesai'), function ($q) use ($request) {
                $q->whereHas('detailPengembalian', function ($q2) use ($request) {
                    $q2->where('kondisi', $request->kondisi_selesai);
                });
            })
            ->latest()
            ->get();

        return view('peminjam.pengembalian', compact('menunggu', 'selesai', 'durasiList'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
