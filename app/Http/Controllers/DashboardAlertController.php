<?php

namespace App\Http\Controllers;

use App\Models\JadwalPelajaran;
use App\Models\KonfigurasiSistem;
use App\Models\JurnalMengajar;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class DashboardAlertController extends Controller
{
    /**
     * Menampilkan halaman Dashboard Alert.
     */
    public function index(): View
    {
        $data = $this->getAlertData();

        return view('waka.dashboard-alert', $data);
    }

    /**
     * Mengirim data alert terbaru dalam format JSON.
     */
    public function data(): JsonResponse
    {
        $data = $this->getAlertData();

        return response()->json([
            'total' => $data['alert']->count(),
            'alerts' => $data['alert']->map(function ($item) {
                return [
                    'id' => $item->id,
                    'guru' => $item->guru?->nama_lengkap ?? '-',
                    'mata_pelajaran' => $item->mata_pelajaran ?? '-',
                    'kelas' => $item->kelas?->nama_kelas ?? '-',
                    'jam_selesai' => $item->jam_selesai,
                ];
            })->values(),
            'waktu' => $data['waktuSekarang']->format('H:i:s'),
        ]);
    }

    /**
     * Mengambil jadwal yang terlambat diisi jurnal.
     */
    private function getAlertData(): array
    {
        $konfigurasi = KonfigurasiSistem::first();

        $siklusAktif = $konfigurasi?->siklus_aktif
            ?? 'Putaran 1';

        $sekarang = now();
        $tanggalHariIni = $sekarang->toDateString();

        $hariIni = [
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu',
            7 => 'Minggu',
        ][$sekarang->dayOfWeekIso];

        $jadwalHariIni = JadwalPelajaran::with([
            'guru',
            'kelas',
            'ruangan',
        ])
            ->where('hari', $hariIni)
            ->where('tipe_siklus', $siklusAktif)
            ->whereNotNull('jam_selesai')
            ->whereRaw(
                "ADDTIME(jam_selesai, '00:30:00') <= ?",
                [$sekarang->format('H:i:s')]
            )
            ->orderBy('jam_selesai')
            ->get();

        $alert = $jadwalHariIni
            ->filter(function ($jadwal) use ($tanggalHariIni) {
                return !JurnalMengajar::where(
                    'jadwal_id',
                    $jadwal->id
                )
                    ->whereDate('tanggal', $tanggalHariIni)
                    ->exists();
            })
            ->values();

        return [
            'konfigurasi' => $konfigurasi,
            'siklusAktif' => $siklusAktif,
            'alert' => $alert,
            'waktuSekarang' => $sekarang,
        ];
    }
}
