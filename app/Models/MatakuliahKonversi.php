<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatakuliahKonversi extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'kurikulum_id',
        'kode_matakuliah',
        'nama_matakuliah',
        'sks',
        'tipe',
    ];
}
