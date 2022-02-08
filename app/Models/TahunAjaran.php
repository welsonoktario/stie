<?php

namespace App\Models;

use App\Models\Jadwal;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TahunAjaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'tahun_ajaran',
        'status',
    ];

    protected $table = 'tahun_ajarans';

    public function jadwals(){
        return $this->hasMany(Jadwal::class);
    }
}
