<?php

namespace App\Http\Controllers;

use App\Models\JadwalPelajaran;
use App\Models\Kelas;
use App\Models\Ruangan;
use App\Models\KonfigurasiSistem;
use App\Models\MataPelajaran;
use App\Services\PeringatanJurnalService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalController extends Controller
{
    /**
     * Menampilkan daftar jadwal Guru
     */
    public function index()
    {
        $guru = Auth::user();

        $jadwal = JadwalPelajaran::with([
            'kelas',
            'ruangan'
        ])
            ->where('guru_id', $guru->id)
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

        $konfigurasi = KonfigurasiSistem::first();

        return view('guru.jadwal.index', compact(
            'guru',
            'jadwal',
            'konfigurasi'
        ));
    }


    /**
     * Menampilkan form tambah jadwal
     */
    public function create()
    {
        /*
         * Guru tidak boleh menambah jadwal
         * jika jadwal sedang dikunci oleh Waka.
         */
        if ($this->jadwalDikunci()) {
            return redirect()
                ->route('guru.jadwal.index')
                ->with(
                    'error',
                    'Jadwal sedang dikunci oleh Waka Kurikulum.'
                );
        }

        /*
         * Ambil semua kelas dari database.
         *
         * Urutan:
         * X
         * XI
         * XII
         */
        $kelas = Kelas::orderByRaw("
            CASE
                WHEN nama_kelas LIKE 'XII %' THEN 3
                WHEN nama_kelas LIKE 'XI %' THEN 2
                WHEN nama_kelas LIKE 'X %' THEN 1
                ELSE 4
            END
        ")
            ->orderBy('nama_kelas')
            ->get();

        /*
         * Ambil semua ruangan dari database.
         */
        $ruangan = Ruangan::orderBy('nama_ruangan')
            ->get();

        /*
         * Ambil semua mata pelajaran dari database.
         */
        $mataPelajaran = MataPelajaran::orderBy('kode_mata_pelajaran')
            ->get();

        // Siklus aktif dipilih otomatis agar jadwal yang dibuat langsung
        // tampil di Dashboard dan Jurnal Mengajar.
        $siklusAktif = app(PeringatanJurnalService::class)->siklusAktif();

        return view('guru.jadwal.create', compact(
            'kelas',
            'ruangan',
            'mataPelajaran',
            'siklusAktif'
        ));
    }


    /**
     * Menampilkan form edit jadwal
     */
    public function edit(JadwalPelajaran $jadwal)
    {
        $guru = Auth::user();

        /*
         * Guru hanya boleh mengedit jadwal miliknya sendiri.
         */
        if ($jadwal->guru_id != $guru->id) {
            abort(403);
        }

        /*
         * Cek apakah jadwal sedang dikunci oleh Waka.
         */
        if ($this->jadwalDikunci()) {
            return redirect()
                ->route('guru.jadwal.index')
                ->with(
                    'error',
                    'Jadwal sedang dikunci oleh Waka Kurikulum. Perubahan jadwal tidak dapat dilakukan.'
                );
        }

        /*
         * Ambil kelas dari database.
         */
        $kelas = Kelas::orderByRaw("
            CASE
                WHEN nama_kelas LIKE 'XII %' THEN 3
                WHEN nama_kelas LIKE 'XI %' THEN 2
                WHEN nama_kelas LIKE 'X %' THEN 1
                ELSE 4
            END
        ")
            ->orderBy('nama_kelas')
            ->get();

        /*
         * Ambil ruangan dari database.
         */
        $ruangan = Ruangan::orderBy('nama_ruangan')
            ->get();

        /*
         * Ambil mata pelajaran dari database.
         */
        $mataPelajaran = MataPelajaran::orderBy('kode_mata_pelajaran')
            ->get();

        return view('guru.jadwal.edit', compact(
            'guru',
            'jadwal',
            'kelas',
            'ruangan',
            'mataPelajaran'
        ));
    }


    /**
     * Menyimpan jadwal baru
     */
    public function store(Request $request)
    {
        $guru = Auth::user();

        /*
         * Guru tidak boleh menambah jadwal
         * ketika jadwal dikunci.
         */
        if ($this->jadwalDikunci()) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'Jadwal sedang dikunci oleh Waka Kurikulum. Penambahan jadwal tidak dapat dilakukan.'
                );
        }

        /*
         * Validasi data.
         */
        $validated = $request->validate([
            'mata_pelajaran' => 'required|exists:mata_pelajaran,nama_mata_pelajaran',
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'kelas_id' => 'required|exists:kelas,id',
            'ruangan_id' => 'required|exists:ruangan,id',
            'tipe_siklus' => 'required|in:Putaran 1,Putaran 2',
        ], [
            'mata_pelajaran.required' => 'Mata pelajaran wajib dipilih.',
            'mata_pelajaran.exists' => 'Mata pelajaran tidak tersedia di database.',

            'hari.required' => 'Hari wajib dipilih.',
            'hari.in' => 'Hari yang dipilih tidak valid.',

            'jam_mulai.required' => 'Jam mulai wajib diisi.',
            'jam_mulai.date_format' => 'Format jam mulai tidak valid.',

            'jam_selesai.required' => 'Jam selesai wajib diisi.',
            'jam_selesai.date_format' => 'Format jam selesai tidak valid.',
            'jam_selesai.after' => 'Jam selesai harus lebih besar dari jam mulai.',

            'kelas_id.required' => 'Kelas wajib dipilih.',
            'kelas_id.exists' => 'Kelas tidak ditemukan.',

            'ruangan_id.required' => 'Ruangan wajib dipilih.',
            'ruangan_id.exists' => 'Ruangan tidak ditemukan.',

            'tipe_siklus.required' => 'Siklus wajib dipilih.',
            'tipe_siklus.in' => 'Siklus yang dipilih tidak valid.',
        ]);

        // Pasangan jam pelajaran sesuai jadwal sekolah.
        $pasanganJam = [
            '07:15' => '07:55',
            '07:55' => '08:35',
            '08:35' => '09:15',
            '09:30' => '10:10',
            '10:10' => '10:50',
            '10:50' => '11:30',
            '12:30' => '13:10',
            '13:10' => '13:50',
            '13:50' => '14:30',
            '14:30' => '15:10',
        ];

        if (
            !isset($pasanganJam[$validated['jam_mulai']]) ||
            $pasanganJam[$validated['jam_mulai']] !== $validated['jam_selesai']
        ) {
            return back()
                ->withInput()
                ->withErrors([
                    'jam_selesai' => 'Pasangan jam pelajaran tidak sesuai jadwal sekolah.',
                ]);
        }


        /*
         * Pemeriksaan jadwal bentrok.
         *
         * Bentrok jika:
         * - guru sama
         * - kelas sama
         * - ruangan sama
         *
         * pada:
         * - hari yang sama
         * - siklus yang sama
         * - waktu yang saling bertabrakan
         */
        $jadwalBentrok = JadwalPelajaran::with([
            'guru',
            'kelas',
            'ruangan'
        ])
            ->where('hari', $validated['hari'])
            ->where('tipe_siklus', $validated['tipe_siklus'])
            ->where(function ($query) use ($validated) {
                $query
                    ->where(
                        'jam_mulai',
                        '<',
                        $validated['jam_selesai']
                    )
                    ->where(
                        'jam_selesai',
                        '>',
                        $validated['jam_mulai']
                    );
            })
            ->where(function ($query) use ($guru, $validated) {
                $query
                    ->where('guru_id', $guru->id)
                    ->orWhere('kelas_id', $validated['kelas_id'])
                    ->orWhere('ruangan_id', $validated['ruangan_id']);
            })
            ->first();


        /*
         * Jika ditemukan jadwal bentrok.
         */
        if ($jadwalBentrok) {

            $jenisBentrok = [];

            if ($jadwalBentrok->guru_id == $guru->id) {
                $jenisBentrok[] = 'guru';
            }

            if ($jadwalBentrok->kelas_id == $validated['kelas_id']) {
                $jenisBentrok[] = 'kelas';
            }

            if ($jadwalBentrok->ruangan_id == $validated['ruangan_id']) {
                $jenisBentrok[] = 'ruangan';
            }

            $jenisBentrokText = implode(', ', $jenisBentrok);

            $jamMulaiBentrok = substr(
                $jadwalBentrok->jam_mulai,
                0,
                5
            );

            $jamSelesaiBentrok = substr(
                $jadwalBentrok->jam_selesai,
                0,
                5
            );

            return back()
    ->withInput()
    ->with(
        'error',
        'Jadwal ' . $validated['hari'] .
        ' pukul ' . $jamMulaiBentrok .
        ' - ' . $jamSelesaiBentrok .
        ' bertabrakan dengan jadwal lain. Bentrok dengan: ' .
        $jenisBentrokText . '.'
    );
        }


        /*
         * Simpan jadwal baru.
         */
        JadwalPelajaran::create([
            'guru_id' => $guru->id,
            'kelas_id' => $validated['kelas_id'],
            'ruangan_id' => $validated['ruangan_id'],
            'mata_pelajaran' => $validated['mata_pelajaran'],
            'hari' => $validated['hari'],
            'jam_mulai' => $validated['jam_mulai'],
            'jam_selesai' => $validated['jam_selesai'],
            'tipe_siklus' => $validated['tipe_siklus'],
        ]);


        [$jenisPesan, $pesan] = $this->pesanSetelahSimpan(
            $validated['hari'],
            $validated['tipe_siklus'],
            'Jadwal berhasil ditambahkan.'
        );

        return redirect()
            ->route('guru.jadwal.index')
            ->with($jenisPesan, $pesan);
    }


    /**
     * Memperbarui jadwal
     */
    public function update(
        Request $request,
        JadwalPelajaran $jadwal
    ) {
        $guru = Auth::user();

        /*
         * Guru hanya boleh mengubah jadwal miliknya.
         */
        if ($jadwal->guru_id != $guru->id) {
            abort(403);
        }

        /*
         * Guru tidak boleh mengubah jadwal ketika dikunci.
         */
        if ($this->jadwalDikunci()) {
            return redirect()
                ->route('guru.jadwal.index')
                ->with(
                    'error',
                    'Jadwal sedang dikunci oleh Waka Kurikulum. Perubahan jadwal tidak dapat dilakukan.'
                );
        }

        /*
         * Validasi data.
         */
        $validated = $request->validate([
            'mata_pelajaran' => 'required|exists:mata_pelajaran,nama_mata_pelajaran',
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'kelas_id' => 'required|exists:kelas,id',
            'ruangan_id' => 'required|exists:ruangan,id',
            'tipe_siklus' => 'required|in:Putaran 1,Putaran 2',
        ], [
            'mata_pelajaran.required' => 'Mata pelajaran wajib dipilih.',
            'mata_pelajaran.exists' => 'Mata pelajaran tidak tersedia di database.',

            'hari.required' => 'Hari wajib dipilih.',
            'hari.in' => 'Hari yang dipilih tidak valid.',

            'jam_mulai.required' => 'Jam mulai wajib diisi.',
            'jam_mulai.date_format' => 'Format jam mulai tidak valid.',

            'jam_selesai.required' => 'Jam selesai wajib diisi.',
            'jam_selesai.date_format' => 'Format jam selesai tidak valid.',
            'jam_selesai.after' => 'Jam selesai harus lebih besar dari jam mulai.',

            'kelas_id.required' => 'Kelas wajib dipilih.',
            'kelas_id.exists' => 'Kelas tidak ditemukan.',

            'ruangan_id.required' => 'Ruangan wajib dipilih.',
            'ruangan_id.exists' => 'Ruangan tidak ditemukan.',

            'tipe_siklus.required' => 'Siklus wajib dipilih.',
            'tipe_siklus.in' => 'Siklus yang dipilih tidak valid.',
        ]);

        // Pasangan jam pelajaran sesuai jadwal sekolah.
        $pasanganJam = [
            '07:15' => '07:55',
            '07:55' => '08:35',
            '08:35' => '09:15',
            '09:30' => '10:10',
            '10:10' => '10:50',
            '10:50' => '11:30',
            '12:30' => '13:10',
            '13:10' => '13:50',
            '13:50' => '14:30',
            '14:30' => '15:10',
        ];

        if (
            !isset($pasanganJam[$validated['jam_mulai']]) ||
            $pasanganJam[$validated['jam_mulai']] !== $validated['jam_selesai']
        ) {
            return back()
                ->withInput()
                ->withErrors([
                    'jam_selesai' => 'Pasangan jam pelajaran tidak sesuai jadwal sekolah.',
                ]);
        }


        /*
         * Pemeriksaan jadwal bentrok.
         *
         * Jadwal yang sedang diedit dikecualikan.
         */
        $jadwalBentrok = JadwalPelajaran::with([
            'guru',
            'kelas',
            'ruangan'
        ])
            ->where('id', '!=', $jadwal->id)
            ->where('hari', $validated['hari'])
            ->where('tipe_siklus', $validated['tipe_siklus'])
            ->where(function ($query) use ($validated) {
                $query
                    ->where(
                        'jam_mulai',
                        '<',
                        $validated['jam_selesai']
                    )
                    ->where(
                        'jam_selesai',
                        '>',
                        $validated['jam_mulai']
                    );
            })
            ->where(function ($query) use ($guru, $validated) {
                $query
                    ->where('guru_id', $guru->id)
                    ->orWhere('kelas_id', $validated['kelas_id'])
                    ->orWhere('ruangan_id', $validated['ruangan_id']);
            })
            ->first();


        /*
         * Jika ditemukan jadwal bentrok.
         */
        if ($jadwalBentrok) {

            $jenisBentrok = [];

            if ($jadwalBentrok->guru_id == $guru->id) {
                $jenisBentrok[] = 'guru';
            }

            if ($jadwalBentrok->kelas_id == $validated['kelas_id']) {
                $jenisBentrok[] = 'kelas';
            }

            if ($jadwalBentrok->ruangan_id == $validated['ruangan_id']) {
                $jenisBentrok[] = 'ruangan';
            }

            $jenisBentrokText = implode(', ', $jenisBentrok);

            $jamMulaiBentrok = substr(
                $jadwalBentrok->jam_mulai,
                0,
                5
            );

            $jamSelesaiBentrok = substr(
                $jadwalBentrok->jam_selesai,
                0,
                5
            );

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Jadwal bentrok pada ' .
                    $validated['hari'] .
                    ' pukul ' .
                    $jamMulaiBentrok .
                    ' - ' .
                    $jamSelesaiBentrok .
                    '. Bentrok dengan ' .
                    $jenisBentrokText .
                    '.'
                );
        }


        /*
         * Update jadwal.
         */
        $jadwal->update([
            'kelas_id' => $validated['kelas_id'],
            'ruangan_id' => $validated['ruangan_id'],
            'mata_pelajaran' => $validated['mata_pelajaran'],
            'hari' => $validated['hari'],
            'jam_mulai' => $validated['jam_mulai'],
            'jam_selesai' => $validated['jam_selesai'],
            'tipe_siklus' => $validated['tipe_siklus'],
        ]);


        [$jenisPesan, $pesan] = $this->pesanSetelahSimpan(
            $validated['hari'],
            $validated['tipe_siklus'],
            'Jadwal berhasil diperbarui.'
        );

        return redirect()
            ->route('guru.jadwal.index')
            ->with($jenisPesan, $pesan);
    }


    /**
     * Menghapus jadwal
     */
    public function destroy(JadwalPelajaran $jadwal)
    {
        $guru = Auth::user();

        /*
         * Guru hanya boleh menghapus jadwal miliknya.
         */
        if ($jadwal->guru_id != $guru->id) {
            abort(403);
        }

        /*
         * Guru tidak boleh menghapus jadwal ketika dikunci.
         */
        if ($this->jadwalDikunci()) {
            return redirect()
                ->route('guru.jadwal.index')
                ->with(
                    'error',
                    'Jadwal sedang dikunci oleh Waka Kurikulum. Penghapusan jadwal tidak dapat dilakukan.'
                );
        }

        $jadwal->delete();

        return redirect()
            ->route('guru.jadwal.index')
            ->with(
                'success',
                'Jadwal berhasil dihapus.'
            );
    }


    /**
     * Menentukan pesan setelah jadwal disimpan, agar guru tahu
     * apakah jadwal langsung tampil di Dashboard dan Jurnal Mengajar.
     *
     * @return array{0: string, 1: string}  [jenis flash, pesan]
     */
    private function pesanSetelahSimpan(
        string $hari,
        string $siklus,
        string $pesanDasar
    ): array {
        $layanan = app(PeringatanJurnalService::class);
        $siklusAktif = $layanan->siklusAktif();

        if ($siklus !== $siklusAktif) {
            return [
                'warning',
                $pesanDasar . ' Jadwal ini berada di ' . $siklus .
                ', sedangkan siklus aktif saat ini adalah ' . $siklusAktif .
                ', sehingga belum tampil di Dashboard dan Jurnal Mengajar ' .
                'sampai siklusnya aktif.',
            ];
        }

        if ($hari === $layanan->namaHari()) {
            return [
                'success',
                $pesanDasar . ' Jadwal hari ini sudah tampil di Dashboard ' .
                'dan Jurnal Mengajar.',
            ];
        }

        return ['success', $pesanDasar];
    }

    /**
     * Mengecek apakah jadwal sedang dikunci.
     */
    private function jadwalDikunci()
    {
        $konfigurasi = KonfigurasiSistem::first();

        return $konfigurasi
            && $konfigurasi->jadwal_dikunci;
    }
}