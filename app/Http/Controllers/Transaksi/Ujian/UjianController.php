<?php

namespace App\Http\Controllers\Transaksi\Ujian;

use App\Http\Controllers\Controller;
use App\Models\JabatanStruktural;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\TahunAjaran;

class UjianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        $tahunAkademiks = TahunAjaran::orderBy('tanggal_mulai', 'DESC')->get();
        $selectedTahunAkademik = $request->ta ? $tahunAkademiks->firstWhere('id', $request->ta) : $tahunAkademiks->firstWhere('aktif','=',1);
        $mahasiswas = Mahasiswa::indexUjian($request->tipe)
            ->whereHas('tahun_ajaran', function ($q) use ($selectedTahunAkademik) {
                return $q->where('id', $selectedTahunAkademik->id);
            })
            ->filter($request->only(['query', 'orderBy', 'orderType']))
            ->paginate($request->perPage ?: 10)
            ->withQueryString();

        // dd($mahasiswas->toJson(JSON_PRETTY_PRINT));

        return Inertia::render('Transaksi/Ujian/Ujian', [
            'tipe' => $request->tipe,
            'tahunAkademiks' => fn () => $tahunAkademiks,
            'selectedTahunAkademik' => fn () => $selectedTahunAkademik,
            'mahasiswas' => fn () => $mahasiswas
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Inertia\Response
     */
    public function show(Request $request, $id, $ta)
    {
        $tahunAjaran = TahunAjaran::find($ta);
        $mahasiswa = Mahasiswa::with([
            'user',
            'jurusan',
            'status_mahasiswa',
            'jadwals' => function ($q) use (&$tahunAjaran) {
                return $q->with(['matakuliah', 'ruangan', 'ruanganUts','ruanganUas'])->where('tahun_ajaran_id', $tahunAjaran->id);
            }
        ])->find($id);

        $wakil_ketua_1 = JabatanStruktural::with(['staff.user', 'staff.dosen'])->find(2);
        // dd($wakil_ketua_1);
        // $wakil_ketua_1 =
        // dd($mahasiswa);

        // dd($mahasiswa->jadwals[0]->ruanganUts->nama_ruangan);
        return Inertia::render('Transaksi/Ujian/UjianDetail', [
            'mahasiswa' => $mahasiswa,
            'tipe' => $request->tipe,
            'ta' => $tahunAjaran,
            'wakil_ketua_1' => $wakil_ketua_1,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Inertia\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Mahasiswa  $mahasiswa
     * @return \Inertia\Response
     */
    public function edit(Mahasiswa $mahasiswa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Mahasiswa  $mahasiswa
     * @return \Inertia\Response
     */
    public function update(Request $request, Mahasiswa $mahasiswa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Mahasiswa  $mahasiswa
     * @return \Inertia\Response
     */
    public function destroy(Mahasiswa $mahasiswa)
    {
        //
    }
}
