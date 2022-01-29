<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'nid';

    public $incrementing = false;

    protected $keyType = 'string';
    

    protected $fillable = [
        'nid',
        'staff_nip',
        'jurusan_id',
        'jabatan_akademik',
        'tipe_dosen',
        'konsentrasi',
    ];
}
