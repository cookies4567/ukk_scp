<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ruangan extends Model
{
    protected $table = 'ruangan';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'nama_ruangan',
    ];

    public function jadwalPelajaran()
    {
        return $this->hasMany(JadwalPelajaran::class, 'ruangan_id');
    }
}