<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Master\Mahasiswa\MahasiswaRegulerController;
use App\Models\Mahasiswa;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PDO;

class TestingController extends Controller
{
    //
    public function index(){

        /*
        Sudah di Seed:
        2020
        - Manajemen
        - Ekonomi Pembangunan
        */

        // $mhs = Mahasiswa::first();
        // // $ta = TahunAjaran::all();

        // // ubah status
        // // $stat = $mhs->tahun_ajaran[0]->pivot->status = 'Tidak Aktif';
        // // $stat = $mhs->tahun_ajaran[0]->pivot->save();
        // // $stat = $mhs->tahun_ajaran;
        // // dd($stat);
        // // tambah TA saat tambah mhs

        // // $smt =
        // $tm = $mhs->tanggal_masuk;
        // // $ta = TahunAjaran::where('tanggal_mulai', '>=', $tm)->get();
        // $tas = TahunAjaran::where('tanggal_selesai', '>', $tm)->get();
        // $mhs->tahun_ajaran()->detach();
        // foreach ($tas as $ta) {
        //     $mhs->tahun_ajaran()->attach($ta->id, ['status' => 'Aktif']);
        // }
        // // dd($tas);
        // dd($mhs->tahun_ajaran);
        // // echo "tes";

        $mhscon = new MahasiswaRegulerController();



        // $mhs = [
        //     'npm'=>'120120',
        //     'name'=>'Coba hack',
        //     'agama'=>'kristen',
        //     'tanggal_masuk' => '2017-07-10'
        // ];
        // $req = new Request();
        // $req->replace($mhs);
        // $mhscon->store($req);

        // $file =
        $row = 0;
        $header = array();
        $mahasiswas = array();
        $mahasiswa_req = new Request();

        if (($handle = fopen(Storage::path("mahasiswa_ep_2021_clean.csv"), "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $num = count($data);
            if ($row == 0) {
                // $header = collect($data)->map(function($d) {return});
                $header = $data;
                $row++;
                continue;
            }

            $mahasiswa = array_combine($header, $data);
            // if (($row) <= 160){
            //     // dd($mahasiswa);
            //     $row++;
            //     echo $mahasiswa['npm']." ".$mahasiswa['name']." - ".($row-1)."<br>";
            //     continue;
            // }
            $row++;

            if ($mahasiswa['jenis_kelamin'] == ""){
                unset($mahasiswa['jenis_kelamin']);
            }
            if (isset($mahasiswa['agama'])){
                if ($mahasiswa['agama'] == ""){
                    unset($mahasiswa['agama']);
                }
                // if($mahasiswa['agama'] == "Katholik"){
                //     $mahasiswa['agama'] = 'Katolik';
                // }
            }
            // else {
            //     unset($mahasiswa['agama']);
            // }


            $mahasiswa_req->replace($mahasiswa);
            // $mhscon->store($mahasiswa_req);
            // dd($mahasiswa);
            echo $mahasiswa['npm']." ".$mahasiswa['name']." ".($row-1)."<br>";

        }
        fclose($handle);
        }

    }
}
