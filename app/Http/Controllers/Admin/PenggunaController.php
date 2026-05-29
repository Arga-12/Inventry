<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Log;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// Log
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PenggunaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // filter dan search
        $search = $request->input('search');
        $roleFilter = $request->input('role_filter');
        $statusFilter = $request->input('status_filter');

        // statistik untuk view
        $stats = [
            'total' => [
                'peminjam' => Pengguna::where('role', 'peminjam')->count(),
                'petugas' => Pengguna::where('role', 'petugas')->count(),
                'admin' => Pengguna::where('role', 'admin')->count(),
            ],
            'online' => [
                'peminjam' => Pengguna::where('role', 'peminjam')
                    ->whereNotNull('last_activity')
                    ->where('last_activity', '>=', now()->subMinutes(5))
                    ->count(),
                'petugas' => Pengguna::where('role', 'petugas')
                    ->whereNotNull('last_activity')
                    ->where('last_activity', '>=', now()->subMinutes(5))
                    ->count(),
                'admin' => Pengguna::where('role', 'admin')
                    ->whereNotNull('last_activity')
                    ->where('last_activity', '>=', now()->subMinutes(5))
                    ->count(),
            ],
        ];

        // query untuk tabel dan filter
        $users = Pengguna::query()
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('username', 'like', "%{$search}%")
                        ->orWhere('nama_lengkap', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->when($roleFilter, fn($query, $role) => $query->where('role', $role))
            ->when($statusFilter, function ($query, $status) {
                if ($status === 'aktif') {
                    $query->where('last_activity', '>=', now()->subMinutes(5));
                } elseif ($status === 'nonaktif') {
                    $query->where('last_activity', '<', now()->subMinutes(5));
                }
            })
            ->latest()
            ->paginate(10);

        return view('admin.users.index', compact('users', 'stats', 'search', 'roleFilter', 'statusFilter'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // return view coy
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validasi reqs
        $request->validate([
            'username' => 'required|string|max:255|unique:user,username',
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|unique:user,email',
            'role' => 'required|in:admin,petugas,peminjam',
            'password' => 'required|string|min:6|confirmed',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah digunakan.',
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'role.required' => 'Role wajib dipilih.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Password tidak cocok.',
            'foto_profil.image' => 'File harus berupa gambar.',
            'foto_profil.max' => 'Ukuran gambar maksimal 2 MB.',
        ]);

        DB::beginTransaction();

        try {
            $data = [
                'username' => $request->username,
                'nama_lengkap' => $request->nama_lengkap,
                'email' => $request->email,
                'role' => $request->role,
                'password' => Hash::make($request->password),
            ];

            // handle upload foto profil
            if ($request->hasFile('foto_profil')) {
                $file = $request->file('foto_profil');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('foto_profil', $filename, 'public');
                $data['foto_profil'] = $path;
            }

            Pengguna::create($data);

            DB::commit();

            Log::create([
                'user_id' => Auth::id(),
                'role' => Auth::user()->role,
                'modul' => 'pengguna',
                'aksi' => 'create',
                'target' => $request->username,
                'keterangan' => 'Menambahkan user baru dengan role "' . $request->role . '"',
                'status' => 'success',
            ]);

            return redirect()
                ->route('admin-pengguna')
                ->with('success', 'User berhasil ditambahkan.');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pengguna $pengguna)
    {
        // return view edit
        return view('admin.users.edit', compact('pengguna'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pengguna $pengguna)
    {
        $request->validate([
            'username' => [
                'required',
                'string',
                'max:255',
                'unique:user,username,' . ($pengguna->id ?? ''),
                'regex:/^[a-zA-Z][a-zA-Z0-9_]*$/',
            ],
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|unique:user,email,' . $pengguna->id,
            'role' => 'required|in:admin,petugas,peminjam',
            'password' => 'nullable|string|min:6|confirmed',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'username.required' => 'Username wajib diisi.',
            'username.max' => 'Username maksimal 255 karakter.',
            'username.unique' => 'Username sudah digunakan. Silakan pilih username lain.',
            'username.regex' => 'Username harus dimulai dengan huruf dan hanya boleh mengandung huruf, angka, dan underscore (_).',
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'role.required' => 'Role wajib dipilih.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'foto_profil.image' => 'File harus berupa gambar.',
            'foto_profil.max' => 'Ukuran gambar maksimal 2 MB.',
        ]);

        DB::beginTransaction();

        try {
            $data = [
                'username' => $request->username,
                'nama_lengkap' => $request->nama_lengkap,
                'email' => $request->email,
                'role' => $request->role,
            ];

            // update password IFFF jika diisi
            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }

            // handle upload foto profil baru
            if ($request->hasFile('foto_profil')) {
                // destroy file foto lama jika ada
                if ($pengguna->foto_profil && file_exists(storage_path('app/public/' . $pengguna->foto_profil))) {
                    unlink(storage_path('app/public/' . $pengguna->foto_profil));
                }

                $file = $request->file('foto_profil');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('foto_profil', $filename, 'public');
                $data['foto_profil'] = $path;
            }

            $pengguna->update($data);

            DB::commit();

            Log::create([
                'user_id' => Auth::id(),
                'role' => Auth::user()->role,
                'modul' => 'pengguna',
                'aksi' => 'update',
                'target' => $pengguna->username,
                'keterangan' => 'Mengupdate data user "' . $pengguna->username . '"',
                'status' => 'success',
            ]);

            return redirect()
                ->route('admin-pengguna')
                ->with('success', 'User berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pengguna $pengguna)
    {
        DB::beginTransaction();

        try {
            // hapus file foto profil jika ada
            if ($pengguna->foto_profil && file_exists(storage_path('app/public/' . $pengguna->foto_profil))) {
                unlink(storage_path('app/public/' . $pengguna->foto_profil));
            }

            $username = $pengguna->username;
            // hapus user
            $pengguna->delete();

            DB::commit();

            Log::create([
                'user_id' => Auth::id(),
                'role' => Auth::user()->role,
                'modul' => 'pengguna',
                'aksi' => 'delete',
                'target' => $username,
                'keterangan' => 'Menghapus user "' . $username . '"',
                'status' => 'warning',
            ]);

            return redirect()
                ->route('admin-pengguna')
                ->with('success', 'User berhasil dihapus.');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
