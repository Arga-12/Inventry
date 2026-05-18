<?php

namespace App\Models;

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

    //buat badge status peminjaman
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
}
