<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengembalian extends Model
{
     // nama tabel
    protected $table = 'pengembalian';

    // mass assignment
    protected $fillable = [
        'kode_pengembalian',
        'peminjaman_id',
        'petugas_id',
        'status',
        'tanggal_pengembalian',
        'tanggal_verifikasi',
    ];

    /**
     * relasi ke peminjaman
     */
    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'peminjaman_id', 'id');
    }

    /**
     * relasi ke petugas
     */
    public function petugas()
    {
        return $this->belongsTo(Pengguna::class, 'petugas_id', 'id');
    }

    /**
     * relasi ke detail pengembalian
     */
    public function detailPengembalian()
    {
        return $this->hasMany(DetailPengembalian::class, 'pengembalian_id', 'id');
    }

    //untuk parsing dan mempermudah perhitungan datetime
    protected $casts = [
        'tanggal_pengembalian' => 'datetime',
        'tanggal_verifikasi' => 'datetime',
    ];

    //buat badge status pengembalian
    public function getStatusBadgeAttribute()
    {
        return match ($this->status) {
            'menunggu_verifikasi' => 'bg-yellow-100 text-yellow-600',
            'selesai' => 'bg-green-100 text-green-600',

            default => 'bg-gray-100 text-gray-600',
        };
    }

    public function getStatusLabelAttribute()
    {
        return match ($this->status) {
            'menunggu_verifikasi' => 'Menunggu Verifikasi',
            'selesai' => 'Selesai',

            default => 'Unknown',
        };
    }
}
