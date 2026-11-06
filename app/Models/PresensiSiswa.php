<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PresensiSiswa extends Model
{
    protected $table = 'presensi_siswa';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'jurnal_id',
        'siswa_id',
        'status',
        'tanggal',
    ];

    public function jurnal()
    {
        return $this->belongsTo(JurnalMengajar::class, 'jurnal_id');
    }

    public function siswa()
    {
        return $this->belongsTo(Pengguna::class, 'siswa_id');
    }
}
