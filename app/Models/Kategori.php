<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    // protected fillable
    protected $table = 'kategori';

    protected $fillable = [
        'kode_kategori',
        'warna',
        'nama_kategori',
    ];

    // binding nama kolom unique buat route untuk jadi pacuan ambil data
    public function getRouteKeyName()
    {
        return 'kode_kategori';
    }

    // relasi one to many
    public function alat()
    {
        return $this->hasMany(Alat::class, 'kategori_id', 'id');
    }
}
