<?php

namespace App\Models;

use App\Models\Dosen;
use App\Models\TenagaKependidikan;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    public $incrementing = false;

    protected $table = 'staffs';

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
        'nomor_sk_awal',
        'tanggal_sk_awal',
        'nomor_sk_akhir',
        'tanggal_sk_akhir',
        'golongan',
        'status_berdasarkan_fungsi'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dosen()
    {
        return $this->hasOne(Dosen::class, 'staff_id', 'id');
    }

    public function jabatan_struktural()
    {
        return $this->hasOne(JabatanStruktural::class, 'staff_id', 'id');
    }

    public function tenaga_kependidikan()
    {
        return $this->hasOne(TenagaKependidikan::class, 'staff_id', 'id');
    }

    public function scopeIndex($query)
    {
        $query->select(['staffs.*', 'users.name as user_name'])
            ->join('users', 'users.id', '=', 'staffs.user_id');
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
