<?php

namespace App\Services;

use App\Models\JadwalPelajaran;
use App\Models\KonfigurasiSistem;
use App\Models\Pengguna;
use Carbon\Carbon;
use Illuminate\Support\Collection;

/**
 * Satu-satunya sumber aturan peringatan jurnal mengajar untuk
 * Guru dan Wali Kelas (yang merangkap Guru).
 *
 * Aturan:
 * - Hanya jadwal hari ini pada siklus yang sedang aktif.
 * - Jurnal dianggap sudah diisi bila ada jurnal bertanggal hari ini
 *   untuk jadwal tersebut.
 * - Peringatan muncul 30 menit sebelum jam selesai  -> "Belum Diisi".
 * - Setelah jam selesai terlewati                    -> "Terlambat".
 * - Setelah jurnal hari ini diisi, peringatan hilang.
 *
 * (Dashboard Alert Waka tetap memakai aturan sendiri: jurnal belum
 * diisi lebih dari 30 menit SETELAH jam selesai.)
 */
class PeringatanJurnalService
{
    public const MENIT_SEBELUM_SELESAI = 30;

    public const STATUS_SUDAH = 'Sudah Diisi';
    public const STATUS_BELUM = 'Belum Diisi';
    public const STATUS_TERLAMBAT = 'Terlambat';
    public const STATUS_MENUNGGU = 'Belum Waktunya';

    private const NAMA_HARI = [
        1 => 'Senin',
        2 => 'Selasa',
        3 => 'Rabu',
        4 => 'Kamis',
        5 => 'Jumat',
        6 => 'Sabtu',
        7 => 'Minggu',
    ];

    public function siklusAktif(): string
    {
        return KonfigurasiSistem::first()?->siklus_aktif ?? 'Putaran 1';
    }

    public function namaHari(?Carbon $waktu = null): string
    {
        $waktu ??= now();

        return self::NAMA_HARI[$waktu->dayOfWeekIso];
    }

    /**
     * Jadwal milik guru untuk hari ini pada siklus aktif.
     * Setiap item diberi:
     * - jurnal_hari_ini : model jurnal hari ini (atau null)
     * - status_jurnal   : Sudah Diisi / Belum Diisi / Terlambat / Belum Waktunya
     */
    public function jadwalHariIni(Pengguna $guru, ?Carbon $sekarang = null): Collection
    {
        $sekarang ??= now();
        $tanggal = $sekarang->toDateString();

        return JadwalPelajaran::with([
            'kelas',
            'ruangan',
            'jurnalMengajar' => fn ($q) => $q->whereDate('tanggal', $tanggal),
        ])
            ->where('guru_id', $guru->id)
            ->where('hari', $this->namaHari($sekarang))
            ->where('tipe_siklus', $this->siklusAktif())
            ->orderBy('jam_mulai')
            ->get()
            ->each(function (JadwalPelajaran $jadwal) use ($sekarang) {
                $jadwal->jurnal_hari_ini = $jadwal->jurnalMengajar->first();
                $jadwal->status_jurnal = $this->status(
                    $jadwal,
                    $sekarang,
                    $jadwal->jurnal_hari_ini !== null
                );
            });
    }

    public function status(
        JadwalPelajaran $jadwal,
        Carbon $sekarang,
        bool $sudahDiisiHariIni
    ): string {
        if ($sudahDiisiHariIni) {
            return self::STATUS_SUDAH;
        }

        $selesai = Carbon::parse(
            $sekarang->toDateString() . ' ' . $jadwal->jam_selesai
        );

        if ($sekarang->greaterThan($selesai)) {
            return self::STATUS_TERLAMBAT;
        }

        if ($sekarang->greaterThanOrEqualTo(
            $selesai->copy()->subMinutes(self::MENIT_SEBELUM_SELESAI)
        )) {
            return self::STATUS_BELUM;
        }

        return self::STATUS_MENUNGGU;
    }

    /**
     * Jadwal hari ini yang perlu ditampilkan sebagai peringatan.
     */
    public function peringatan(Collection $jadwalHariIni): Collection
    {
        return $jadwalHariIni
            ->filter(fn ($jadwal) => in_array($jadwal->status_jurnal, [
                self::STATUS_BELUM,
                self::STATUS_TERLAMBAT,
            ], true))
            ->values();
    }

    /**
     * Pintasan: peringatan jurnal hari ini untuk satu guru.
     */
    public function peringatanUntukGuru(Pengguna $guru, ?Carbon $sekarang = null): Collection
    {
        return $this->peringatan($this->jadwalHariIni($guru, $sekarang));
    }
}
