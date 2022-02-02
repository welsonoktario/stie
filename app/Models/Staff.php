<?php

namespace App\Models;

use App\Models\Dosen;
use App\Models\TenagaKependidikan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Staff extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $table = 'staffs';
    
    protected $fillable = [
        'id',
        'divisi',
        'level_pengguna',
        'user_id',
        'jenjang_pendidikan',
        'gelar_depan',
        'gelar_belakang',
        'status_karyawan',
    ];

    public function user(){
        return $this->belongsTo(User::class);
        
    }
    
    public function dosen(){
        return $this->hasOne(Dosen::class, 'staff_id', 'id');
    }

    public function tenaga_kependidikan() {
        return $this->hasOne(TenagaKependidikan::class, 'staff_id', 'id');
    }
}
