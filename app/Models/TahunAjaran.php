<?php

namespace App\Models;

use App\Models\User;
use App\Models\Jadwal;
use Illuminate\Database\Eloquent\Model;

class TahunAjaran extends Model
{
    protected $fillable = [
        'id',
        'tahun_ajaran',
        // 'tahun_mulai',
        // 'tahun_selesai',
        'tanggal_mulai',
        'tanggal_selesai',
        'periode',
        'aktif'
    ];

    protected $casts = [
        // 'tahun_mulai' => 'integer',
        // 'tahun_selesai' => 'integer',
        // 'tanggal_mulai' => 'date',
        // 'tanggal_selesai' => 'date',
        'periode' => 'integer',
        'aktif' => 'boolean'
    ];

    public function jadwals()
    {
        return $this->hasMany(Jadwal::class);
    }

    /**
     * Status cicilan
     */
    // public function status_cicilan(){
    //     return $this->belongsToMany(User::class, 'status_cicilan','tahun_ajaran', 'mahasiswa_npm');
    // }
    /**
     * Status mahasiswa
     */
    public function mahasiswa(){
        return $this->belongsToMany(User::class, 'status_mahasiswa','tahun_ajaran', 'mahasiswa_npm');
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
