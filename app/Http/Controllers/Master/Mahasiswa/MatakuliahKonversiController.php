<?php

namespace App\Http\Controllers\Master\Mahasiswa;

use Inertia\Inertia;
use App\Models\Mahasiswa;
use App\Models\Matakuliah;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MatakuliahKonversi;

class MatakuliahKonversiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($mahasiswa_konversi_id)
    {
        //

        // dd($mahasiswa_konversi_id);

        $mahasiswa = Mahasiswa::where('npm','=' ,$mahasiswa_konversi_id)
            // ->has('mahasiswa_konversi')
            ->with(['user','jurusan','dosen','mahasiswa_konversi.matakuliah_konversis.matakuliah'])
            ->first();

        $ip = 0;
        $matakuliah_konversis = $mahasiswa->mahasiswa_konversi->matakuliah_konversis;

        // dd($matakuliah_konversis);
        if ($matakuliah_konversis) {
            $totalNilaiKaliSks = 0;
            $totalSks = 0;
            foreach ($matakuliah_konversis as $mk_konversi) {
                $nilai = $mk_konversi->nilai_matakuliah;
                $sks = $mk_konversi->matakuliah->sks;
                $totalNilaiKaliSks += $nilai * $sks;
                $totalSks += $sks;
            }
            $ip = $totalNilaiKaliSks/$totalSks;
        }

        // dd($mahasiswa);
        return Inertia::render('Master/Mahasiswa/Konversi/Matakuliah/MatakuliahKonversi',[
            'mahasiswa' => $mahasiswa,
            'matakuliahs' => $mahasiswa->mahasiswa_konversi->matakuliah_konversis,
            'ip' => $ip,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($mahasiswa_konversi_id)
    {
        //

        // $mahasiswa = Mahasiswa::find($mahasiswa_konversi_id)
        //     ->has('mahasiswa_konversi')
        //     ->first();

        $mahasiswa = Mahasiswa::where('npm','=' ,$mahasiswa_konversi_id)
            ->first();
        $matakuliahs = Matakuliah::with('kurikulum')->get();
        return Inertia::render('Master/Mahasiswa/Konversi/Matakuliah/MatakuliahKonversiDetail',[
            'matakuliahs' => $matakuliahs,
            'mahasiswa' => $mahasiswa,

        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $mahasiswa_konversi_id)
    {
        // data mk lama
        $kode_matakuliah = $request->kode_matakuliah;
        $nama_matakuliah = $request->nama_matakuliah;
        $nilai = $request->nilai;
        $sks = $request->sks;

        // data mk baru
        $matakuliah_id = $request->matakuliah_baru_id;
        // dd($matakuliah_id);
        $mahasiswa = Mahasiswa::where('npm','=',$mahasiswa_konversi_id)->first();

        // $mk_konversi = $mahasiswa->mahasiswa_konversi->matakuliah_konversis=
        $mk_konversi = new MatakuliahKonversi();
        $mk_konversi->create([
            'kode_matakuliah' => $kode_matakuliah,
            'nama_matakuliah' => $nama_matakuliah,
            'sks_matakuliah' => $sks,
            'nilai_matakuliah' => $nilai,
            'mahasiswa_konversi_id' => $mahasiswa->mahasiswa_konversi->id,
            'matakuliah_id' => $matakuliah_id
        ]);

        // return redirect(route('master.mahasiswa-konversi.matakuliah.index', {mahasiswa_konversi_id: $mahasiswa->mahasiswa_konversi->id}));

        return redirect()->route('master.mahasiswa-konversi.matakuliah.index',
            ['mahasiswa_konversi_id' => $mahasiswa->npm]
        );

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($mahasiswa_konversi_id, $matakuliah_konversi_id)
    {
        //
        $mahasiswa = Mahasiswa::where('npm', '=', $mahasiswa_konversi_id)
            ->first();
        $matakuliah_konversi = MatakuliahKonversi::findOrFail($matakuliah_konversi_id);
        $matakuliahs = Matakuliah::with('kurikulum')->get();
        // dd($matakuliahs);
        return Inertia::render('Master/Mahasiswa/Konversi/Matakuliah/MatakuliahKonversiDetail',[
            'matakuliahs' => $matakuliahs,
            'mahasiswa' => $mahasiswa,
            'matakuliah_konversi' => $matakuliah_konversi,
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
    public function update(Request $request, $mahasiswa_konversi_id, $matakuliah_konversi_id)
    {
        // data mk lama
        $kode_matakuliah = $request->kode_matakuliah;
        $nama_matakuliah = $request->nama_matakuliah;
        $nilai = $request->nilai;
        $sks = $request->sks;

        // data mk baru
        $matakuliah_id = $request->matakuliah_baru_id;
        // dd($matakuliah_id);
        $mahasiswa = Mahasiswa::where('npm', '=', $mahasiswa_konversi_id)->first();
        // dd($mahasiswa, $mahasiswa_konversi_id);
        // $mk_konversi = $mahasiswa->mahasiswa_konversi->matakuliah_konversis=
        $mk_konversi = MatakuliahKonversi::findOrFail($matakuliah_konversi_id);
        // dd($mk_konversi, $mahasiswa_konversi_id, $matakuliah_konversi_id);
        $mk_konversi->update([
            'kode_matakuliah' => $kode_matakuliah,
            'nama_matakuliah' => $nama_matakuliah,
            'sks_matakuliah' => $sks,
            'nilai_matakuliah' => $nilai,
            'mahasiswa_konversi_id' => $mahasiswa->mahasiswa_konversi->id,
            'matakuliah_id' => $matakuliah_id
        ]);

        // return redirect(route('master.mahasiswa-konversi.matakuliah.index', {mahasiswa_konversi_id: $mahasiswa->mahasiswa_konversi->id}));

        return redirect()->route('master.mahasiswa-konversi.matakuliah.index',
            ['mahasiswa_konversi_id' => $mahasiswa->npm]
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($mahasiswa_konversi_id, $matakuliah_konversi_id)
    {
        // dd('megic', $mahasiswa_konversi_id, $matakuliah_konversi_id);

        $matakuliah = MatakuliahKonversi::find($matakuliah_konversi_id);

        $matakuliah->delete();

        $mahasiswa = Mahasiswa::where('npm','=',$mahasiswa_konversi_id)->first();
        return redirect()->route('master.mahasiswa-konversi.matakuliah.index',
            ['mahasiswa_konversi_id' => $mahasiswa->npm]
        );

        //
    }
}
