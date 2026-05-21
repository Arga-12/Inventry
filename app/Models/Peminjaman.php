<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    // nama tabel
    protected $table = 'peminjaman';

    // mass assignment
    protected $fillable = [
        'kode_peminjaman',
        'peminjam_id',
        'petugas_id',
        'status',
        'durasi',
        'deadline',
        'tanggal_pengajuan',
        'tanggal_disetujui',
    ];

    // binding route untuk patokan edit dan update
    public function getRouteKeyName()
    {
        return 'kode_peminjaman';
    }

    /**
     * Booted trait untuk auto-sync saat model di-load
     */
    protected static function booted()
    {
        static::retrieved(function ($peminjaman) {
            $peminjaman->syncStatusIfNeeded();
        });
    }

    /**
     * Sync status berdasarkan deadline (real-time)
     */
    public function syncStatusIfNeeded()
    {
        // Hanya proses yang statusnya 'dipinjam' atau 'jatuh_tempo'
        if (! in_array($this->status, ['dipinjam', 'jatuh_tempo'])) {
            return $this;
        }

        // Hanya proses yang punya deadline
        if (! $this->deadline) {
            return $this;
        }

        $now = Carbon::now();
        $originalStatus = $this->getOriginal('status');
        $newStatus = null;

        // Cek kondisi: dipinjam -> jatuh_tempo
        if ($originalStatus === 'dipinjam' && $now->greaterThan($this->deadline)) {
            $newStatus = 'jatuh_tempo';
        }

        // Cek kondisi: jatuh_tempo -> terlambat (lewat 10 menit)
        if ($originalStatus === 'jatuh_tempo' && $now->greaterThan($this->deadline->copy()->addMinutes(10))) {
            $newStatus = 'terlambat';
        }

        // Update jika ada perubahan
        if ($newStatus) {
            $this->update(['status' => $newStatus]);
            $this->refresh();
        }

        return $this;
    }

    /**
     * Sync semua peminjaman aktif (bisa dipanggil dari controller)
     */
    public static function syncAllActivePeminjaman()
    {
        return self::whereIn('status', ['dipinjam', 'jatuh_tempo'])
            ->whereNotNull('deadline')
            ->chunk(100, function ($peminjaman) {
                foreach ($peminjaman as $p) {
                    $p->syncStatusIfNeeded();
                }
            });
    }

    /**
     * relasi ke user peminjam
     */
    public function peminjam()
    {
        return $this->belongsTo(Pengguna::class, 'peminjam_id', 'id');
    }

    /**
     * relasi ke user petugas
     */
    public function petugas()
    {
        return $this->belongsTo(Pengguna::class, 'petugas_id', 'id');
    }

    /**
     * relasi ke detail peminjaman
     */
    public function detailPeminjaman()
    {
        return $this->hasMany(DetailPeminjaman::class, 'peminjaman_id', 'id');
    }

    /**
     * relasi ke pengembalian
     */
    public function pengembalian()
    {
        return $this->hasOne(Pengembalian::class, 'peminjaman_id', 'id');
    }

    // biar langsung carbon (mengatur perwaktuan lebih mudah)
    protected $casts = [
        'deadline' => 'datetime',
        'tanggal_pengajuan' => 'datetime',
        'tanggal_disetujui' => 'datetime',
    ];

    // buat badge status peminjaman
    public function getStatusBadgeAttribute()
    {
        return match ($this->status) {
            'menunggu' => 'bg-yellow-100 text-yellow-600 border-yellow-200',
            'dipinjam' => 'bg-blue-100 text-blue-600 border-blue-200',
            'jatuh_tempo' => 'bg-orange-100 text-orange-600 border-orange-200',
            'terlambat' => 'bg-red-100 text-red-600 border-red-200',
            'selesai' => 'bg-green-100 text-green-600 border-green-200',
            'ditolak' => 'bg-gray-200 text-gray-700 border-gray-300',

            default => 'bg-gray-100 text-gray-600 border-gray-200',
        };
    }

    public function getStatusLabelAttribute()
    {
        return match ($this->status) {
            'menunggu' => 'Menunggu',
            'dipinjam' => 'Dipinjam',
            'jatuh_tempo' => 'Jatuh Tempo',
            'terlambat' => 'Terlambat',
            'selesai' => 'Selesai',
            'ditolak' => 'Ditolak',

            default => 'Unknown',
        };
    }

    /**
     * Get real-time status (badge + label) untuk tampilan card
     */
    public function getCardStatusAttribute()
    {
        // Jika tidak ada deadline atau status bukan dipinjam/jatuh_tempo
        if (is_null($this->deadline) || ! in_array($this->status, ['dipinjam', 'jatuh_tempo'])) {
            return [
                'label' => $this->status_label,
                'badge' => $this->status_badge,
            ];
        }

        $deadline = Carbon::parse($this->deadline);
        $lateTime = $deadline->copy()->addMinutes(10);
        $now = Carbon::now();

        if ($now->greaterThanOrEqualTo($lateTime)) {
            return [
                'label' => 'Terlambat',
                'badge' => 'bg-red-100 text-red-700 border-red-200',
            ];
        }

        if ($now->greaterThanOrEqualTo($deadline)) {
            return [
                'label' => 'Jatuh Tempo',
                'badge' => 'bg-orange-100 text-orange-700 border-orange-200',
            ];
        }

        return [
            'label' => $this->status_label,
            'badge' => $this->status_badge,
        ];
    }
}
