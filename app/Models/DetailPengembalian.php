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
}
