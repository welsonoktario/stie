<?php

namespace App\Models;

use App\Models\Jadwal;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ruangan extends Model
{
    use HasFactory;

    protected $table = 'ruangans';

    protected $fillable = [
        'id',
        'nama_ruangan',
    ];

    public function jadwals() {
        return $this->hasMany(Jadwal::class);
    }

}
