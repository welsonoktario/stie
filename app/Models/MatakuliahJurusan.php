<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatakuliahJurusan extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'matakuliah_id',
        'jurusan_id'
    ];
}
