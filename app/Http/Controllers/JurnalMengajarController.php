<?php

namespace App\Http\Controllers;

use App\Models\JadwalPelajaran;
use App\Models\JurnalMengajar;
use App\Models\KonfigurasiSistem;
use App\Models\Pengguna;
use App\Services\PeringatanJurnalService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class JurnalMengajarController extends Controller
{
    // Halaman utama jurnal mengajar
    public function index(PeringatanJurnalService $peringatan)
    {
        $guru = Auth::user();

        $konfigurasi = KonfigurasiSistem::first();

        $siklusAktif = $peringatan->siklusAktif();

        $sekarang = now();
        $tanggalHariIni = $sekarang->toDateString();
        $hariIni = $peringatan->namaHari($sekarang);

        $urutanHari = [
            'Senin' => 1, 'Selasa' => 2, 'Rabu' => 3,
            'Kamis' => 4, 'Jumat' => 5, 'Sabtu' => 6, 'Minggu' => 7,
        ];

        $jadwal = JadwalPelajaran::with([
            'kelas',
            'ruangan',
            'jurnalMengajar'
        ])
            ->where('guru_id', $guru->id)
            ->where('tipe_siklus', $siklusAktif)
            ->get()
            ->each(function (JadwalPelajaran $item) use (
                $peringatan,
                $sekarang,
                $tanggalHariIni,
                $hariIni
            ) {
                $item->adalah_hari_ini = $item->hari === $hariIni;

                // Jurnal bertanggal hari ini (bukan jurnal kapan pun).
                $item->jurnal_hari_ini = $item->jurnalMengajar
                    ->first(fn ($j) => substr((string) $j->tanggal, 0, 10) === $tanggalHariIni);

                $item->jurnal_terakhir = $item->jurnalMengajar
                    ->sortByDesc('tanggal')
                    ->first();

                $item->status_jurnal = $item->adalah_hari_ini
                    ? $peringatan->status(
                        $item,
                        $sekarang,
                        $item->jurnal_hari_ini !== null
                    )
                    : null;
            })
            // Jadwal hari ini tampil paling atas, sisanya urut hari & jam.
            ->sortBy(fn ($item) => [
                $item->adalah_hari_ini ? 0 : 1,
                $urutanHari[$item->hari] ?? 99,
                $item->jam_mulai,
            ])
            ->values();

        $peringatanJurnal = $jadwal
            ->filter(fn ($item) => $item->adalah_hari_ini)
            ->pipe(fn ($hariIniSaja) => $peringatan->peringatan($hariIniSaja));

        return view('guru.jurnal.index', [
            'guru' => $guru,
            'jadwal' => $jadwal,
            'konfigurasi' => $konfigurasi,
            'siklusAktif' => $siklusAktif,
            'tanggalHariIni' => $tanggalHariIni,
            'hariIni' => $hariIni,
            'peringatanJurnal' => $peringatanJurnal,
        ]);
    }

    // Form input jurnal dan daftar presensi siswa
    public function create(JadwalPelajaran $jadwal)
    {
        $guru = Auth::user();

        if ($jadwal->guru_id != $guru->id) {
            abort(403);
        }

        $jadwal->load(['kelas', 'ruangan']);

        // Ambil siswa sesuai kelas pada jadwal.
        // Peran ID 5 adalah Siswa.
        $siswa = Pengguna::where('peran_id', 5)
            ->where('kelas_id', $jadwal->kelas_id)
            ->orderBy('nama_lengkap')
            ->get();

        return view('guru.jurnal.create', [
            'guru' => $guru,
            'jadwal' => $jadwal,
            'siswa' => $siswa,
        ]);
    }

    // Simpan jurnal beserta presensi siswa
    public function store(Request $request, JadwalPelajaran $jadwal)
    {
        $guru = Auth::user();

        // Pastikan jadwal milik guru yang sedang login.
        if ($jadwal->guru_id != $guru->id) {
            abort(403);
        }

        // Validasi data jurnal dan presensi.
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'deskripsi_materi' => 'required|string|max:5000',
            'path_foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'presensi' => 'required|array|min:1',
            'presensi.*' => 'required|in:Hadir,Izin,Sakit,Alpa',
        ], [
            'tanggal.required' => 'Tanggal jurnal wajib diisi.',
            'deskripsi_materi.required' => 'Materi atau kegiatan pembelajaran wajib diisi.',
            'deskripsi_materi.max' => 'Materi atau kegiatan terlalu panjang.',
            'path_foto.image' => 'File harus berupa gambar.',
            'path_foto.mimes' => 'Foto harus berformat JPG, JPEG, PNG, atau WEBP.',
            'path_foto.max' => 'Ukuran foto maksimal 2 MB.',
            'presensi.required' => 'Data presensi siswa wajib diisi.',
            'presensi.array' => 'Format data presensi tidak valid.',
            'presensi.*.required' => 'Status kehadiran setiap siswa wajib dipilih.',
            'presensi.*.in' => 'Status kehadiran tidak valid.',
        ]);

        // Ambil ID seluruh siswa yang terdaftar di kelas jadwal.
        $siswaIds = Pengguna::where('peran_id', 5)
            ->where('kelas_id', $jadwal->kelas_id)
            ->pluck('id')
            ->map(fn ($id) => (string) $id)
            ->all();

        $presensiIds = array_map(
            'strval',
            array_keys($validated['presensi'])
        );

        // Pastikan daftar presensi sesuai dengan siswa kelas tersebut.
        if (
            count($siswaIds) !== count($presensiIds) ||
            count(array_diff($siswaIds, $presensiIds)) > 0 ||
            count(array_diff($presensiIds, $siswaIds)) > 0
        ) {
            throw ValidationException::withMessages([
                'presensi' => 'Daftar presensi tidak sesuai dengan siswa pada kelas ini. Silakan muat ulang halaman.',
            ]);
        }

        // Periksa jurnal duplikat.
        $jurnalSudahAda = JurnalMengajar::where('jadwal_id', $jadwal->id)
            ->where('tanggal', $validated['tanggal'])
            ->exists();

        if ($jurnalSudahAda) {
            return redirect()
                ->route('guru.jurnal.index')
                ->with(
                    'error',
                    'Jurnal untuk jadwal dan tanggal tersebut sudah diisi.'
                );
        }

        // Upload foto dokumentasi.
        $namaFoto = null;

        if ($request->hasFile('path_foto')) {
            $namaFoto = $request->file('path_foto')
                ->store('jurnal', 'public');
        }

        try {
            DB::transaction(function () use (
                $jadwal,
                $validated,
                $namaFoto
            ) {
                // Simpan jurnal mengajar.
                $jurnal = JurnalMengajar::create([
                    'jadwal_id' => $jadwal->id,
                    'tanggal' => $validated['tanggal'],
                    'deskripsi_materi' => $validated['deskripsi_materi'],
                    'path_foto' => $namaFoto,
                    'dibuat_pada' => now(),
                ]);

                // Siapkan seluruh data presensi.
                $dataPresensi = [];

                foreach ($validated['presensi'] as $siswaId => $status) {
                    $dataPresensi[] = [
                        'siswa_id' => $siswaId,
                        'status' => $status,
                        'tanggal' => $validated['tanggal'],
                    ];
                }

                // Simpan seluruh presensi melalui relasi jurnal.
                $jurnal->presensiSiswa()->createMany($dataPresensi);
            });
        } catch (\Throwable $e) {
            if ($namaFoto) {
                Storage::disk('public')->delete($namaFoto);
            }

            throw $e;
        }

        return redirect()
            ->route('guru.jurnal.index')
            ->with(
                'success',
                'Jurnal dan presensi siswa berhasil disimpan.'
            );
    }

    // Menampilkan form edit jurnal dan presensi siswa
    public function edit(
        JadwalPelajaran $jadwal,
        JurnalMengajar $jurnal
    ) {
        $guru = Auth::user();

        // Pastikan jadwal milik guru yang sedang login.
        if ($jadwal->guru_id != $guru->id) {
            abort(403);
        }

        // Pastikan jurnal benar-benar milik jadwal tersebut.
        if ($jurnal->jadwal_id != $jadwal->id) {
            abort(404);
        }

        $jadwal->load(['kelas', 'ruangan']);

        // Ambil seluruh siswa sesuai kelas.
        $siswa = Pengguna::where('peran_id', 5)
            ->where('kelas_id', $jadwal->kelas_id)
            ->orderBy('nama_lengkap')
            ->get();

        // Ambil presensi yang sudah tersimpan.
        $presensi = $jurnal->presensiSiswa()
            ->get()
            ->keyBy('siswa_id');

        return view('guru.jurnal.edit', [
            'guru' => $guru,
            'jadwal' => $jadwal,
            'jurnal' => $jurnal,
            'siswa' => $siswa,
            'presensi' => $presensi,
        ]);
    }

    // Memperbarui jurnal dan presensi siswa
    public function update(
        Request $request,
        JadwalPelajaran $jadwal,
        JurnalMengajar $jurnal
    ) {
        $guru = Auth::user();

        // Pastikan jadwal milik guru yang sedang login.
        if ($jadwal->guru_id != $guru->id) {
            abort(403);
        }

        // Pastikan jurnal benar-benar milik jadwal tersebut.
        if ($jurnal->jadwal_id != $jadwal->id) {
            abort(404);
        }

        // Validasi data yang dikirim dari form edit.
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'deskripsi_materi' => 'required|string|max:5000',
            'path_foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'presensi' => 'required|array|min:1',
            'presensi.*' => 'required|in:Hadir,Izin,Sakit,Alpa',
        ], [
            'tanggal.required' => 'Tanggal jurnal wajib diisi.',
            'deskripsi_materi.required' => 'Materi atau kegiatan pembelajaran wajib diisi.',
            'deskripsi_materi.max' => 'Materi atau kegiatan terlalu panjang.',
            'path_foto.image' => 'File harus berupa gambar.',
            'path_foto.mimes' => 'Foto harus berformat JPG, JPEG, PNG, atau WEBP.',
            'path_foto.max' => 'Ukuran foto maksimal 2 MB.',
            'presensi.required' => 'Data presensi siswa wajib diisi.',
            'presensi.array' => 'Format data presensi tidak valid.',
            'presensi.*.required' => 'Status kehadiran setiap siswa wajib dipilih.',
            'presensi.*.in' => 'Status kehadiran tidak valid.',
        ]);

        // Ambil ID seluruh siswa yang terdaftar di kelas jadwal.
        $siswaIds = Pengguna::where('peran_id', 5)
            ->where('kelas_id', $jadwal->kelas_id)
            ->pluck('id')
            ->map(fn ($id) => (string) $id)
            ->all();

        $presensiIds = array_map(
            'strval',
            array_keys($validated['presensi'])
        );

        // Pastikan presensi hanya berisi siswa dari kelas tersebut.
        if (
            count($siswaIds) !== count($presensiIds) ||
            count(array_diff($siswaIds, $presensiIds)) > 0 ||
            count(array_diff($presensiIds, $siswaIds)) > 0
        ) {
            throw ValidationException::withMessages([
                'presensi' => 'Daftar presensi tidak sesuai dengan siswa pada kelas ini. Silakan muat ulang halaman.',
            ]);
        }

        // Cegah tanggal jurnal bertabrakan dengan jurnal lain
        // pada jadwal yang sama.
        $jurnalDuplikat = JurnalMengajar::where('jadwal_id', $jadwal->id)
            ->where('tanggal', $validated['tanggal'])
            ->where('id', '!=', $jurnal->id)
            ->exists();

        if ($jurnalDuplikat) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'Sudah ada jurnal lain untuk jadwal dan tanggal tersebut.'
                );
        }

        // Simpan informasi foto lama.
        $fotoLama = $jurnal->path_foto;
        $namaFotoBaru = null;

        // Upload foto baru jika guru memilih foto.
        if ($request->hasFile('path_foto')) {
            $namaFotoBaru = $request->file('path_foto')
                ->store('jurnal', 'public');
        }

        try {
            DB::transaction(function () use (
                $jurnal,
                $validated,
                $namaFotoBaru
            ) {
                // Perbarui data jurnal.
                $dataJurnal = [
                    'tanggal' => $validated['tanggal'],
                    'deskripsi_materi' => $validated['deskripsi_materi'],
                ];

                // Ganti foto hanya jika ada foto baru.
                if ($namaFotoBaru) {
                    $dataJurnal['path_foto'] = $namaFotoBaru;
                }

                $jurnal->update($dataJurnal);

                // Perbarui presensi setiap siswa.
                foreach ($validated['presensi'] as $siswaId => $status) {
                    $jurnal->presensiSiswa()->updateOrCreate(
                        [
                            'siswa_id' => $siswaId,
                        ],
                        [
                            'status' => $status,
                            'tanggal' => $validated['tanggal'],
                        ]
                    );
                }
            });
        } catch (\Throwable $e) {
            // Hapus foto baru jika proses penyimpanan gagal.
            if ($namaFotoBaru) {
                Storage::disk('public')->delete($namaFotoBaru);
            }

            throw $e;
        }

        // Hapus foto lama setelah perubahan berhasil disimpan.
        if ($namaFotoBaru && $fotoLama) {
            Storage::disk('public')->delete($fotoLama);
        }

        return redirect()
            ->route('guru.jurnal.index')
            ->with(
                'success',
                'Jurnal dan presensi siswa berhasil diperbarui.'
            );
    }
}