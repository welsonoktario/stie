<?php

namespace App\Models;

use App\Models\Staff;
use App\Models\Jurusan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dosen extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'nid';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $table = 'dosens';
    
    protected $fillable = [
        'nid',
        'staff_nip',
        'jurusan_id',
        'jabatan_akademik',
        'tipe_dosen',
        'konsentrasi',
    ];
    

    public function staff(){
        return $this->belongsTo(Staff::class);
    }
    
    /**
     * Homebase/jurusan dosen
     */
    public function jurusan(){
        return $this->belongsTo(Jurusan::class);
    }

    public function mahasiswas() {
        return $this->hasMany(Mahasiswa::class);
    }
}
