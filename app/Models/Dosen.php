<?php

namespace App\Models;

use App\Models\Staff;
use App\Models\Jurusan;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'staff_id',
        'jurusan_id',
        'jabatan_akademik',
        'tipe_dosen',
        'konsentrasi',
    ];


    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }

    /**
     * Homebase/jurusan dosen
     */
    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }

    public function mahasiswas()
    {
        return $this->hasMany(Mahasiswa::class);
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
