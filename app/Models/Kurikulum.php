<?php

namespace App\Models;

use App\Models\Jurusan;
use App\Models\Matakuliah;
use App\Models\MatakuliahJurusan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kurikulum extends Model
{
    use HasFactory;

    protected $table = 'kurikulums';

    protected $fillable = [
        'id',
        'nama',
        'aktif',
    ];

    protected $casts = [
        'aktif' => 'boolean'
    ];

    public function matakuliahs()
    {
        return $this->hasMany(Matakuliah::class);
    }

    public function matakuliah_jurusan()
    {
        return $this->hasOne(MatakuliahJurusan::class);
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['query'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('nama', 'LIKE', "%$search%");
            });
        })->when($filters['orderBy'] ?? null, function ($query, $orderBy) use (&$filters) {
            $query->orderBy($orderBy, $filters['orderType']);
        });
    }
}
