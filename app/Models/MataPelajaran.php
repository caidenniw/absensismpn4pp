<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataPelajaran extends Model
{
    use HasFactory;

    protected $fillable = ['nama_pelajaran'];

    public function absensi()
    {
        return $this->hasMany(Absensi::class);
    }
}
