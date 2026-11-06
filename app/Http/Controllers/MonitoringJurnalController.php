<?php

namespace App\Http\Controllers;

use App\Models\JurnalMengajar;
use App\Models\JadwalPelajaran;
use App\Models\KonfigurasiSistem;
use App\Models\Pengguna;
use Illuminate\Http\Request;

class MonitoringJurnalController extends Controller
{
    public function index(Request $request)
    {
        $konfigurasi = KonfigurasiSistem::first();
        $siklusAktif = $konfigurasi?->siklus_aktif;

        $query = JurnalMengajar::with([
            'jadwal.guru',
            'jadwal.kelas',
            'jadwal.ruangan',
        ])->whereHas('jadwal', function ($q) use ($siklusAktif) {
            if ($siklusAktif) {
                $q->where('tipe_siklus', $siklusAktif);
            }
        });

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        if ($request->filled('guru_id')) {
            $query->whereHas('jadwal', function ($q) use ($request) {
                $q->where('guru_id', $request->guru_id);
            });
        }

        $jurnal = $query
            ->orderByDesc('tanggal')
            ->orderByDesc('dibuat_pada')
            ->paginate(10)
            ->withQueryString();

        $guru = Pengguna::whereHas('jadwalMengajar')
            ->orderBy('nama_lengkap')
            ->get();

        return view('waka.monitoring-jurnal', compact(
            'jurnal',
            'guru',
            'konfigurasi',
            'siklusAktif'
        ));
    }
}
