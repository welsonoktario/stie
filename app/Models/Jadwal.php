<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'jam',
        'hari',
        'matakuliah_id',
        'ruangan_id',
        'tahun_ajaran_id',
    ];
}
