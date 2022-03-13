<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class TestingController extends Controller
{
    //
    public function index(){

        $mhs = Mahasiswa::first();
        // $ta = TahunAjaran::all();

        // ubah status
        // $stat = $mhs->tahun_ajaran[0]->pivot->status = 'Tidak Aktif';
        // $stat = $mhs->tahun_ajaran[0]->pivot->save();
        // $stat = $mhs->tahun_ajaran;
        // dd($stat);
        // tambah TA saat tambah mhs
        
        // $smt = 
        $tm = $mhs->tanggal_masuk;
        // $ta = TahunAjaran::where('tanggal_mulai', '>=', $tm)->get();
        $tas = TahunAjaran::where('tanggal_selesai', '>', $tm)->get();
        $mhs->tahun_ajaran()->detach();
        foreach ($tas as $ta) {
            $mhs->tahun_ajaran()->attach($ta->id, ['status' => 'Aktif']);
        }
        // dd($tas);
        dd($mhs->tahun_ajaran);
        // echo "tes";
    }
}
