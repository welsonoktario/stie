<?php

namespace App\Http\Controllers\Master\Akademik;

use Inertia\Inertia;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use CreateTahunAjaransTable;

class TahunAjaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $tahun_ajaran = TahunAjaran::all();
        return Inertia::render('Master/Akademik/AkademikTahunAjaran',[
            'tahun_ajarans' => $tahun_ajaran
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
        
        return Inertia::render('Master/Akademik/AkademikTahunAjaranDetail');
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
        $tahun = $request->tahun_ajaran;
        $status = $request->status;

        $tahun_ajaran = new TahunAjaran();
        $tahun_ajaran->tahun_ajaran = $tahun;
        
        $tahun_ajaran->status = $status;
        $tahun_ajaran->save();
        return redirect('master/tahun_ajaran');
        // dd($tahun, $status);
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
        
        $tahun_ajaran = TahunAjaran::findOrFail($id);

        return Inertia::render('Master/Akademik/AkademikTahunAjaranDetail',[
            'tahun_ajaran' => $tahun_ajaran,
        ]);
        // dd($tahun_ajaran);
        
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
        $tahun = $request->tahun_ajaran;
        $status = $request->status;

        $tahun_ajaran = TahunAjaran::findOrFail($id);
        $tahun_ajaran->tahun_ajaran = $tahun;
        
        // belum ada
        $tahun_ajaran->status = $status;
        $tahun_ajaran->save();
        return redirect('master/tahun_ajaran');
        // dd($tahun, $status);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tahun_ajaran = TahunAjaran::findOrFail($id);
        
        $tahun_ajaran->delete();
        return redirect('master/tahun_ajaran');
    }
}
