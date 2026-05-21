<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPengembalian extends Model
{
    // nama tabel
    protected $table = 'detail_pengembalian';

    // mass assignment
    protected $fillable = [
        'pengembalian_id',
        'detail_peminjaman_id',
        'jumlah_kembali',
        'catatan_kondisi',
        'kondisi',
    ];

    /**
     * relasi ke pengembalian
     */
    public function pengembalian()
    {
        return $this->belongsTo(Pengembalian::class, 'pengembalian_id', 'id');
    }

    /**
     * relasi ke detail peminjaman
     */
    public function detailPeminjaman()
    {
        return $this->belongsTo(DetailPeminjaman::class, 'detail_peminjaman_id', 'id');
    }

    /**
     * badge warna kondisi
     */
    public function getKondisiBadgeAttribute(): string
    {
        return match ($this->kondisi) {
            'lolos' => 'bg-green-100 text-green-700',
            'rusak' => 'bg-red-100 text-red-700',
            default => 'bg-gray-100 text-gray-700',
        };
    }

    /**
     * label kondisi dalam bahasa indonesia
     */
    public function getKondisiLabelAttribute(): string
    {
        return match ($this->kondisi) {
            'lolos' => 'Lolos',
            'rusak' => 'Rusak',
            default => ucfirst($this->kondisi),
        };
    }
}
