<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MahasiswaKonversi extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'mahasiswa_npm ',
        'npm_asal',
        'perguruan_tinggi_asal',
        'jurusan_asal',
        'jenjang_pendidikan',
    ];
}
