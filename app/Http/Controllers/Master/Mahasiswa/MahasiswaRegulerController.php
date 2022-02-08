<?php

namespace App\Http\Controllers\Master\Mahasiswa;

use Inertia\Inertia;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\Jurusan;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class MahasiswaRegulerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $mahasiswas = Mahasiswa::doesntHave('mahasiswa_konversi')->with(['user','jurusan'])->get();
        // dd($mahasiswas);
        return Inertia::render('Master/Mahasiswa/Reguler/MahasiswaReguler',[
            'mahasiswas' => $mahasiswas,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $dosens = Dosen::with('staff.user')->get();
        $jurusans = Jurusan::all();
        return Inertia::render('Master/Mahasiswa/Reguler/MahasiswaRegulerDetail',[
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
        //
        // user data
        $name = $request->name;
        $email = $request->email;
        $nik = $request->nik;

        // mahasiswa data
        $npm = $request->npm;
        $dosen_id = $request->dosen;
        $jurusan_id = $request->jurusan;

        // Save user
        $user = new User();
        $user->name = $name;
        $user->email = $email;
        $user->nik = $nik;
        $user->password = Hash::make('12345678');
        $user->save();

        // save mahasiswa
        $mahasiswa = new Mahasiswa();
        $mahasiswa->npm = $npm;
        $mahasiswa->dosen_id = $dosen_id;
        $mahasiswa->jurusan_id = $jurusan_id;
        $mahasiswa->user_id = $user->id;
        $mahasiswa->save();

        // dd($name, $email, $npm, $dosen_id, $jurusan_id);
        return redirect('master/mahasiswa-reguler');
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
        $mahasiswa = Mahasiswa::where('npm','=',$id)->with(['dosen','jurusan','user'])->first();
        $dosens = Dosen::with('staff.user')->get();
        $jurusans = Jurusan::all();
        // dd($mahasiswa);
        return Inertia::render('Master/Mahasiswa/Reguler/MahasiswaRegulerDetail',[
            'dosens' => $dosens,
            'jurusans' => $jurusans,
            'mahasiswa' => $mahasiswa,
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
        // user data
        $name = $request->name;
        $email = $request->email;
        $nik = $request->nik;

        // mahasiswa data
        $dosen_id = $request->dosen;
        $jurusan_id = $request->jurusan;

        $mahasiswa = Mahasiswa::where('npm','=',$id)->first();
        // Save user
        $user = $mahasiswa->user;
        $user->name = $name;
        $user->nik = $nik;
        $user->email = $email;
        $user->password = Hash::make('gatumgatum');
        $user->save();

        // save mahasiswa
        $mahasiswa->dosen_id = $dosen_id;
        $mahasiswa->jurusan_id = $jurusan_id;
        $mahasiswa->save();


        // dd($name, $email, $npm, $dosen_id, $jurusan_id);
        return redirect('master/mahasiswa-reguler');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $mahasiswa = Mahasiswa::where('npm','=',$id)->first();

        $mahasiswa->delete();

        // dd($name, $email, $npm, $dosen_id, $jurusan_id);
        return redirect('master/mahasiswa-reguler');
    }
}
