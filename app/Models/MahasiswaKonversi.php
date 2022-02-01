<?php

namespace App\Models;

use App\Models\Mahasiswa;
use App\Models\MatakuliahKonversi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MahasiswaKonversi extends Model
{
    use HasFactory;

    protected $table = 'mahasiswa_konversis';

    protected $fillable = [
        'id',
        'mahasiswa_npm ',
        'npm_asal',
        'perguruan_tinggi_asal',
        'jurusan_asal',
        'jenjang_pendidikan',
    ];

    public function mahasiswa(){
        return $this->belongsTo(Mahasiswa::class);
    }

    public function matakuliah_konversis(){
        return $this->hasMany(MatakuliahKonversi::class);
    }
}
