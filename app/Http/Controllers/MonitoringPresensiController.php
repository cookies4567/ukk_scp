<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PresensiSiswa;
use App\Models\Kelas;

class MonitoringPresensiController extends Controller
{
    public function index(Request $request)
    {
        // Mengambil data presensi siswa dari jurnal mengajar
        $query = PresensiSiswa::with([
            'siswa.kelas',
            'jurnal.jadwal.guru',
        ])->whereIn('status', [
            'Sakit',
            'Izin',
            'Alpa',
        ]);

        // Filter tanggal
        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        // Filter kelas
        if ($request->filled('kelas_id')) {
            $query->whereHas('siswa', function ($q) use ($request) {
                $q->where('kelas_id', $request->kelas_id);
            });
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Mengambil data presensi
        $presensi = $query
            ->orderByDesc('tanggal')
            ->get();

        // Mengambil daftar kelas untuk filter
        $kelas = Kelas::orderBy('nama_kelas')->get();

        // Menghitung jumlah berdasarkan status
        $jumlahSakit = (clone $query)
            ->where('status', 'Sakit')
            ->count();

        $jumlahIzin = (clone $query)
            ->where('status', 'Izin')
            ->count();

        $jumlahAlpa = (clone $query)
            ->where('status', 'Alpa')
            ->count();

        return view('bk.monitoring-presensi', compact(
            'presensi',
            'kelas',
            'jumlahSakit',
            'jumlahIzin',
            'jumlahAlpa'
        ));
    }
}
