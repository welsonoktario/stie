<?php

namespace App\Http\Controllers\Transaksi\Nilai;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMahasiswaRequest;
use App\Http\Requests\UpdateMahasiswaRequest;
use App\Models\Mahasiswa;
use App\Models\TahunAjaran;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class NilaiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $selectedTahunAkademik = (int) Request::get('ta');
        $tahunAkademiks = TahunAjaran::orderBy('id', 'DESC')->get();
        $mahasiswas = Mahasiswa::select(['mahasiswas.npm', 'mahasiswas.status_mahasiswa', 'users.name as nama', 'jurusans.nama as jurusan'])
            ->doesntHave('mahasiswa_konversi')
            ->join('users', 'users.id', '=', 'mahasiswas.user_id')
            ->leftJoin('jurusans', 'jurusans.id', '=', 'mahasiswas.jurusan_id')
            ->when($selectedTahunAkademik, function ($query, $selectedTahunAkademik) {
                return $query->whereHas('status_mahasiswa', fn ($q) => $q->whereIn('status_mahasiswa.tahun_ajaran', [$selectedTahunAkademik]));
            }, function ($query) use ($tahunAkademiks) {
                return $query->whereHas('status_mahasiswa', fn ($q) => $q->whereIn('status_mahasiswa.tahun_ajaran', [$tahunAkademiks[0]->id]));
            })
            ->filter(Request::only(['query', 'orderBy', 'orderType']))
            ->paginate(Request::get('perPage') ?: 10)
            ->withQueryString();

        return Inertia::render('Transaksi/Nilai/Nilai', [
            'tahunAkademiks' => fn () => $tahunAkademiks,
            'selectedTahunAkademik' => fn () => $selectedTahunAkademik,
            'mahasiswas' => fn () => $mahasiswas
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
     * @param  \App\Http\Requests\StoreMahasiswaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMahasiswaRequest $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Mahasiswa  $mahasiswa
     * @return \Illuminate\Http\Response
     */
    public function edit(Mahasiswa $mahasiswa)
    {
        $selectedTahunAkademik = (int) Request::get('ta');
        $tahunAkademiks = TahunAjaran::orderBy('id', 'DESC')->get();
        $mahasiswa->load(['user', 'jurusan', 'jadwals.matakuliah', 'status_mahasiswa']);

        return Inertia::render('Transaksi/Nilai/NilaiDetail', [
            'tahunAkademiks' => fn () => $tahunAkademiks,
            'selectedTahunAkademik' => fn () => $selectedTahunAkademik,
            'mahasiswa' => $mahasiswa
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMahasiswaRequest  $request
     * @param  \App\Models\Mahasiswa  $mahasiswa
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMahasiswaRequest $request, Mahasiswa $mahasiswa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Mahasiswa  $mahasiswa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mahasiswa $mahasiswa)
    {
        //
    }
}
