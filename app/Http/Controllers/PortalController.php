<?php

namespace App\Http\Controllers;

use App\Models\PengajuanIzin;
use App\Models\PresensiSiswa;
use Illuminate\Support\Facades\Auth;

class PortalController extends Controller
{
    public function dashboard()
    {
        $pengguna = Auth::user();

        // Siswa hanya melihat data miliknya sendiri.
        $idSiswa = collect([$pengguna->id]);

        $rekapPresensi = [
            'Hadir' => 0,
            'Izin' => 0,
            'Sakit' => 0,
            'Alpa' => 0,
        ];

        if ($idSiswa->isNotEmpty()) {
            $hasilRekap = PresensiSiswa::whereIn('siswa_id', $idSiswa)
                ->selectRaw('status, COUNT(*) as jumlah')
                ->groupBy('status')
                ->pluck('jumlah', 'status');

            foreach ($rekapPresensi as $status => $jumlah) {
                $rekapPresensi[$status] =
                    (int) ($hasilRekap[$status] ?? 0);
            }
        }

        $pengajuanTerbaru = PengajuanIzin::with(['siswa', 'pengaju'])
            ->whereIn('siswa_id', $idSiswa)
            ->orderByDesc('id')
            ->take(5)
            ->get();

        $jumlahPengajuanMenunggu = PengajuanIzin::whereIn(
            'siswa_id',
            $idSiswa
        )
            ->where('status_persetujuan', 'Menunggu')
            ->count();

        return view('portal.dashboard', compact(
            'pengguna',
            'rekapPresensi',
            'pengajuanTerbaru',
            'jumlahPengajuanMenunggu'
        ));
    }
}
