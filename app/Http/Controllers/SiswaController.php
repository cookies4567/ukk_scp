<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use App\Models\Kelas;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    /**
     * Menampilkan daftar siswa dengan filter kelas,
     * pencarian nama/NIS, dan pagination.
     */
    public function index(Request $request)
    {
        $request->validate([
            'kelas_id' => ['nullable', 'integer', 'exists:kelas,id'],
            'cari' => ['nullable', 'string', 'max:100'],
        ]);

        // Total seluruh siswa yang terdaftar.
        $totalSiswa = Pengguna::where('peran_id', 5)->count();

        // Total kelas yang tersedia.
        $totalKelas = Kelas::count();

        // Daftar kelas untuk filter.
        $daftarKelas = Kelas::orderBy('nama_kelas')->get();

        // Query utama daftar siswa.
        $query = Pengguna::with('kelas')
            ->where('peran_id', 5);

        // Filter berdasarkan kelas.
        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }

        // Pencarian berdasarkan nama atau NIS.
        if ($request->filled('cari')) {
            $kataKunci = trim($request->cari);

            $query->where(function ($subQuery) use ($kataKunci) {
                $subQuery->where('nama_lengkap', 'like', "%{$kataKunci}%")
                    ->orWhere('nis', 'like', "%{$kataKunci}%");
            });
        }

        // Urutkan berdasarkan nama dan tampilkan 10 data per halaman.
        $siswa = $query
            ->orderBy('nama_lengkap')
            ->paginate(10)
            ->withQueryString();

        return view('waka.master-data.siswa.index', compact(
            'siswa',
            'daftarKelas',
            'totalSiswa',
            'totalKelas'
        ));
    }
}
