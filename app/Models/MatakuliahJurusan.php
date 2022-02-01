<?php

namespace App\Models;

use App\Models\Jurusan;
use App\Models\Matakuliah;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MatakuliahJurusan extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'matakuliah_id',
        'jurusan_id'
    ];

    protected $table = 'matakuliah_jurusans';

    public function jurusan(){
        return $this->belongsTo(Jurusan::class);
    }

    public function matakuliah(){
        return $this->belongsTo(Matakuliah::class);
    }
}
