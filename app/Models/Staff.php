<?php

namespace App\Models;

use App\Models\Dosen;
use App\Models\TenagaKependidikan;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    public $incrementing = false;

    protected $keyType = 'string';

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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dosen()
    {
        return $this->hasOne(Dosen::class, 'staff_id', 'id');
    }

    public function tenaga_kependidikan()
    {
        return $this->hasOne(TenagaKependidikan::class, 'staff_id', 'id');
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
