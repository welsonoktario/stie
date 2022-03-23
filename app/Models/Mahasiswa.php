<?php

namespace App\Models;

use App\Models\User;
use App\Models\Dosen;
use App\Models\Jurusan;
use App\Models\TahunAjaran;
use App\Models\MahasiswaKonversi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $primaryKey = 'npm';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $table = 'mahasiswas';

    protected $fillable = [
        'npm',
        'user_id',
        'dosen_id',
        'jurusan_id',
        'jenis_tinggal',
        'alat_transportasi',
        'nisn',
        'npwp',
        'kps',
        'nik_ayah',
        'nama_ayah',
        'tempat_lahir_ayah',
        'tanggal_lahir_ayah',
        'pendidikan_ayah',
        'pekerjaan_ayah',
        'penghasilan_ayah',
        'nik_ibu',
        'nama_ibu',
        'tempat_lahir_ibu',
        'tanggal_lahir_ibu',
        'pendidikan_ibu',
        'pekerjaan_ibu',
        'penghasilan_ibu',
        'uang_semester',
        'status_mahasiswa',
        'tanggal_masuk'
    ];

    public function getRouteKeyName()
    {
        return 'npm';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function mahasiswa_konversi()
    {
        return $this->hasOne(MahasiswaKonversi::class);
    }

    /**
     * Jurusan yang diambil
     */
    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }

    /**
     * Dosen Wali
     */
    public function dosen()
    {
        return $this->belongsTo(Dosen::class);
    }

    /**
     * Status Cicilan per semester
     * status_cicilan
     */
    public function status_mahasiswa()
    {
        return $this->belongsToMany(TahunAjaran::class, 'status_mahasiswa', 'mahasiswa_npm', 'tahun_ajaran')
            ->withPivot('jumlah_cicilan_1', 'tanggal_cicilan_1', 'keterangan_ciilan_1', 'jumlah_cicilan_2', 'tanggal_cicilan_2', 'keterangan_ciilan_2', 'jumlah_cicilan_3', 'tanggal_cicilan_3', 'keterangan_ciilan_3', 'total_cicilan', 'uang_semester');
    }

    /**
     * Status Mahasiswa per semester
     * status_mahasiswa
     */
    public function tahun_ajaran()
    {
        return $this->belongsToMany(TahunAjaran::class, 'status_mahasiswa', 'mahasiswa_npm', 'tahun_ajaran')
            ->withPivot(
                "jumlah_cicilan_1",
                "tanggal_cicilan_1",
                "keterangan_ciilan_1",
                "jumlah_cicilan_2",
                "tanggal_cicilan_2",
                "keterangan_ciilan_2",
                "jumlah_cicilan_3",
                "tanggal_cicilan_3",
                "keterangan_ciilan_3",
                "total_cicilan",
                "uang_semester",
                "status",
            );
    }

    public function jadwals()
    {
        return $this->belongsToMany(Jadwal::class, 'jadwal_mahasiswa', 'mahasiswa_npm', 'jadwal_id', 'npm', 'id')
            ->withPivot(['nilai_uts', 'nilai_nas', 'nilai_akhir', 'nisbi']);
    }

    public function scopeIndexJadwal($query)
    {
        $query->select(['mahasiswas.*', 'users.name as nama', 'jurusans.nama as jurusan', 'status_cicilan.jumlah_cicilan_1 as krs'])
            ->join('users', 'users.id', '=', 'mahasiswas.user_id')
            ->leftJoin('jurusans', 'jurusans.id', '=', 'mahasiswas.jurusan_id')
            ->leftJoin('status_cicilan', 'status_cicilan.mahasiswa_npm', '=', 'mahasiswas.npm');
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['query'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('npm', 'LIKE', "%$search%")
                    ->orWhere('nama', 'LIKE', "%$search%")
                    ->orWhere('jurusan', 'LIKE', "%$search%");
            });
        })->when($filters['orderBy'] ?? null, function ($query, $orderBy) use (&$filters) {
            $query->orderBy($orderBy, $filters['orderType']);
        });
    }
}
