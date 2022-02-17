<?php

namespace App\Models;

use App\Models\Matakuliah;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MatakuliahKonversi extends Model
{
    use HasFactory;

    protected $table = 'matakuliah_konversis';

    protected $fillable = [
        'id',
        'kode_matakuliah',
        'nama_matakuliah',
        'sks_matakuliah',
        'nilai_matakuliah',
        'mahasiswa_konversi_id',
        'matakuliah_id',
    ];

    /**
     * Compare past matakuliah with one new matakuliah
     */
    public function matakuliah(){
        return $this->belongsTo(Matakuliah::class);
    }

    /**
     * Matakuliah konversi taken by mahasiswa konversi
     */
    public function mahasiswa_konversi(){
        return $this->belongsTo(MatakuliahKonversi::class);
    }

}
