<?php

namespace App\Http\Controllers;

use App\Models\PengajuanIzin;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class VerifikasiIzinController extends Controller
{
   
/**
 * Menentukan batas kelas berdasarkan pengguna yang login.
 *
 * Guru BK (Role 4) = seluruh kelas binaannya akan ditangani
 * melalui pembatasan relasi Guru BK.
 * Wali Kelas (Role 3) = hanya kelas perwaliannya.
 * Guru biasa (Role 2) = tidak memiliki akses verifikasi izin.
 */
private function kelasAkses()
{
    $user = Auth::user();

    // Guru BK: akses kelas akan dibatasi berdasarkan kelas binaannya.
    if ((int) $user->peran_id === 4) {
        return null;
    }

    // Wali Kelas: hanya kelas perwaliannya.
    // Wali kelas (peran 3) atau guru yang merangkap wali kelas (peran 2)
    // hanya boleh memverifikasi izin siswa di kelas perwaliannya.
    if (
        in_array((int) $user->peran_id, [2, 3], true) &&
        !empty($user->kelas_id)
    ) {
        return (int) $user->kelas_id;
    }

    abort(403, 'Anda tidak memiliki akses verifikasi izin.');
}

    /**
     * Memastikan pengajuan izin termasuk kelas yang boleh diakses.
     */
    private function periksaAksesPengajuan(PengajuanIzin $pengajuan)
    {
        $kelasId = $this->kelasAkses();

        // Guru BK boleh mengakses semua kelas.
        if ($kelasId === null) {
            return;
        }

        $pengajuan->loadMissing('siswa');

        abort_unless(
            $pengajuan->siswa &&
            (int) $pengajuan->siswa->kelas_id === $kelasId,
            403,
            'Anda tidak memiliki akses ke pengajuan izin kelas ini.'
        );
    }

    /**
     * Menampilkan pengajuan izin yang masih menunggu.
     */
    public function index()
    {
        $kelasId = $this->kelasAkses();

        $pengajuan = PengajuanIzin::with([
                'siswa.kelas',
                'pengaju',
            ])
            ->where('status_persetujuan', 'Menunggu')
            ->when($kelasId !== null, function ($query) use ($kelasId) {
                $query->whereHas('siswa', function ($siswaQuery) use ($kelasId) {
                    $siswaQuery->where('kelas_id', $kelasId);
                });
            })
            ->orderByDesc('id')
            ->get();

        return view('verifikasi.izin', compact('pengajuan'));
    }

    /**
     * Memproses persetujuan atau penolakan izin.
     */
    public function proses(Request $request, PengajuanIzin $pengajuan)
    {
        // Periksa kelas sebelum pengajuan dapat diproses.
        $this->periksaAksesPengajuan($pengajuan);

        $data = $request->validate([
            'status_persetujuan' => [
                'required',
                'in:Disetujui,Ditolak'
            ],
            'alasan_penolakan' => [
                'required_if:status_persetujuan,Ditolak',
                'nullable',
                'string',
                'max:1000',
            ],
        ], [
            'alasan_penolakan.required_if' => 'Alasan penolakan wajib diisi.',
            'alasan_penolakan.max' => 'Alasan penolakan maksimal 1000 karakter.',
        ]);

        if ($pengajuan->status_persetujuan !== 'Menunggu') {
            return back()->with(
                'error',
                'Pengajuan izin ini sudah diproses sebelumnya.'
            );
        }

        $pengajuan->status_persetujuan = $data['status_persetujuan'];

        $pengajuan->alasan_penolakan =
            $data['status_persetujuan'] === 'Ditolak'
                ? $data['alasan_penolakan']
                : null;

        $pengajuan->diverifikasi_oleh = Auth::id();

        $pengajuan->save();

        return redirect()->route('verifikasi.izin')->with(
            'success',
            $data['status_persetujuan'] === 'Disetujui'
                ? 'Surat izin berhasil disetujui.'
                : 'Surat izin berhasil ditolak.'
        );
    }

    /**
     * Menampilkan riwayat pengajuan yang telah diproses.
     */
    public function riwayat(Request $request)
    {
        $kelasId = $this->kelasAkses();

        // Filter kelas hanya dapat dipilih oleh Guru BK.
        $request->validate([
            'kelas_id' => [
                'nullable',
                'integer',
                'exists:kelas,id'
            ],
        ]);

        $filterKelas = $kelasId !== null
            ? $kelasId
            : $request->input('kelas_id');

        $pengajuan = PengajuanIzin::with([
                'siswa.kelas',
                'pengaju',
                'diverifikasiOleh',
            ])
            ->whereIn('status_persetujuan', [
                'Disetujui',
                'Ditolak'
            ])
            ->when($filterKelas, function ($query, $filterKelas) {
                $query->whereHas('siswa', function ($siswaQuery) use ($filterKelas) {
                    $siswaQuery->where('kelas_id', $filterKelas);
                });
            })
            ->orderByDesc('id')
            ->get();

        // Guru BK mendapatkan daftar seluruh kelas.
        // Guru Wali Kelas hanya mendapatkan kelas perwaliannya.
        $daftarKelas = $kelasId !== null
            ? Kelas::where('id', $kelasId)->get()
            : Kelas::orderBy('nama_kelas')->get();

        return view('verifikasi.riwayat', compact(
            'pengajuan',
            'daftarKelas',
            'filterKelas'
        ))->with('kelasId', $filterKelas);
    }

    /**
     * Membuka dokumen surat izin yang tersimpan secara privat.
     */
    public function dokumen(PengajuanIzin $pengajuan)
    {
        // Pastikan pengguna berhak membuka dokumen ini.
        $this->periksaAksesPengajuan($pengajuan);

        $path = $pengajuan->path_dokumen;

        abort_if(
            !$path || !Storage::disk('local')->exists($path),
            404,
            'Dokumen surat izin tidak ditemukan.'
        );

        $filePath = Storage::disk('local')->path($path);

        $mime = mime_content_type($filePath);

        abort_unless(
            in_array($mime, [
                'application/pdf',
                'image/jpeg',
                'image/png'
            ], true),
            415,
            'Format dokumen tidak didukung.'
        );

        return response()->file($filePath, [
            'Content-Type' => $mime,
            'X-Content-Type-Options' => 'nosniff',
            'Content-Disposition' => 'inline',
        ]);
    }
}
