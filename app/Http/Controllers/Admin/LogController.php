<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Log;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function index(Request $request)
    {
        // filter values
        $search = $request->input('search');
        $modul = $request->input('modul');
        $aksi = $request->input('aksi');
        $status = $request->input('status');
        $role = $request->input('role');
        $tanggal = $request->input('tanggal');

        // options untuk dropdown filter
        $modulOptions = Log::select('modul')
            ->distinct()
            ->orderBy('modul')
            ->pluck('modul')
            ->filter()
            ->values();

        $aksiOptions = Log::select('aksi')
            ->distinct()
            ->orderBy('aksi')
            ->pluck('aksi')
            ->filter()
            ->values();

        $statusOptions = ['success', 'warning', 'error'];
        $roleOptions = ['admin', 'petugas', 'peminjam'];

        // query utama
        $query = Log::with('user')->latest();

        // filter search (target, keterangan, user)
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('target', 'like', "%{$search}%")
                    ->orWhere('keterangan', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($q2) use ($search) {
                        $q2->where('nama_lengkap', 'like', "%{$search}%")
                            ->orWhere('username', 'like', "%{$search}%");
                    });
            });
        }

        // filter modul
        if ($modul && $modul != 'semua') {
            $query->where('modul', $modul);
        }

        // filter aksi
        if ($aksi && $aksi != 'semua') {
            $query->where('aksi', $aksi);
        }

        // filter status
        if ($status && $status != 'semua') {
            $query->where('status', $status);
        }

        // filter role
        if ($role && $role != 'semua') {
            $query->where('role', $role);
        }

        // filter tanggal
        if ($tanggal) {
            $query->whereDate('created_at', $tanggal);
        }

        $logs = $query->paginate(15);

        // stats untuk card
        $stats = [
            // 1 total aktivitas & breakdown per modul
            'total_aktivitas' => Log::count(),
            'peminjaman' => Log::where('modul', 'peminjaman')->count(),
            'pengembalian' => Log::where('modul', 'pengembalian')->count(),

            // 2 statistik berdasarkan status (success, warning, error)
            'total_log' => Log::count(),
            'status_success' => Log::where('status', 'success')->count(),
            'status_warning' => Log::where('status', 'warning')->count(),
            'status_error' => Log::where('status', 'error')->count(),

            // 3 error & anomali
            'total_error' => Log::where('status', 'error')->count(),
        ];

        return view('admin.logaktivitas', compact(
            'logs', 'stats', 'modulOptions', 'aksiOptions', 'statusOptions', 'roleOptions',
            'search', 'modul', 'aksi', 'status', 'role', 'tanggal'
        ));
    }
}
