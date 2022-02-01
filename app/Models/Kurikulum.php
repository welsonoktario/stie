<?php

namespace App\Models;

use App\Models\Jurusan;
use App\Models\Matakuliah;
use App\Models\MatakuliahJurusan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kurikulum extends Model
{
    use HasFactory;

    protected $table = 'kurikulums';

    protected $fillable = [
        'id',
        'nama',
        'aktif',
    ];

    public function matakuliahs(){
        return $this->hasMany(Matakuliah::class);
    }

    public function matakuliah_jurusan(){
        return $this->hasOne(MatakuliahJurusan::class);
    }
}
