<?php

namespace App\Models;

use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\MatakuliahJurusan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Jurusan extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'kode_jurusan',
        'nama',
    ];

    public function dosens()
    {
        return $this->hasMany(Dosen::class);
    }

    public function mahasiswas()
    {
        return $this->hasMany(Mahasiswa::class);
    }

    public function matakuliah_jurusans()
    {
        return $this->hasMany(MatakuliahJurusan::class);
    }

    public function scopeFilter($query, array $filters) {
        $query->when($filters['query'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('kode_jurusan', 'LIKE', "%$search%")
                    ->orWhere('nama', 'LIKE', "%$search%");
            });
        })->when($filters['orderBy'] ?? null, function ($query, $orderBy) use (&$filters) {
            $query->orderBy($orderBy, $filters['orderType']);
        });
    }
}
