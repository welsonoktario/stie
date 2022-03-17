<?php

namespace App\Models;

use App\Models\Ruangan;
use App\Models\Matakuliah;
use App\Models\TahunAjaran;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Jadwal extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'jam',
        'hari',
        'matakuliah_id',
        'ruangan_id',
        'tahun_ajaran_id',
    ];

    /**
     * Every jadwal belongs to tahun ajaran
     */
    public function tahun_ajaran()
    {
        return $this->belongsTo(TahunAjaran::class);
    }

    /**
     * Every jadwal belongs to a matakuliah
     */
    public function matakuliah()
    {
        return $this->belongsTo(Matakuliah::class);
    }

    /**
     * Every jadwal belongs to a ruangan
     */
    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class);
    }

    public function mahasiswas()
    {
        return $this->belongsToMany(Mahasiswa::class, 'jadwal_mahasiswa', 'jadwal_id', 'mahasiswa_npm', 'id', 'npm')
            ->withPivot(['nilai_uts', 'nilai_nas', 'nilai_akhir', 'nisbi']);
    }

    public function scopeIndex($query)
    {
        $query->select([
            'jadwals.*',
            'matakuliahs.nama_matakuliah as matakuliah_nama',
            'matakuliahs.kode_matakuliah as matakuliah_kode',
            'ruangans.nama_ruangan as ruangan_nama'
        ])
            ->join('matakuliahs', 'matakuliahs.id', '=', 'jadwals.matakuliah_id')
            ->join('ruangans', 'ruangans.id', '=', 'jadwals.ruangan_id');
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
