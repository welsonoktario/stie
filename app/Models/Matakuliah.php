<?php

namespace App\Models;

use App\Models\Jadwal;
use App\Models\Kurikulum;
use App\Models\MatakuliahJurusan;
use App\Models\MatakuliahKonversi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Matakuliah extends Model
{
    use HasFactory;

    protected $table = 'matakuliahs';

    protected $fillable = [
        'id',
        'kurikulum_id',
        'kode_matakuliah',
        'nama_matakuliah',
        'sks',
        'tipe',
    ];

    protected $casts = ['sks' => 'integer'];

    public function kurikulum(){
        return $this->belongsTo(Kurikulum::class);
    }

    /**
     * Inheritance to matakuliah_jurusan (matakuliah's origin)
     */
    public function matakuliah_jurusan(){
        return $this->hasOne(MatakuliahJurusan::class);
    }

    /**
     * Matakuliah's prasyarat
     */
    public function prasyarats(){
        return $this->belongsToMany($this, 'prasyarat', 'matakuliah_id', 'prasyarat_id');
    }

    /**
     * Matakuliah is in many Jadwal in certain semester
     */
    public function jadwals(){
        return $this->hasMany(Jadwal::class);
    }

    /**
     * Matakuliah has only one matakuliah konversi to be compared
     */
    public function matakuliah_konversi(){
        return $this->hasOne(MatakuliahKonversi::class);
    }

}
