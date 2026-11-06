<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Models\Pengguna;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit', [
            'user' => Auth::user()
        ]);
    }

   public function update(Request $request)
{
    /** @var Pengguna $user */
    $user = Auth::user();

    // Lanjutkan kode validasi dan proses update profil

        $rules = [
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'username' => [
                'required',
                'string',
                'max:100',
                Rule::unique('pengguna', 'username')->ignore($user->id),
            ],
        ];

        // Password hanya divalidasi jika pengguna ingin menggantinya.
        if ($request->filled('password_baru')) {
            $rules['password_saat_ini'] = ['required'];
            $rules['password_baru'] = [
                'required',
                'string',
                'min:8',
                'confirmed',
            ];
        }

        $validated = $request->validate($rules, [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah digunakan akun lain.',
            'password_saat_ini.required' => 'Password saat ini wajib diisi.',
            'password_baru.min' => 'Password baru minimal 8 karakter.',
            'password_baru.confirmed' => 'Konfirmasi password baru tidak cocok.',
        ]);

        if ($request->filled('password_baru')) {
            if (!Hash::check($request->password_saat_ini, $user->password)) {
                return back()
                    ->withErrors([
                        'password_saat_ini' => 'Password saat ini tidak sesuai.'
                    ])
                    ->withInput();
            }

            $user->password = Hash::make($request->password_baru);
        }

        $user->nama_lengkap = $validated['nama_lengkap'];
        $user->username = $validated['username'];

        // Role tidak diubah melalui fitur profil.
        $user->save();

        return redirect()
            ->route('profile.edit')
            ->with('success', 'Profil berhasil diperbarui.');
    }
}
