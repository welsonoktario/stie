<?php

namespace App\Http\Controllers\Master\Akademik;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use Inertia\Inertia;
use Illuminate\Http\Request;

class JurusanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $jurusans = Jurusan::all();
        return Inertia::render('Master/Akademik/AkademikJurusan', [
            'jurusans' => $jurusans,
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
        return Inertia::render('Master/Akademik/AkademikJurusanDetail');
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
        $kode_jurusan = $request->kode_jurusan;
        $nama = $request->nama;
        
        $jurusan = new Jurusan();
        $jurusan->nama = $nama;
        $jurusan->kode_jurusan = $kode_jurusan;
        $jurusan->save();

        return redirect('master/jurusan');

        // dd($request->kode_jurusan, $request->nama);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // dd($id);
        //
        $jurusan = Jurusan::where('id','=',$id)->get()->first();

        return Inertia::render('Master/Akademik/AkademikJurusanDetail',[
            'jurusan' => $jurusan,
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
        //
        $kode_jurusan = $request->kode_jurusan;
        $nama = $request->nama;
        
        $jurusan = Jurusan::where('id','=',$id)->get()->first();
        $jurusan->kode_jurusan = $kode_jurusan;
        $jurusan->nama = $nama;

        $jurusan->save();

        return redirect('master/jurusan');

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
        $jurusan = Jurusan::where('id','=',$id)->get()->first();

        $jurusan->delete();

        return redirect('master/jurusan');
    }
}
