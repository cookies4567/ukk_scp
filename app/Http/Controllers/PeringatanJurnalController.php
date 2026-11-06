<?php

namespace App\Http\Controllers;

use App\Services\PeringatanJurnalService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class PeringatanJurnalController extends Controller
{
    public function __construct(
        private PeringatanJurnalService $peringatan
    ) {
    }

    /**
     * Mengembalikan potongan HTML kartu peringatan jurnal terbaru
     * (dipakai polling di dashboard Guru dan Wali Kelas).
     */
    public function index(): Response
    {
        $peringatanJurnal = $this->peringatan->peringatanUntukGuru(Auth::user());

        return response(
            view('partials.peringatan-jurnal', compact('peringatanJurnal'))->render()
        )->header('Cache-Control', 'no-store');
    }
}
