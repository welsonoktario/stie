<?php

namespace App\Http\Controllers\Transaksi\Keuangan;

use Inertia\Inertia;
use App\Models\Mahasiswa;
use App\Models\TahunAjaran;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class KeuanganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $tahun_ajarans = TahunAjaran::all();
        $ta = in_array($request->ta, [null, ''])
            ? strval(($tahun_ajarans->firstWhere('aktif', '=', true))->id) : $request->ta;

        $mahasiswas = Mahasiswa::select(['mahasiswas.npm',
                'mahasiswas.status_mahasiswa',
                'users.name as nama',
                'jurusans.nama as jurusan',
                'status_mahasiswa.status as status',
                'status_mahasiswa.tanggal_cicilan_1 as cicilan_1',
                'status_mahasiswa.tanggal_cicilan_2 as cicilan_2',
                'status_mahasiswa.tanggal_cicilan_3 as cicilan_3'])
            // ->doesntHave('mahasiswa_konversi')
            ->join('users','users.id','=','mahasiswas.user_id')
            ->leftJoin('jurusans','jurusans.id','=','mahasiswas.jurusan_id')
            ->filter($request->only(['query', 'orderBy', 'orderType']))
            ->when($ta ?? null, function($query, $ta) {
                return $query->join('status_mahasiswa', 'mahasiswas.npm','=','mahasiswa_npm')
                    ->where('tahun_ajaran', '=', $ta);
            })
            ->paginate($request->get('perPage') ?: 10)
            ->withQueryString();

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
     * @param  int  $id = id mahasiswa atau npm
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        //
        if (!isset($request['ta']))
            return redirect()->route('transaksi.keuangan.index');

        // cari mahasiswa ada atau engga
        $taken = DB::table('status_mahasiswa')
            ->where('mahasiswa_npm','=', $id)
            ->where('tahun_ajaran', '=',$request['ta'])->get()->count();

        if (!($taken > 0)){
            return redirect()->route('transaksi.keuangan.index');
        }

        $mahasiswa = Mahasiswa::with(['user', 'tahun_ajaran'])
            ->find($id);

        // format tanggal
        // dd($mahasiswa->tahun_ajaran);
        foreach ($mahasiswa->tahun_ajaran as  $ta) {
            $ta->pivot['tanggal_cicilan_1'] = $this->formatToHtmlDate($ta->pivot['tanggal_cicilan_1']);
            $ta->pivot['tanggal_cicilan_2'] = $this->formatToHtmlDate($ta->pivot['tanggal_cicilan_2']);
            $ta->pivot['tanggal_cicilan_3'] = $this->formatToHtmlDate($ta->pivot['tanggal_cicilan_3']);
            $ta->pivot['tanggal_cicilan_dpp'] = $this->formatToHtmlDate($ta->pivot['tanggal_cicilan_dpp']);
            $ta->pivot['tanggal_cicilan_praktikum'] = $this->formatToHtmlDate($ta->pivot['tanggal_cicilan_praktikum']);
            $ta->pivot['tanggal_cicilan_almamater'] = $this->formatToHtmlDate($ta->pivot['tanggal_cicilan_almamater']);
            $ta->pivot['tanggal_cicilan_biaya_konversi'] = $this->formatToHtmlDate($ta->pivot['tanggal_cicilan_biaya_konversi']);
        }

        return Inertia::render('Transaksi/Keuangan/KeuanganDetail.vue',[
            'mahasiswa' => $mahasiswa,
        ]);


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
        $history = $request['detilHistory'];
        $npm = $id;
        $mahasiswa = Mahasiswa::find($npm);
        if (!$mahasiswa){
            dd("Error: Data mahasiswa tidak ditemukan");
        }

        $data = Arr::except($history['pivot'],
            ['mahasiswa_npm', 'tahun_ajaran', 'status', 'total_cicilan']);

        // cicilan
        // dd($data);
        $data['total_cicilan'] = $data['jumlah_cicilan_1'] +
            $data['jumlah_cicilan_2'] +
            $data['jumlah_cicilan_3'];

        $res = $mahasiswa->tahun_ajaran()->sync([
            $history['id'] => $data
        ], false);

        return redirect()->route('transaksi.keuangan.edit', [
            'keuangan' => $npm,
            'ta' => $history['id']
        ]);
    }

    public function formatToHtmlDate($date){
        $date = explode(" ", $date);
        // if (count($date))
        if (count($date) > 1){
            // dd($date);
            return join("T", $date);
        }
        else if (count($date) == 1){
            return null;
        }
        else {
            dd($date);
            return null;
        }
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
