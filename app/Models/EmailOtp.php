<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailOtp extends Model
{
    protected $table = 'email_otp';

    public $timestamps = false;

    protected $fillable = [
        'pengguna_id',
        'email',
        'tujuan',
        'kode_hash',
        'percobaan',
        'kedaluwarsa_pada',
        'digunakan_pada',
        'dibuat_pada',
    ];

    protected $casts = [
        'kedaluwarsa_pada' => 'datetime',
        'digunakan_pada'   => 'datetime',
        'dibuat_pada'      => 'datetime',
    ];
}
