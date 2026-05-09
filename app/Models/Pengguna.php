<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// Import Authenticatable
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pengguna extends Authenticatable
{

    use HasFactory, Notifiable;

    //Dari tabel user
    protected $table = 'user';

    protected $fillable = [
        'username',
        'nama_lengkap',
        'role',
        'foto_profil',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed', // Otomatis meng-hash password
    ];
}
