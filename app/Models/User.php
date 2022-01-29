<?php

namespace App\Models;

use App\Models\Staff;
use App\Models\Mahasiswa;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

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
    public function staff() {
        return $this->hasOne(Staff::class, 'user_id', 'id');
    }

    /**
     * Relation to Staff
     * return $this->hasOne(Staff::class, 'foreign_key', 'local_key')
     */
    public function mahasiswa() {
        return $this->hasOne(Mahasiswa::class, 'user_id', 'id');
    }
}
