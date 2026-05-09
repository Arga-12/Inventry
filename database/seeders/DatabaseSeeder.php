<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Pengguna;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        Pengguna::create([
            'username' => 'budiTarmiji',
            'nama_lengkap' => 'Budi Tarmiji',
            'role' => 'peminjam',
            'email' => 'buditarmiji123@gmail.com',
            'password' => Hash::make('12345678'),
        ]);

        Pengguna::create([
            'username' => 'budiadmin',
            'nama_lengkap' => 'Budi Admin',
            'role' => 'admin',
            'email' => 'budiadmin123@gmail.com',
            'password' => Hash::make('12345678'),
        ]);

        Pengguna::create([
            'username' => 'budipetugas',
            'nama_lengkap' => 'Budi Petugas',
            'role' => 'petugas',
            'email' => 'budipetugas123@gmail.com',
            'password' => Hash::make('12345678'),
        ]);
    }
}
