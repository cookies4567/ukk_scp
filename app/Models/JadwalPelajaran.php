<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalPelajaran extends Model
{
    protected $table = 'jadwal_pelajaran';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'guru_id',
        'kelas_id',
        'ruangan_id',
        'mata_pelajaran',
        'hari',
        'jam_mulai',
        'jam_selesai',
        'tipe_siklus',
    ];

    public function guru()
    {
        return $this->belongsTo(
            Pengguna::class,
            'guru_id'
        );
    }

    public function kelas()
    {
        return $this->belongsTo(
            Kelas::class,
            'kelas_id'
        );
    }

    public function ruangan()
    {
        return $this->belongsTo(
            Ruangan::class,
            'ruangan_id'
        );
    }

    public function jurnalMengajar()
    {
        return $this->hasMany(
            JurnalMengajar::class,
            'jadwal_id'
        );
    }
}