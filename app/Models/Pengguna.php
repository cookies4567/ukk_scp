<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pengguna extends Authenticatable
{
    use Notifiable;

    protected $table = 'pengguna';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
    'nama_lengkap',
    'username',
    'email',
    'email_verified_at',
    'password',
    'peran_id',
    'kelas_id',
    'nis',
    'jenis_kelamin',
];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function peran()
    {
        return $this->belongsTo(Peran::class, 'peran_id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function kelasBinaanBK()
{
    return $this->belongsToMany(
        Kelas::class,
        'guru_bk_kelas',
        'guru_bk_id',
        'kelas_id'
    );
}

    public function jadwalMengajar()
    {
        return $this->hasMany(JadwalPelajaran::class, 'guru_id');
    }

    public function presensi()
    {
        return $this->hasMany(PresensiSiswa::class, 'siswa_id');
    }

    public function pengajuanIzinSebagaiSiswa()
    {
        return $this->hasMany(PengajuanIzin::class, 'siswa_id');
    }

    public function pengajuanIzinSebagaiPengaju()
    {
        return $this->hasMany(PengajuanIzin::class, 'pengaju_id');
    }

    public function pengajuanIzinDiverifikasi()
    {
        return $this->hasMany(PengajuanIzin::class, 'diverifikasi_oleh');
    }

    public function konfigurasiDiubah()
    {
        return $this->hasMany(KonfigurasiSistem::class, 'diubah_oleh');
    }

    /**
     * Semua peran yang dimiliki akun ini (multi peran).
     *
     * - Wali Kelas (3) otomatis juga berperan sebagai Guru (2),
     *   sehingga bisa mengisi jadwal dan jurnal mengajar.
     * - Guru (2) yang punya kelas perwalian otomatis juga berperan
     *   sebagai Wali Kelas (3).
     */
    public function semuaPeran(): array
    {
        $peran = [(int) $this->peran_id];

        if ($peran[0] === 3) {
            $peran[] = 2;
        }

        if ($peran[0] === 2 && !empty($this->kelas_id)) {
            $peran[] = 3;
        }

        return array_values(array_unique($peran));
    }

    /**
     * Cek apakah akun memiliki salah satu dari peran yang diberikan.
     */
    public function punyaPeran(int ...$peran): bool
    {
        return count(array_intersect($this->semuaPeran(), $peran)) > 0;
    }
}
