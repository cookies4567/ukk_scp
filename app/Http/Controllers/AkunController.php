<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use App\Models\Peran;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AkunController extends Controller
{
    public function index()
    {
        $akun = Pengguna::with('peran')
            ->orderBy('nama_lengkap')
            ->get();

        return view(
            'waka.master-data.akun.index',
            compact('akun')
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:100|unique:pengguna,username',
            'nama_lengkap' => 'required|string|max:100',
            'password' => 'required|string|min:6',
            'peran_id' => 'required|exists:peran,id',
        ]);

        Pengguna::create([
            'username' => $validated['username'],
            'nama_lengkap' => $validated['nama_lengkap'],
            'password' => Hash::make($validated['password']),
            'peran_id' => $validated['peran_id'],
        ]);

        return redirect()
            ->route('waka.master-data.akun.index')
            ->with('success', 'Akun berhasil ditambahkan.');
    }

    public function edit(Pengguna $akun)
    {
        $roles = Peran::orderBy('id')->get();
        $kelas = Kelas::orderBy('nama_kelas')->get();

        return view(
            'waka.master-data.akun.edit',
            compact('akun', 'roles', 'kelas')
        );
    }

    public function update(Request $request, Pengguna $akun)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:100|unique:pengguna,username,' . $akun->id,
            'nama_lengkap' => 'required|string|max:100',
            'peran_id' => 'required|exists:peran,id',
            'kelas_id' => 'nullable|exists:kelas,id',
            'password' => 'nullable|string|min:6',
        ], [
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah digunakan.',
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'peran_id.required' => 'Role wajib dipilih.',
            'peran_id.exists' => 'Role tidak valid.',
            'kelas_id.exists' => 'Kelas perwalian tidak valid.',
            'password.min' => 'Password minimal 6 karakter.',
        ]);

        $akun->username = $validated['username'];
        $akun->nama_lengkap = $validated['nama_lengkap'];
        $akun->peran_id = $validated['peran_id'];

        // Kelas perwalian hanya berlaku untuk pengguna dengan Role Guru (ID 2).
        // Kelas perwalian berlaku untuk Guru (2) dan Wali Kelas (3)
        $akun->kelas_id = in_array((int) $validated['peran_id'], [2, 3], true)
            ? ($validated['kelas_id'] ?? null)
            : null;

        if (!empty($validated['password'])) {
            $akun->password = Hash::make($validated['password']);
        }

        $akun->save();

        return redirect()
            ->route('waka.master-data.akun.index')
            ->with('success', 'Akun berhasil diperbarui.');
    }

    public function destroy(Pengguna $akun)
    {
        $akun->delete();

        return redirect()
            ->route('waka.master-data.akun.index')
            ->with('success', 'Akun berhasil dihapus.');
    }
}
