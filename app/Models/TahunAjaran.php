<?php

namespace App\Models;

use App\Models\User;
use App\Models\Jadwal;
use App\Models\Mahasiswa;
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
        'id' => 'integer',
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
    public function mahasiswas()
    {
        return $this->belongsToMany(Mahasiswa::class, 'status_mahasiswa', 'tahun_ajaran', 'mahasiswa_npm')
            ->withPivot(
                'jumlah_cicilan_1',
                'tanggal_cicilan_1',
                'keterangan_ciilan_1',
                'jumlah_cicilan_2',
                'tanggal_cicilan_2',
                'keterangan_ciilan_2',
                'jumlah_cicilan_3',
                'tanggal_cicilan_3',
                'keterangan_ciilan_3',
                'total_cicilan',
                'uang_semester',
                'status',
            );
    }

    public function scopeFilter($query, array $filters)
    {
        $filters['orderBy'] = $filters['orderBy'] ?? 'tanggal_selesai';
        $filters['orderType'] = $filters['orderType'] ?? 'desc';
        $query->when($filters['query'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('tahun_ajaran', 'LIKE', "%$search%");
            });
        })->when($filters['orderBy'] ?? null, function ($query, $orderBy) use (&$filters) {
            $query->orderBy($orderBy, $filters['orderType']);
        });
        // ->when($filters['orderBy'] == null, function ($query) {
        //     $query->orderBy('tanggal_selesai','desc');
        // });
    }
}
