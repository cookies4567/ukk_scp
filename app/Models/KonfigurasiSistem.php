<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KonfigurasiSistem extends Model
{
    protected $table = 'konfigurasi_sistem';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'siklus_aktif',
        'jadwal_dikunci',
        'diubah_oleh',
    ];

    protected $casts = [
        'jadwal_dikunci' => 'boolean',
    ];

    public function diubahOleh()
    {
        return $this->belongsTo(Pengguna::class, 'diubah_oleh');
    }
}