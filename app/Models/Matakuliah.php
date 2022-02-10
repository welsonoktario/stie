<?php

namespace App\Models;

use App\Models\Jadwal;
use App\Models\Kurikulum;
use App\Models\MatakuliahJurusan;
use App\Models\MatakuliahKonversi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Matakuliah extends Model
{
    use HasFactory;

    protected $table = 'matakuliahs';

    protected $fillable = [
        'id',
        'kurikulum_id',
        'kode_matakuliah',
        'nama_matakuliah',
        'sks',
        'tipe',
    ];

    protected $casts = ['sks' => 'integer'];

    public function kurikulum()
    {
        return $this->belongsTo(Kurikulum::class);
    }

    /**
     * Inheritance to matakuliah_jurusan (matakuliah's origin)
     */
    public function matakuliah_jurusan()
    {
        return $this->hasOne(MatakuliahJurusan::class);
    }

    /**
     * Matakuliah's prasyarat
     */
    public function prasyarats()
    {
        return $this->belongsToMany($this, 'prasyarat', 'matakuliah_id', 'prasyarat_id');
    }

    /**
     * Matakuliah is in many Jadwal in certain semester
     */
    public function jadwals()
    {
        return $this->hasMany(Jadwal::class);
    }

    /**
     * Matakuliah has only one matakuliah konversi to be compared
     */
    public function matakuliah_konversi()
    {
        return $this->hasOne(MatakuliahKonversi::class);
    }

    public function scopeIndex($query)
    {
        $query->select(['matakuliahs.*', 'kurikulums.nama as kurikulum_nama', 'jurusans.nama as jurusan_nama'])
            ->join('kurikulums', 'kurikulums.id', '=', 'matakuliahs.kurikulum_id')
            ->leftJoin('matakuliah_jurusans', 'matakuliah_jurusans.matakuliah_id', '=', 'matakuliahs.id')
            ->leftJoin('jurusans', 'jurusans.id', '=', 'matakuliah_jurusans.jurusan_id');
    }

    /**
     * Filter hasil pencarian berdasarkan $query dan $filters
     */
    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['query'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('kode_matakuliah', 'LIKE', "%$search%")
                    ->orWhere('nama_matakuliah', 'LIKE', "%$search%");
            });
        })->when($filters['orderBy'] ?? null, function ($query, $orderBy) use (&$filters) {
            $query->orderBy($orderBy, $filters['orderType']);
        });
    }
}
