<?php

namespace App\Http\Controllers\Master\Akademik;

use Carbon\Carbon;
use Inertia\Inertia;
use App\Models\TahunAjaran;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use App\Http\Requests\Master\Akademik\TahunAjaran\StoreTahunAjaranRequest;
use App\Http\Requests\Master\Akademik\TahunAjaran\UpdateTahunAjaranRequest;

class TahunAjaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tahunAjarans = TahunAjaran::filter(Request::only(['query', 'orderBy', 'orderType']))
            ->paginate(Request::get('perPage') ?: 10)
            ->withQueryString();

        return Inertia::render(
            'Master/Akademik/TahunAjaran/AkademikTahunAjaran',
            ['tahunAjarans' => $tahunAjarans]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Master/Akademik/TahunAjaran/AkademikTahunAjaranDetail');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Master\Akademik\TahunAjaran\StoreTahunAjaranRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTahunAjaranRequest $request)
    {   
        // dd('disini');
        
        // if ($request['tambahMahasiswa']) {
        //     $tahunSekarang = (new Carbon($request['tanggal_mulai']))->year;
        //     $periodeSekarang = $request['periode'];
        //     $p = ['1'=>'2', '2'=>'1'];
        //     $periodeTerakhir = $p[$periodeSekarang];
        //     $tahunTerakhir = $periodeSekarang == '1' ? $tahunSekarang : $tahunSekarang - 1;
    
        //     $tahunAjaranLalu = TahunAjaran::whereYear('tanggal_mulai', '=', $tahunTerakhir)
        //         ->where('periode','=',$periodeTerakhir)->with('mahasiswas')->first();

        //     // select semua mhs di smt terakhir tersebut dengan 
        //     // status tidak lulus, dikeluarkan, meninggal
        //     $mahasiswas = $tahunAjaranLalu->mahasiswas;//->has('mahasiswas')->get();
        //     $id_mhs = [];
        //     foreach ($mahasiswas as $mhs) {
        //         if(in_array($mhs->pivot->status, ['Aktif','Tidak Aktif','Cuti'])){
        //             $id_mhs[] = $mhs->pivot->mahasiswa_npm;
        //         }
        //     }
        // }
        // dd($request->toArray(), $id_mhs);
        try {
            $tahunAjaran = TahunAjaran::create($request->validated());

            // jika aktif, ubah kolom lainnya jadi tidak aktif
            if ($tahunAjaran->aktif){
                $affected = DB::table('tahun_ajarans')
                    ->where('id', '!=', $tahunAjaran->id)
                    ->update(['aktif' => false]);
            }
            if ($request['tambahMahasiswa']) {
                $tahunSekarang = (new Carbon($request['tanggal_mulai']))->year;
                $periodeSekarang = $request['periode'];
                $p = ['1'=>'2', '2'=>'1'];
                $periodeTerakhir = $p[$periodeSekarang];
                $tahunTerakhir = $periodeSekarang == '1' ? $tahunSekarang : $tahunSekarang - 1;
        
                $tahunAjaranLalu = TahunAjaran::whereYear('tanggal_mulai', '=', $tahunTerakhir)
                    ->where('periode','=',$periodeTerakhir)->with('mahasiswas')->first();
    
                // select semua mhs di smt terakhir tersebut dengan 
                // status tidak lulus, dikeluarkan, meninggal
                $mahasiswas = $tahunAjaranLalu->mahasiswas;//->has('mahasiswas')->get();
                $id_mhs = [];
                foreach ($mahasiswas as $mhs) {
                    if(in_array($mhs->pivot->status, ['Aktif','Tidak Aktif','Cuti'])){
                        $id_mhs[] = $mhs->pivot->mahasiswa_npm;
                    }
                }
                $tahunAjaran->mahasiswas()->attach($id_mhs);
            }
        } catch (\Throwable $th) {
            //throw $th;
        }

        return redirect()
            ->route('master.tahun-ajaran.index')
            ->with(
                [
                    'status' => 'OK',
                    'msg' => "Tahun ajaran {$tahunAjaran->tahun_ajaran} berhasil ditambahkan"
                ]
            );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TahunAjaran  $tahunAjaran
     * @return \Illuminate\Http\Response
     */
    public function edit(TahunAjaran $tahunAjaran)
    {
        return Inertia::render(
            'Master/Akademik/TahunAjaran/AkademikTahunAjaranDetail',
            ['tahunAjaran' => $tahunAjaran]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Master\Akademik\TahunAjaran\UpdateTahunAjaranRequest  $request
     * @param  \App\Models\TahunAjaran  $tahunAjaran
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTahunAjaranRequest $request, TahunAjaran $tahunAjaran)
    {
        // dd($request->toArray());
        $tahunAjaran->update($request->validated());
        // dd($tahunAjaran);
        
        if ($tahunAjaran->aktif){
            $affected = DB::table('tahun_ajarans')
                ->where('id', '!=', $tahunAjaran->id)
                ->update(['aktif' => false]);
        }
        
        return redirect()
            ->route('master.tahun-ajaran.index')
            ->with(
                [
                    'status' => 'OK',
                    'msg' => "Tahun ajaran {$tahunAjaran->tahun_ajaran} berhasil diperbarui"
                ]
            );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TahunAjaran  $tahunAjaran
     * @return \Illuminate\Http\Response
     */
    public function destroy(TahunAjaran $tahunAjaran)
    {
        if (!$tahunAjaran->delete()) {
            return redirect()
                ->route('master.tahun-ajaran.index')
                ->with(
                    [
                        'status' => 'FAIL',
                        'msg' => "Terjadi kesalahan menghapus tahun ajaran {$tahunAjaran->tahun_ajaran}"
                    ]
                );
        }

        return redirect()
            ->route('master.tahun-ajaran.index')
            ->with(
                [
                    'status' => 'OK',
                    'msg' => "Tahun ajaran {$tahunAjaran->tahun_ajaran} berhasil dihapus"
                ]
            );
    }
}
