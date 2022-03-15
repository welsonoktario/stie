<?php

namespace App\Http\Controllers\Transaksi\Keuangan;

use Inertia\Inertia;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TahunAjaran;

class KeuanganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // dd($request['ta']);
        
        $tahun_ajarans = TahunAjaran::all();
        // $taa = TahunAjaran::find($request->ta);

        $ta = in_array($request->ta, [null, '']) 
            ? strval(($tahun_ajarans->firstWhere('aktif', '=', true))->id) : $request->ta;
        // dd($request->ta);
        $mahasiswas = Mahasiswa::select(['mahasiswas.npm',
                'mahasiswas.status_mahasiswa',
                'users.name as nama',
                'jurusans.nama as jurusan',
                'status_mahasiswa.status as status',
                'status_mahasiswa.jumlah_cicilan_1 as cicilan_1',
                'status_mahasiswa.jumlah_cicilan_2 as cicilan_1',
                'status_mahasiswa.jumlah_cicilan_3 as cicilan_1'])
            ->doesntHave('mahasiswa_konversi')
            ->join('users','users.id','=','mahasiswas.user_id')
            ->leftJoin('jurusans','jurusans.id','=','mahasiswas.jurusan_id')
            ->filter($request->only(['query', 'orderBy', 'orderType']))
            ->when($ta ?? null, function($query, $ta) {
                return $query->join('status_mahasiswa', 'mahasiswas.npm','=','mahasiswa_npm')
                    ->where('tahun_ajaran', '=', $ta);
            })
            ->paginate($request->get('perPage') ?: 10)
            ->withQueryString();
        // dd($taa->tahun_ajaran, $request->ta, $mahasiswas);

        return Inertia::render('Transaksi/Keuangan/Keuangan.vue',[
            'mahasiswas' => $mahasiswas,
            'tahun_ajarans' => $tahun_ajarans,
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
    }
}
