<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $table = 'kelas';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'nama_kelas',
    ];

    public function pengguna()
    {
        return $this->hasMany(Pengguna::class, 'kelas_id');
    }

    public function guruBK()
{
    return $this->belongsToMany(
        Pengguna::class,
        'guru_bk_kelas',
        'kelas_id',
        'guru_bk_id'
    );
}

    public function jadwalPelajaran()
    {
        return $this->hasMany(JadwalPelajaran::class, 'kelas_id');
    }
}