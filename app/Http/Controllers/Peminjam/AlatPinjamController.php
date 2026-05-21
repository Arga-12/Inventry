<?php

namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use App\Models\Alat;
use App\Models\DetailPeminjaman;
use App\Models\Kategori;
use App\Models\Log;
use App\Models\Peminjaman;
use Carbon\Carbon;
use Illuminate\Http\Request;
// Log
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AlatPinjamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Alat::with('kategori')->where('stok', '>', 0);

        // filter pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_alat', 'like', "%{$search}%")
                    ->orWhere('kode_alat', 'like', "%{$search}%");
            });
        }

        // filter kategori (multiple)
        if ($request->filled('kategori')) {
            $kategoriIds = explode(',', $request->kategori);
            $query->whereIn('kategori_id', $kategoriIds);
        }

        // filter durasi dari dropdown (multiple) - pakai durasi_filter
        if ($request->filled('durasi_filter')) {
            $durasiValues = explode(',', $request->durasi_filter);
            $query->whereIn('durasi', $durasiValues);
        }

        // filter durasi dari cart (single) - pakai durasi_cart
        if ($request->filled('durasi_cart')) {
            $query->where('durasi', $request->durasi_cart);
        }

        $alat = $query->latest()->paginate(9);
        $kategori = Kategori::all();

        // ambil daftar durasi unik untuk pilihan di dropdown
        $durasiList = Alat::whereNotNull('durasi')
            ->select('durasi')
            ->distinct()
            ->orderBy('durasi')
            ->get()
            ->map(function ($item) {
                $hours = floor($item->durasi / 60);
                $mins = $item->durasi % 60;

                return [
                    'value' => $item->durasi,
                    'label' => $hours > 0 ? $hours.' Jam '.($mins > 0 ? $mins.' Menit' : '') : $mins.' Menit',
                ];
            });

        return view('peminjam.alatpinjam', compact('alat', 'kategori', 'durasiList'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // karena Content-Type: application/json, data sudah berupa array
            // soo ambil langsung dari $request->input()
            $cart = $request->input('cart');
            $selectedDurasi = $request->input('selected_durasi');

            // cek apakah cart ada dan tidak kosong
            if (! $cart || empty($cart['items'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Keranjang kosong',
                ], 400);
            }

            $items = $cart['items'];

            // validasi user login
            if (! Auth::check()) {
                return response()->json([
                    'success' => false,
                    'message' => 'User tidak login',
                ], 401);
            }

            // validasi durasi semua item harus sama
            foreach ($items as $item) {
                if ($item['durasi'] != $selectedDurasi) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Semua alat harus memiliki durasi yang sama',
                    ], 400);
                }
            }

            DB::beginTransaction();

            $kodePeminjaman = $this->generateKodePeminjaman();

            // simpan peminjaman utama
            $peminjaman = Peminjaman::create([
                'kode_peminjaman' => $kodePeminjaman,
                'peminjam_id' => Auth::id(),
                'petugas_id' => null,
                'status' => 'menunggu',
                'durasi' => $selectedDurasi,
                'deadline' => null,
                'tanggal_pengajuan' => Carbon::now(),
                'tanggal_disetujui' => null,
            ]);

            foreach ($items as $item) {
                DetailPeminjaman::create([
                    'peminjaman_id' => $peminjaman->id,
                    'alat_id' => $item['id'],
                    'jumlah' => $item['quantity'],
                ]);
            }

            Log::create([
                'user_id' => Auth::id(),
                'role' => Auth::user()->role,
                'modul' => 'peminjaman',
                'aksi' => 'create',
                'target' => $kodePeminjaman,
                'keterangan' => 'Peminjam mengajukan peminjaman baru dengan '.count($items).' item alat.',
                'status' => 'success',
            ]);

            DB::commit();

            // response dengan struktur data yang sesuai frontend
            return response()->json([
                'success' => true,
                'message' => 'Peminjaman berhasil diajukan',
                'data' => [
                    'kode_peminjaman' => $kodePeminjaman,
                    'peminjaman_id' => $peminjaman->id,
                ],
            ]);

        } catch (\Throwable $e) {
            DB::rollBack();

            Log::create([
                'user_id' => Auth::check() ? Auth::id() : null,
                'role' => Auth::check() ? Auth::user()->role : 'guest',
                'modul' => 'peminjaman',
                'aksi' => 'create',
                'target' => null,
                'keterangan' => 'Gagal mengajukan peminjaman: '.$e->getMessage(),
                'status' => 'error',
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error: '.$e->getMessage(),
            ], 500);
        }
    }

    private function generateKodePeminjaman()
    {
        // ambil 2 digit tahun
        $tahun = now()->format('y');

        // ambil bulan
        $bulan = now()->format('m');

        // prefix kode
        $prefix = "INV-PJ-{$tahun}{$bulan}-";

        // cari kode terakhir bulan ini
        $lastPeminjaman = Peminjaman::where('kode_peminjaman', 'like', $prefix.'%')
            ->latest('id')
            ->first();

        // default nomor
        $nomor = 1;

        // kalau ada transaksi sebelumnya
        if ($lastPeminjaman) {

            // ambil 3 digit terakhir
            $lastNumber = substr($lastPeminjaman->kode_peminjaman, -3);

            // increment
            $nomor = intval($lastNumber) + 1;
        }

        // format jadi 3 digit
        $nomor = str_pad($nomor, 3, '0', STR_PAD_LEFT);

        // hasil akhir
        return $prefix.$nomor;
    }
}
