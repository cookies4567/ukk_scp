<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MataPelajaran extends Model
{
    protected $table = 'mata_pelajaran';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'kode_mata_pelajaran',
        'nama_mata_pelajaran',
    ];
}