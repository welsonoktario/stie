<?php

namespace App\Models;

use App\Models\Jadwal;
use Illuminate\Database\Eloquent\Model;

class TahunAjaran extends Model
{
    protected $fillable = [
        'id',
        'tahun_ajaran',
        'tahun_mulai',
        'tahun_selesai',
        'periode'
    ];

    protected $casts = [
        'tahun_mulai' => 'integer',
        'tahun_selesai' => 'integer',
        'periode' => 'integer',
    ];

    public function jadwals()
    {
        return $this->hasMany(Jadwal::class);
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['query'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('tahun_ajaran', 'LIKE', "%$search%");
            });
        })->when($filters['orderBy'] ?? null, function ($query, $orderBy) use (&$filters) {
            $query->orderBy($orderBy, $filters['orderType']);
        });
    }
}
