<?php

namespace App\Http\Controllers;

use App\Models\PengajuanIzin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class PengajuanIzinController extends Controller
{
    public function index()
    {
        $pengguna = Auth::user();

        // Siswa hanya melihat pengajuannya sendiri.
        $pengajuan = PengajuanIzin::with(['siswa', 'pengaju'])
            ->where('siswa_id', $pengguna->id)
            ->orderByDesc('id')
            ->get();

        return view('portal.perizinan.index', compact(
            'pengguna',
            'pengajuan'
        ));
    }

    public function create()
    {
        $pengguna = Auth::user();

        return view('portal.perizinan.create', compact('pengguna'));
    }

    public function store(Request $request)
    {
        $pengguna = Auth::user();

        $aturan = [
            
    'tanggal_mulai' => [
    'required',
    'date',
    'after_or_equal:today',
        ],
        'tanggal_selesai' => [
            'required',
            'date',
            'after_or_equal:tanggal_mulai',
            ],

            'alasan' => ['required', 'string', 'max:5000'],
            'dokumen' => [
                'required',
                'file',
                'mimes:pdf,jpg,jpeg,png',
                'max:5120',
            ],
        ];

        $data = $request->validate($aturan);
        $idSiswa = $pengguna->id;

        // Cegah pengajuan baru jika masih ada pengajuan yang menunggu verifikasi.
        $masihMenunggu = PengajuanIzin::where('siswa_id', $idSiswa)
            ->where('status_persetujuan', 'Menunggu')
            ->exists();

        if ($masihMenunggu) {
            throw ValidationException::withMessages([
                'pengajuan' => 'Masih ada pengajuan izin yang menunggu verifikasi. Silakan tunggu keputusan Guru BK terlebih dahulu.',
            ]);
        }

        // Simpan dokumen pada penyimpanan lokal privat.
        $pathDokumen = $request->file('dokumen')
            ->store('pengajuan-izin', 'local');

        if (! $pathDokumen) {
            throw ValidationException::withMessages([
                'dokumen' => 'Dokumen gagal disimpan. Silakan coba kembali.',
            ]);
        }

        try {
            $izin = new PengajuanIzin();
            $izin->siswa_id = $idSiswa;
            $izin->pengaju_id = $pengguna->id;
            $izin->tanggal_mulai = $data['tanggal_mulai'];
            $izin->tanggal_selesai = $data['tanggal_selesai'];
            $izin->alasan = $data['alasan'];
            $izin->path_dokumen = $pathDokumen;
            $izin->status_persetujuan = 'Menunggu';
            $izin->save();
        } catch (\Throwable $e) {
            Storage::disk('local')->delete($pathDokumen);

            throw $e;
        }

        return redirect()
            ->route('portal.perizinan.index')
            ->with('success', 'Pengajuan izin berhasil dikirim.');
    }
}
