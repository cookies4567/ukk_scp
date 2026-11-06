<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peran extends Model
{
    protected $table = 'peran';

    protected $primaryKey = 'id';

    public $timestamps = false;

    public function pengguna()
    {
        return $this->hasMany(Pengguna::class, 'peran_id');
    }
}