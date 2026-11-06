<?php

namespace App\Http\Controllers;

use App\Models\JadwalPelajaran;
use App\Models\KonfigurasiSistem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WakaController extends Controller
{
    /**
     * Dashboard Waka Kurikulum
     */
    
public function dashboard()
{
    $waka = Auth::user();

    $konfigurasi = KonfigurasiSistem::first();

    $jadwal = JadwalPelajaran::with([
        'guru',
        'kelas',
        'ruangan'
    ])
    ->orderByRaw("
        FIELD(
            hari,
            'Senin',
            'Selasa',
            'Rabu',
            'Kamis',
            'Jumat',
            'Sabtu'
        )
    ")
    ->orderBy('jam_mulai')
    ->get();

    return view('waka.dashboard', compact(
        'waka',
        'konfigurasi',
        'jadwal'
    ));
}


    /**
     * Menampilkan halaman Pengaturan Sistem
     */
    public function pengaturan()
    {
        $waka = Auth::user();

        $konfigurasi = KonfigurasiSistem::first();

        return view('waka.pengaturan', compact(
            'waka',
            'konfigurasi'
        ));
    }


    /**
     * Menyimpan perubahan Pengaturan Sistem
     */
    public function updatePengaturan(Request $request)
    {
        $waka = Auth::user();

        $validated = $request->validate([
            'siklus_aktif' => 'required|in:Putaran 1,Putaran 2',
            'jadwal_dikunci' => 'required|boolean',
        ], [
            'siklus_aktif.required' => 'Putaran aktif wajib dipilih.',
            'siklus_aktif.in' => 'Putaran aktif tidak valid.',
            'jadwal_dikunci.required' => 'Status jadwal wajib dipilih.',
            'jadwal_dikunci.boolean' => 'Status jadwal tidak valid.',
        ]);

        $konfigurasi = KonfigurasiSistem::first();

        if (!$konfigurasi) {
            $konfigurasi = new KonfigurasiSistem();
        }

        $konfigurasi->siklus_aktif = $validated['siklus_aktif'];
        $konfigurasi->jadwal_dikunci = (bool) $validated['jadwal_dikunci'];
        $konfigurasi->diubah_oleh = $waka->id;

        $konfigurasi->save();

        return redirect()
            ->route('waka.pengaturan')
            ->with('success', 'Pengaturan sistem berhasil diperbarui.');
    }
}