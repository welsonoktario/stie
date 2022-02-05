<?php

namespace App\Http\Controllers\Master\Akademik;

use Inertia\Inertia;
use App\Models\Ruangan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RuanganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ruangans = Ruangan::all();

        return Inertia::render(
            'Master/Akademik/AkademikRuangan',
            ['ruangans' => $ruangans]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Master/Akademik/AkademikRuanganDetail');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $nama_ruangan = $request->nama_ruangan;

        Ruangan::create([
            'nama_ruangan' => $nama_ruangan
        ]);

        return redirect()->route('master.ruangan.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ruangan = Ruangan::findOrFail($id);

        return Inertia::render(
            'Master/Akademik/AkademikRuanganDetail',
            ['ruangan' => $ruangan]
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
        $nama_ruangan = $request->nama_ruangan;

        $ruangan = Ruangan::findOrFail($id);
        $ruangan::update([
            'nama_ruangan' => $nama_ruangan
        ]);

        return redirect()->route('master.ruangan.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ruangan = Ruangan::findOrFail($id);
        $ruangan->delete();

        return redirect()->route('master.ruangan.index');
    }
}
