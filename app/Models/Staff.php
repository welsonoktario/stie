<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'nip';

    public $incrementing = false;

    protected $keyType = 'string';
    
    protected $fillable = [
        'nip',
        'divisi',
        'level_pengguna',
        'user_id',
        'jenjang_pendidikan',
        'gelar_depan',
        'gelar_belakang',
        'status_karyawan',
    ];

    public function user(){
        return belongsTo(User::ckass);
    }
}
