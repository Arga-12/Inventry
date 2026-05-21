<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// Import Authenticatable
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pengguna extends Authenticatable
{
    use HasFactory, Notifiable;

    // Dari tabel user
    protected $table = 'user';

    protected $fillable = [
        'username',
        'nama_lengkap',
        'role',
        'foto_profil',
        'email',
        'password',
        'last_activity',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed', // Otomatis meng-hash password
        'last_activity' => 'datetime',
    ];

    // route binding buat edit dan update route
    public function getRouteKeyName()
    {
        return 'username';
    }

    // method cek kalau lagi online dianya
    public function isOnline(): bool
    {
        if (! $this->last_activity) {
            return false;
        }

        // oh lagi online bang, dia habis ngelakuin hal di 5 menit terakhir
        return $this->last_activity->diffInMinutes(now()) < 5;
    }

    /**
     * ambil url foto pengguna / user pakek default fallback
     */
    public function getFotoUrlAttribute()
    {
        if ($this->foto_profil) {
            return asset('storage/'.$this->foto_profil);
        }

        return asset('images/default-avatar.png');
    }

    /**
     * sebagai peminjam
     */
    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'peminjam_id', 'id');
    }

    /**
     * sebagai petugas peminjaman
     */
    public function verifikasiPeminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'petugas_id', 'id');
    }

    /**
     * sebagai petugas pengembalian
     */
    public function verifikasiPengembalian()
    {
        return $this->hasMany(Pengembalian::class, 'petugas_id', 'id');
    }
}
