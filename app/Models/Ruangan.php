<?php

namespace App\Models;

use App\Models\Jadwal;
use Illuminate\Database\Eloquent\Model;

class Ruangan extends Model
{
    protected $fillable = [
        'id',
        'nama_ruangan',
    ];

    public function jadwals()
    {
        return $this->hasMany(Jadwal::class);
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['query'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('nama_ruangan', 'LIKE', "%$search%");
            });
        })->when($filters['orderBy'] ?? null, function ($query, $orderBy) use (&$filters) {
            $query->orderBy($orderBy, $filters['orderType']);
        });
    }
}
