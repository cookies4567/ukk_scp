<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JurnalMengajar extends Model
{
    protected $table = 'jurnal_mengajar';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'jadwal_id',
        'tanggal',
        'deskripsi_materi',
        'path_foto',
        'dibuat_pada',
    ];

    public function jadwal()
    {
        return $this->belongsTo(
            JadwalPelajaran::class,
            'jadwal_id'
        );
    }

    public function presensiSiswa()
    {
        return $this->hasMany(
            PresensiSiswa::class,
            'jurnal_id'
        );
    }
}
