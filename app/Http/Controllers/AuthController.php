<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {

            $request->session()->regenerate();

            $user = Auth::user();

            switch ((int) $user->peran_id) {

                case 1:
                    return redirect()->route('waka.dashboard');

                case 2:
                    return redirect()->route('guru.dashboard');

                case 3:
                case 4:
                    // Wali Kelas dan Guru BK memakai dashboard kesiswaan
                    return redirect()->route('kesiswaan.dashboard');

                case 5:
                    return redirect()->route('portal.dashboard');

                default:
                    Auth::logout();

                    return back()->withErrors([
                        'username' => 'Role pengguna tidak valid.',
                    ]);
            }
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
