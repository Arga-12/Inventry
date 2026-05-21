<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProfilController extends Controller
{
    /**
     * Show the form for editing profile.
     */
    public function edit()
    {
        $user = Auth::user();

        return view('preferensi', compact('user'));
    }

    /**
     * Update the profile.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // validate buat all role user
        $rules = [
            'email' => 'required|email|unique:user,email,'.$user->id,
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ];

        // iff pass di isi
        if ($request->filled('password')) {
            $rules['current_password'] = 'required|current_password';
            $rules['password'] = 'required|string|min:6|confirmed';
        }

        // if admin
        if ($user->role === 'admin') {
            $rules['username'] = 'required|string|max:255|unique:user,username,'.$user->id.'|regex:/^[a-zA-Z][a-zA-Z0-9_]*$/';
            $rules['nama_lengkap'] = 'required|string|max:255';
        }

        $messages = [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'current_password.required' => 'Password saat ini wajib diisi untuk mengubah password.',
            'current_password.current_password' => 'Password saat ini salah.',
            'password.required' => 'Password baru wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'foto_profil.image' => 'File harus berupa gambar.',
            'foto_profil.max' => 'Ukuran gambar maksimal 2 MB.',
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah digunakan.',
            'username.regex' => 'Username harus dimulai dengan huruf dan hanya boleh mengandung huruf, angka, dan underscore (_).',
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
        ];

        $request->validate($rules, $messages);

        DB::beginTransaction();

        try {
            $data = [
                'email' => $request->email,
            ];

            // admin bisa update username dan nama lengkap
            if ($user->role === 'admin') {
                $data['username'] = $request->username;
                $data['nama_lengkap'] = $request->nama_lengkap;
            }

            // update pass IFF diisi
            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }

            // handle foto profil
            if ($request->hasFile('foto_profil')) {
                if ($user->foto_profil && file_exists(storage_path('app/public/'.$user->foto_profil))) {
                    unlink(storage_path('app/public/'.$user->foto_profil));
                }

                $file = $request->file('foto_profil');
                $filename = time().'_'.$file->getClientOriginalName();
                $path = $file->storeAs('foto_profil', $filename, 'public');
                $data['foto_profil'] = $path;
            }

            $user->update($data);

            DB::commit();

            return redirect()
                ->route('profil-edit')
                ->with('success', 'Profil berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: '.$e->getMessage());
        }
    }
}
