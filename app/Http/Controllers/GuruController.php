<?php

namespace App\Http\Controllers;

use App\Models\KonfigurasiSistem;
use App\Services\PeringatanJurnalService;
use Illuminate\Support\Facades\Auth;

class GuruController extends Controller
{
    public function __construct(
        private PeringatanJurnalService $peringatan
    ) {
    }

    public function dashboard()
    {
        $guru = Auth::user();

        $sekarang = now();

        $hariIni = $this->peringatan->namaHari($sekarang);
        $siklusAktif = $this->peringatan->siklusAktif();
        $konfigurasi = KonfigurasiSistem::first();

        // Jadwal hari ini (siklus aktif) beserta status jurnal hari ini.
        $jadwalHariIni = $this->peringatan->jadwalHariIni($guru, $sekarang);

        // Jadwal yang perlu diperingatkan: 30 menit sebelum selesai
        // sampai jurnal diisi.
        $peringatanJurnal = $this->peringatan->peringatan($jadwalHariIni);

        return view('guru.dashboard', compact(
            'guru',
            'jadwalHariIni',
            'hariIni',
            'konfigurasi',
            'siklusAktif',
            'peringatanJurnal'
        ));
    }
}
