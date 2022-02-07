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
        $jurusans = Jurusan::all();

        return Inertia::render(
            'Master/Akademik/Jurusan/AkademikJurusan',
            ['jurusans' => $jurusans]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Master/Akademik/Jurusan/AkademikJurusanDetail');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $kode_jurusan = $request->kode_jurusan;
        $nama = $request->nama;

        Jurusan::create(
            [
                'nama' => $nama,
                'kode_jurusan' => $kode_jurusan
            ]
        );

        return redirect()->route('master.jurusan.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $jurusan = Jurusan::find($id);

        return Inertia::render(
            'Master/Akademik/Jurusan/AkademikJurusanDetail',
            ['jurusan' => $jurusan]
        );
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
        $kode_jurusan = $request->kode_jurusan;
        $nama = $request->nama;

        $jurusan = Jurusan::find($id);
        $jurusan->update(
            [
                'nama' => $nama,
                'kode_jurusan' => $kode_jurusan
            ]
        );

        return redirect()->route('master.jurusan.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $jurusan = Jurusan::find($id);
        $jurusan->delete();

        return redirect()->route('master.jurusan.index');
    }
}
