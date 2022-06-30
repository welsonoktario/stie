<?php

namespace App\Models;

use App\Models\Staff;
use App\Models\Jurusan;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    public $incrementing = false;

    protected $table = 'dosens';

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

    public function jadwals()
    {
        return $this->belongsToMany(Jadwal::class, 'jadwal_dosen');
    }


    public function scopeIndex($query)
    {
        $query->select(['dosens.*', 'users.name as user_name', 'jurusans.nama as jurusan_nama', 'staffs.status_karyawan as staff_status'])
            ->leftJoin('jurusans', 'jurusans.id', '=', 'dosens.jurusan_id')
            ->join('staffs', 'staffs.id', '=', 'dosens.staff_id')
            ->join('users', 'users.id', '=', 'staffs.user_id');
        // $query->select(['dosens.*'])
        //     ->join('jurusans','jurusan.id','=','dosens.jurusan_id');
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['query'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('users.name', 'LIKE', "%$search%");
            });
        })->when($filters['orderBy'] ?? null, function ($query, $orderBy) use (&$filters) {
            $query->orderBy($orderBy, $filters['orderType']);
        });
    }
}
