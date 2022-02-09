<?php

namespace App\Http\Controllers\Master\Mahasiswa;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Dosen;
use App\Models\Jurusan;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use App\Models\MahasiswaKonversi;
use App\Models\MatakuliahKonversi;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class MahasiswaKonversiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // dd($request->mahasiswa_konversi_id);
        //
        $mahasiswas = Mahasiswa::has('mahasiswa_konversi')->with(['user','jurusan','dosen'])->get();
        return Inertia::render('Master/Mahasiswa/Konversi/MahasiswaKonversi',[
            'mahasiswas' => $mahasiswas
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $dosens = Dosen::with('staff.user')->get();
        $jurusans = Jurusan::all();
        return Inertia::render('Master/Mahasiswa/Konversi/MahasiswaKonversiDetail',[
            'dosens' => $dosens,
            'jurusans' => $jurusans,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd('disini');
        $this->saveMahasiswaKonversiHandler($request);

        return redirect('master/mahasiswa-konversi');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $mahasiswa = Mahasiswa::has('mahasiswa_konversi')
        ->where('npm','=',$id)
        ->with(['user','dosen','jurusan','mahasiswa_konversi.matakuliah_konversis.matakuliah'])
        ->get()->first();

        $matakuliahs = $mahasiswa->mahasiswa_konversi->matakuliah_konversis;
        // dd($matakuliahs[0]->kode_matakuliah);    
        $dosens = Dosen::with('staff.user')->get();
        $jurusans = Jurusan::all();
        return Inertia::render('Master/Mahasiswa/Konversi/MahasiswaKonversiDetail',[
            'dosens' => $dosens,
            'jurusans' => $jurusans,
            'mahasiswa' => $mahasiswa,
            'matakuliahs' => $matakuliahs,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->saveMahasiswaKonversiHandler($request,'update', $id);

        return redirect('master/mahasiswa-konversi');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $mahasiswa = Mahasiswa::where('npm','=',$id)->first();

        $mahasiswa->mahasiswa_konversi->delete();
        $mahasiswa->delete();
        $mahasiswa->user->delete();

        return redirect(route('master.mahasiswa-konversi.index'));
    }

    public function saveMahasiswaKonversiHandler(Request $request, $mode = 'store', $id=null){

        // user data
        $name = $request->name;
        $email = $request->email;
        $nik = $request->nik;

        // mahasiswa data
        $npm = $request->npm;
        $dosen_id = $request->dosen != '-' ? $request->dosen : null;
        $jurusan_id = $request->jurusan != '-' ? $request->jurusan : null;

        if ($mode == 'store'){
            $mahasiswa = new Mahasiswa();
            $user = new User();
            $mahasiswaKonversi = new MahasiswaKonversi();

            // foreign key
            $user->nik = $nik;
            $mahasiswa->npm = $npm;
        }
        else if ($mode == 'update'){
            $mahasiswa = Mahasiswa::where('npm','=',$id)->first();
            $user = $mahasiswa->user;
            $mahasiswaKonversi = $mahasiswa->mahasiswa_konversi;
        }

        // Save user
        $user->name = $name;
        $user->email = $email;
        $user->password = Hash::make('12345678');
        $user->save();

        // save mahasiswa
        $mahasiswa->dosen_id = $dosen_id;
        $mahasiswa->jurusan_id = $jurusan_id;
        $mahasiswa->user_id = $user->id;
        $mahasiswa->save();

        // save mahasiswa konversi
        $mahasiswaKonversi->mahasiswa_npm = $mahasiswa->npm;
        $mahasiswaKonversi->save();
    }
}
