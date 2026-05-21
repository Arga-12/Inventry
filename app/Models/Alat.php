<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Alat extends Model
{
    // menggunakan trait soft delete (tools bener bener menghapus datanya di database)
    use SoftDeletes;

    // protected fill able
    protected $table = 'alat';

    protected $fillable = [
        'kategori_id',
        'kode_alat',
        'nama_alat',
        'stok',
        'gambar',
        'durasi',
    ];

    // binding nama kolom unique buat route untuk jadi pacuan ambil data
    public function getRouteKeyName()
    {
        return 'kode_alat';
    }

    // relasi many to one kategori
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id', 'id');
    }

    /**
     * relasi ke detail peminjaman
     */
    public function detailPeminjaman()
    {
        return $this->hasMany(DetailPeminjaman::class, 'alat_id', 'id');
    }
}
