<?php

namespace App\Http\Controllers;

use App\Services\PeringatanJurnalService;
use Illuminate\Support\Facades\Auth;

class KesiswaanController extends Controller
{
    public function __construct(
        private PeringatanJurnalService $peringatan
    ) {
    }

    /**
     * Dashboard Wali Kelas dan Guru BK.
     * Peringatan jurnal hanya untuk akun yang juga mengajar
     * (Wali Kelas otomatis berperan sebagai Guru).
     */
    public function dashboard()
    {
        $user = Auth::user();

        $punyaJadwalMengajar = $user->punyaPeran(2);

        $peringatanJurnal = $punyaJadwalMengajar
            ? $this->peringatan->peringatanUntukGuru($user)
            : collect();

        return view('kesiswaan.dashboard', compact(
            'user',
            'punyaJadwalMengajar',
            'peringatanJurnal'
        ));
    }
}
