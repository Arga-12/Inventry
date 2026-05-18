<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPeminjaman extends Model
{
     // nama tabel
    protected $table = 'detail_peminjaman';

    // mass assignment
    protected $fillable = [
        'peminjaman_id',
        'alat_id',
        'jumlah',
    ];

    /**
     * relasi ke peminjaman
     */
    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'peminjaman_id', 'id');
    }

    /**
     * relasi ke alat
     */
    public function alat()
    {
        return $this->belongsTo(Alat::class, 'alat_id', 'id');
    }

    /**
     * relasi ke detail pengembalian
     */
    public function detailPengembalian()
    {
        return $this->hasOne(DetailPengembalian::class, 'detail_peminjaman_id', 'id');
    }
}
