<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Jadwal;
use App\Models\Jurusan;
use App\Models\Ruangan;
use App\Models\Kurikulum;
use App\Models\Matakuliah;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class ModelTestingController extends Controller
{
    //
    public function index(){

        // model mahasiswa
        $this->mahasiswaModel();

        // model mahasiswa konversi
        $this->mahasiswaKonversiModel();

        // model staff
        $this->staffModel();
        
        // model dosen
        $this->dosenModel();

        // jurusan
        $this->jurusanModel();

        // kurikulum
        $this->kurikulumModel();

        // matakuliah
        $this->matakuliahModel();

        // tahun_ajaran
        $this->tahunAjaranModel();

        // ruangan
        $this->ruanganModel();

        // jadwal
        $this->jadwalModel();

    }

    public function mahasiswaModel(){
        echo "<b>Mahasiswa</b><br>";
        // user -> mahasiswa
        $mahasiswas = User::has('mahasiswa')
            ->with('mahasiswa.jurusan')
            ->with('dosen') // gets dosen wali
            ->get();

        foreach ($mahasiswas as $mahasiswa) {
            echo 'Nama: '.$mahasiswa->name
            .', NPM: '.$mahasiswa->mahasiswa->npm
            .', Jurusan: '.$mahasiswa->mahasiswa->jurusan->nama
            .', Doswal: '.$mahasiswa->mahasiswa->dosen->staff->user->name
            .'<br>';
        }

        echo"<br>";
        
        // dd($mahasiswas,$mahasiswas[0]);

    }

    public function mahasiswaKonversiModel(){
        echo "<b>Mahasiswa Konversi</b><br>";
        
        $mahasiswa_konversis = User::has('mahasiswa_konversi')
            ->with('mahasiswa.mahasiswa_konversi.matakuliah_konversis')->get();
        // dd($mahasiswa_konversis);
        
        foreach ($mahasiswa_konversis as $mahasiswa) {
            echo 'Nama: '.$mahasiswa->name.
            ', NPM: '.$mahasiswa->mahasiswa->npm.
            ', PT Asal: '.$mahasiswa->mahasiswa_konversi->perguruan_tinggi_asal.'<br>';

            $matakuliah_konversis = $mahasiswa->mahasiswa->mahasiswa_konversi->matakuliah_konversis;
            if (count($matakuliah_konversis) > 0)
                echo 'Matakuliah Konversi:<br>';
                // dd($matakuliah_konversis);
                foreach ($matakuliah_konversis as $matakuliah_konversi) {
                    echo '- '.$matakuliah_konversi->nama_matakuliah
                    .' - '.$matakuliah_konversi->nilai_matakuliah
                    .' - '.$matakuliah_konversi->matakuliah->nama_matakuliah
                    .'<br>';
                }
        }
        
        echo"<br>";
    }

    public function staffModel(){
        
        echo "<b>Staff</b><br>";
        // user -> staff
        $staffs = User::has('staff')->with('staff')->get();

        foreach ($staffs as $staff) {
            echo 'Nama: '.$staff->name.', NIP: '.$staff->staff->nip.', Divisi: '.$staff->staff->divisi.' Level pengguna: '.$staff->staff->level_pengguna.'<br>';
        }

        echo"<br>";
    }

    public function dosenModel(){
        
        echo "<b>Dosen</b><br>";
        // user has one dosen trough staff 
        $dosens = User::has('dosen')
            ->with('staff.dosen.jurusan') // take dosen's jurusan
            ->with('dosen.mahasiswas')->get(); // take dosen's mahasiswa wali

        foreach ($dosens as $dosen) {
            echo 'Nama: '.$dosen->name
            .', NID: '.$dosen->dosen->nid
            .', Divisi: '.$dosen->staff->divisi
            .', Level pengguna: '.$dosen->staff->level_pengguna
            .', Jurusan: '.$dosen->staff->dosen->jurusan->nama.'<br>';
        }
        echo"<br>";

        // dd
        // dd($dosens);
    }
    
    public function jurusanModel(){
        
        echo "<b>Jurusan</b><br>";

        $jurusans = Jurusan::with('dosens.staff.user')->get();
        // jurusan
        // $dosens = User::has('dosen')->with('staff.dosen')->get();

        foreach ($jurusans as $jurusan) {
            echo 'Nama: '.$jurusan->nama.', Kode: '.$jurusan->kode_jurusan.'<br>';
            if (count($jurusan->dosens)>0) {
                echo 'pengajar:<br>';
                foreach ($jurusan->dosens as $pengajar) {
                    echo '- '.$pengajar->nid." ".$pengajar->staff->user->name."<br>";
                }
            }

        }
        echo"<br>";
        // dd($dosen);
    }

    public function kurikulumModel(){

        echo "<b>Kurikulum</b><br>";
        
        $kurikulums = Kurikulum::all();

        foreach ($kurikulums as $kurikulum) {
            echo 'Nama: '.$kurikulum->nama."<br>";
        }

        echo "<br>";
    }

    public function matakuliahModel() {
        
        echo "<b>Matakuliah</b><br>";
        
        $matakuliahs = Matakuliah::with('kurikulum')
        ->with('matakuliah_jurusan.jurusan')
        ->with('prasyarats')
        ->get();

        // dd($matakuliahs);
        foreach ($matakuliahs as $matakuliah) {
            echo 'Nama: '.$matakuliah->nama_matakuliah
            .', Kurikulum: '.$matakuliah->kurikulum->nama;
            
            if ($matakuliah->matakuliah_jurusan)
                echo ', Jurusan: '.$matakuliah->matakuliah_jurusan->jurusan->nama
                ."<br>";
            else
                echo ', Matakuliah Umum <br>';

            foreach ($matakuliah->prasyarats as $prasyarat) {
                // dd($prasyarat);
                echo 'prasyarat - '.$prasyarat->nama_matakuliah.'<br>';
                
            }
            echo "<br>";
        }
        echo "<br>";
    }

    public function tahunAjaranModel(){

        echo "<b>Tahun Ajaran</b><br>";
        
        $tahun_ajarans = TahunAjaran::all();

        foreach ($tahun_ajarans as $tahun_ajaran) {
            echo $tahun_ajaran->tahun_ajaran.'<br>';
        }
        
        echo "<br>";
    }

    public function ruanganModel(){

        echo "<b>Ruangan</b><br>";
        
        $ruangans = Ruangan::all();

        foreach ($ruangans as $ruangan) {
            echo 'Ruangan: '.$ruangan->nama_ruangan.'<br>';
        }
        
        echo "<br>";
    }

    public function jadwalModel(){
        
        echo "<b>Jadwal</b><br>";

        $jadwals = Jadwal::with('matakuliah')
        ->with('ruangan')
        ->with('tahun_ajaran')
        ->get();

        foreach ($jadwals as $jadwal) {
            echo 'Hari: '.$jadwal->hari
            .', Jam: '.$jadwal->jam
            .', Matakuliah: '.$jadwal->matakuliah->nama_matakuliah
            .', Ruangan: '.$jadwal->ruangan->nama_ruangan
            .', Tahun Ajaran: '.$jadwal->tahun_ajaran->tahun_ajaran
            .'<br>';
        }

        echo "<br>";
    }
}
