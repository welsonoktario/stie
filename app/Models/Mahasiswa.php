<?php

namespace App\Models;

use App\Models\User;
use App\Models\Dosen;
use App\Models\Jurusan;
use App\Models\MahasiswaKonversi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mahasiswa extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'npm';

    public $incrementing = false;

    protected $keyType = 'string';
    
    protected $table = 'mahasiswas';

    protected $fillable = [
        'npm',
        'user_id',
        'dosen_id',
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

    public function getRouteKeyName()
    {
        return 'npm';
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function mahasiswa_konversi(){
        return $this->hasOne(MahasiswaKonversi::class);
    }

    /**
     * Jurusan yang diambil
     */
    public function jurusan(){
        return $this->belongsTo(Jurusan::class);
    }

    /**
     * Dosen Wali
     */
    public function dosen() {
        return $this->belongsTo(Dosen::class);
    }
}
