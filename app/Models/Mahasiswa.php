<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'npm';

    public $incrementing = false;

    protected $keyType = 'string';
    

    protected $fillable = [
        'npm',
        'user_id',
        'dosen_nid',
        'jurusan_id',
        'jenis_tinggal',
        'alat_transportasi',
        'nisn',
        'npwp',
        'nik_ayah',
        'nama_ayah',
        'tempat_lahir_ayah',
        'tanggal_lahir_ayah',
        'pendidikan_ayah',
        'pekerjaan_ayah',
        'penghasilan_ayah',
        'nik_ibu',
        'nama_ibu',
        'tempat_lahir_ibu',
        'tanggal_lahir_ibu',
        'pendidikan_ibu',
        'pekerjaan_ibu',
        'penghasilan_ibu',
        'uang_semester',
        'status_mahasiswa',
    ];
}
