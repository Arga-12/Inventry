<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //View laman login
    public function loginView() {
        return view('login');
    }

    //Login system
    public function login(Request $request) {

        //Ambil request form
        $request->validate([
            'login_user' => 'required|string',
            'password' => 'required|string',
        ]);

        //filter_var() ngecek apakah ada yg cocok dengan 2 kolom ini
        $login = filter_var($request->login_user, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        
        //isi variable creds
        $creds = [
            $login => $request->login_user,
            'password' => $request->password,
        ];

        //Auth::attempt untuk mencoba login
        if(Auth::attempt($creds)) {
            //bikin session baru untuk mencegah serangan timpa session fixation
            $request->session()->regenerate();

            $role = Auth::user()->role;

            if ($role === 'admin') {
                return redirect()->intended('/admin/dashboard');
            } elseif ($role === 'petugas') {
                return redirect()->intended('/petugas/dashboard');
            }

            //set return default jika role unknown dari pengondisian
            return redirect('/dashboard');
        }

        return back()->withErrors([
            'login_user' => 'Email atau username, serta password salah.',
        ])->onlyInput('login_user');
    }

    //Logout logivca
    public function logout(Request $request) {
        //Pake tools Auth biar ewnak
        Auth::logout();

        //Invalidate session
        $request->session()->invalidate();

        //gausa regenerate karena udah di logic logindiatas
        //return redirect
        return redirect('/login');
    }
}
