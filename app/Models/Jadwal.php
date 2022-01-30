<?php

namespace App\Models;

use App\Models\Ruangan;
use App\Models\Matakuliah;
use App\Models\TahunAjaran;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    protected $table = 'jadwals';

    /**
     * Every jadwal belongs to tahun ajaran
     */
    public function tahun_ajaran(){
        return $this->belongsTo(TahunAjaran::class);
    }

    /**
     * Every jadwal belongs to a matakuliah
     */
    public function matakuliah(){
        return $this->belongsTo(Matakuliah::class);
    }

    /**
     * Every jadwal belongs to a ruangan
     */
    public function ruangan(){
        return $this->belongsTo(Ruangan::class);
    }


}
