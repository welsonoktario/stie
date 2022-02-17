<?php

namespace App\Models;

use App\Models\Dosen;
use App\Models\Staff;
use App\Models\Mahasiswa;
use App\Models\MahasiswaKonversi;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'nik',
        'nama_panggilan',
        'jenis_kelamin',
        'agama',
        'nomor_hp',
        'tempat_lahir',
        'tanggal_lahir',
        'jalan',
        'kelurahan',
        'kecamatan',
        'kode_pos',
        'login',
        'status_aktif',
        'kewarganegaraan',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Relation to Staff
     * return $this->hasOne(Staff::class, 'foreign_key', 'local_key')
     */
    public function staff()
    {
        return $this->hasOne(Staff::class, 'user_id', 'id');
    }

    /**
     * Relation to Mahasiswa
     * return $this->hasOne(Magasiswa::class, 'foreign_key', 'local_key')
     */
    public function mahasiswa()
    {
        return $this->hasOne(Mahasiswa::class, 'user_id', 'id');
    }


    /**
     * Relation to Dosen (has one through staff)
     * return $this->hasOne(Magasiswa::class, 'foreign_key', 'local_key')
     */
    public function dosen()
    {
        return $this->hasOneThrough(Dosen::class, Staff::class);
    }

    public function mahasiswa_konversi()
    {
        return $this->hasOneThrough(MahasiswaKonversi::class, Mahasiswa::class);
    }
}
