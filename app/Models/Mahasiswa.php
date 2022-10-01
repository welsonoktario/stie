<?php

namespace App\Models;

use App\Models\User;
use App\Models\Dosen;
use App\Models\Jurusan;
use App\Models\TahunAjaran;
use App\Models\MahasiswaKonversi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;

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
        'tanggal_masuk',
        'tanggal_selesai',

        'asal_slta',
        'tahun_lulus_slta',
        'daerah_asal'
    ];

    //protected $appends = ['ipk'];

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
                "jumlah_cicilan_dpp",
                "tanggal_cicilan_dpp",
                "keterangan_cicilan_dpp",
                "jumlah_cicilan_praktikum",
                "tanggal_cicilan_praktikum",
                "keterangan_cicilan_praktikum",
                "jumlah_cicilan_almamater",
                "tanggal_cicilan_almamater",
                "keterangan_cicilan_almamater",
                "jumlah_cicilan_biaya_konversi",
                "tanggal_cicilan_biaya_konversi",
                "keterangan_cicilan_biaya_konversi",
            );
    }

    public function jadwals()
    {
        return $this->belongsToMany(Jadwal::class, 'jadwal_mahasiswa', 'mahasiswa_npm', 'jadwal_id', 'npm', 'id')
            ->withPivot(['nilai_uts', 'nilai_nas', 'nilai_akhir', 'nisbi', 'angka_mutu']);
    }

    public function hitungIPKonversi(){

        $totalNilaiKaliSksKonversi = 0;
        $totalSksKonversi = 0;
        $mahasiswa_konversi = $this->mahasiswa_konversi;
        if ($mahasiswa_konversi) {
            // dd($mkk);
            $matakuliah_konversis = $mahasiswa_konversi->matakuliah_konversis;

            // HITUNG TOTAL SKS DAN SKS*BOBOT
            foreach ($matakuliah_konversis as $mkk) {
                $totalNilaiKaliSksKonversi += $mkk->nilai_matakuliah * $mkk->matakuliah->sks;
                $totalSksKonversi += $mkk->matakuliah->sks;
            }
            $totalSksKonversi;
            $totalNilaiKaliSksKonversi;
            // dd($mkk);
        }
    }

    public function hitungSksYAD($ips_sebelumnya) {
        $sks = 24;

        if ($ips_sebelumnya >= 3.00) {
            $sks = 24;
        } else if ($ips_sebelumnya >= 2.50 && $ips_sebelumnya < 3.00) {
            $sks = 21;
        } else if ($ips_sebelumnya >= 2.00 && $ips_sebelumnya < 2.50) {
            $sks = 18;
        } else if ($ips_sebelumnya >= 1.50 && $ips_sebelumnya < 2.00) {
            $sks = 15;
        } else if ($ips_sebelumnya < 1.50){
            $sks = 12;
        } else if ($ips_sebelumnya == "Baru") {
            dd('disini');
        }

        return $sks;

    }

    public function hitungIP($tas = [], $hitungIpAwalKonversi = false) {

        // ambil tahun ajaran yang dipilih
        if (count($tas) > 0) {
            $jadwals = $this->jadwals()->whereIn('tahun_ajaran_id', $tas)->get();
        }
        else {
            $jadwals = $this->jadwals;
        }

        $totalNilaiKaliSks = 0;
        $totalSks = 0;
        $totalSksTidakLulus = 0;
        // dd($this, $jadwals, $tas);
        foreach ($jadwals as $jadwal) {
            if ((count($tas) === 1) && $jadwal->pivot->angka_mutu === null) {
                return 0;
            }

            // cek nilai tidak lulus
            if($jadwal->pivot->angka_mutu === 0) {
                $totalSksTidakLulus += $jadwal->matakuliah->sks;
            }

            $totalNilaiKaliSks += $jadwal->pivot->angka_mutu * $jadwal->matakuliah->sks;
            $totalSks += $jadwal->matakuliah->sks;
        }
        // dd($totalSks);

        // Hitung IP dengan matakuliah konversi
        $totalNilaiKaliSksKonversi = 0;
        $totalSksKonversi = 0;
        $mahasiswa_konversi = $this->mahasiswa_konversi;
        if ($mahasiswa_konversi && (count($tas) != 1 || $hitungIpAwalKonversi)) {
            $matakuliah_konversis = $mahasiswa_konversi->matakuliah_konversis;

            // HITUNG TOTAL SKS DAN SKS*BOBOT
            foreach ($matakuliah_konversis as $mkk) {
                $totalNilaiKaliSksKonversi += $mkk->nilai_matakuliah * $mkk->matakuliah->sks;
                $totalSksKonversi += $mkk->matakuliah->sks;
            }
            $totalSks += $totalSksKonversi;
            $totalNilaiKaliSks += $totalNilaiKaliSksKonversi;
        }

        if ($totalSks == 0) {
            return 0;
        } else {
            // jika tas hanya 1, maka hitung IPS dengan dibagi dengan total sks
            if (count($tas) == 1) {
                // return $totalNilaiKaliSks / ($totalSks - $totalSksTidakLulus);
                return $totalNilaiKaliSks / $totalSks;
            }
            // jika tas lebih dari 1, hitung dengan total sks - total sks tidak lulus
            else {
                return $totalNilaiKaliSks / ($totalSks - $totalSksTidakLulus);
            }
        }
        return $this->jadwals;
    }

    // public function hitungIP($ta) {
    //     return 0;
    // }

    public function scopeIndexJadwal($query)
    {
        $query->select(['mahasiswas.*', 'jadwal_mahasiswa.*', 'jadwal_mahasiswa.angka_mutu as nilai', 'jadwal_mahasiswa.nilai_akhir as nilai_akhir', 'users.name as nama', 'jurusans.nama as jurusan', 'status_cicilan.jumlah_cicilan_1 as krs'])
            ->join('users', 'users.id', '=', 'mahasiswas.user_id')
            ->leftJoin('jurusans', 'jurusans.id', '=', 'mahasiswas.jurusan_id')
            ->leftJoin('status_cicilan', 'status_cicilan.mahasiswa_npm', '=', 'mahasiswas.npm')
            ->join('jadwal_mahasiswa', 'jadwal_mahasiswa.mahasiswa_npm', '=', 'mahasiswas.npm');
            // ->where('jadwal_mahasiswa.jadwal_id')
            // ->leftJoin('jadwal_mahasiswa', 'jadwal_mahasiswa.mahasiswa_npm', '=', 'mahasiswas.npm');
    }

    public function scopeIndexUjian(Builder $query, $tipe)
    {
        $query->select([
                'mahasiswas.npm as npm',
                'users.name as nama',
                'jurusans.nama as jurusan',
                $tipe == 'UTS'
                    ? 'status_cicilan.jumlah_cicilan_1 as cicilan'
                    : 'status_cicilan.jumlah_cicilan_2 as cicilan'
            ])
            ->join('users', 'users.id', '=', 'mahasiswas.user_id')
            // ->join('jadwal_mahasiswa', 'jadwal_mahasiswa.mahasiswa_npm', '=', 'mahasiswas.npm')
            // ->join('jadwals', 'jadwals.id', '=', 'jadwal_mahasiswa.jadwal_id')
            // ->join('matakuliahs', 'matakuliahs.id', '=', 'jadwals.matakuliah_id')
            // ->join('tahun_ajarans', 'tahun_ajarans.id', '=', 'jadwals.tahun_ajaran_id')
            ->leftJoin('jurusans', 'jurusans.id', '=', 'mahasiswas.jurusan_id')
            ->leftJoin('status_cicilan', 'status_cicilan.mahasiswa_npm', '=', 'mahasiswas.npm');
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['query'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('npm', 'LIKE', "%$search%")
                    ->orWhere('users.name', 'LIKE', "%$search%")
                    ->orWhere('jurusans.nama', 'LIKE', "%$search%")
                    ->orWhere('tanggal_masuk', 'LIKE', "%$search%");
            });
        })->when($filters['orderBy'] ?? null, function ($query, $orderBy) use (&$filters) {
            $query->orderBy($orderBy, $filters['orderType']);
        });
    }

    public function getIpkAllAttribute()
    {
        $jadwals = $this->jadwals()
            ->with(['matakuliah' => fn ($q) => $q->groupBy('id')])
            ->get();

        return $jadwals;


    }

    public function hitungIPKSebelum() {
        // return 'wow';
    }
}
