<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengajuanIzin extends Model
{
    protected $table = 'pengajuan_izin';

    protected $primaryKey = 'id';

    public $timestamps = false;

    public function siswa()
    {
        return $this->belongsTo(Pengguna::class, 'siswa_id');
    }

    public function pengaju()
    {
        return $this->belongsTo(Pengguna::class, 'pengaju_id');
    }

    public function diverifikasiOleh()
    {
        return $this->belongsTo(Pengguna::class, 'diverifikasi_oleh');
    }
}