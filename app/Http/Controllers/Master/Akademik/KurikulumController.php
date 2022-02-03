<?php

namespace App\Http\Controllers\Master\Akademik;

use App\Http\Controllers\Controller;
use App\Models\Kurikulum;
use Illuminate\Http\Request;
use Inertia\Inertia;

class KurikulumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // dd('yu');

        $kurikulums = Kurikulum::all();

        return Inertia::render('Master/Akademik/AkademikKurikulum.vue',[
            'kurikulums' => $kurikulums,
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
        return Inertia::render('Master/Akademik/AkademikKurikulumDetail.vue');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $nama = $request->nama;
        $aktif = $request->status;

        $kurikulum = new Kurikulum();

        $kurikulum->nama = $nama;
        $kurikulum->aktif = $aktif;

        $kurikulum->save();

        return redirect('master/kurikulum');
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
        
        $kurikulum = Kurikulum::findOrFail($id);

        return Inertia::render('Master/Akademik/AkademikKurikulumDetail.vue',[
            'kurikulum' => $kurikulum,
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
        $nama = $request->nama;
        $aktif = $request->status;

        $kurikulum = Kurikulum::findOrFail($id);

        $kurikulum->nama = $nama;
        $kurikulum->aktif = $aktif;

        $kurikulum->save();

        return redirect('master/kurikulum');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $kurikulum = Kurikulum::findOrFail($id);
        $kurikulum->delete();

        return redirect('master/kurikulum');
    }
}
