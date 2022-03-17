<?php

namespace App\Http\Controllers\Transaksi\Jadwal;

use App\Http\Controllers\Controller;
use App\Http\Requests\Transaksi\Jadwal\StoreJadwalRequest;
use App\Http\Requests\Transaksi\Jadwal\UpdateJadwalRequest;
use App\Models\Jadwal;
use App\Models\TahunAjaran;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class JadwalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $selectedTahunAkademik = (int) Request::input('ta');
        $tahunAkademiks = TahunAjaran::orderBy('id', 'DESC')->get();
        $jadwals = Jadwal::index();

        if ($selectedTahunAkademik) {
            $jadwals = $jadwals->where('tahun_ajaran_id', $selectedTahunAkademik);
        } else {
            $selectedTahunAkademik = $tahunAkademiks[0]->id;
        }

        $jadwals = $jadwals->filter(Request::only(['query', 'orderBy', 'orderType']))
            ->paginate(Request::get('perPage') ?: 10)
            ->withQueryString();

        // dd($selectedTahunAkademik, $jadwals);

        return Inertia::render(
            'Transaksi/Jadwal/Jadwal',
            [
                'tahunAkademiks' => fn () => $tahunAkademiks,
                'selectedTahunAkademik' => fn () => $selectedTahunAkademik,
                'jadwals' => fn () => $jadwals
            ]
        );
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
     * @param  \App\Http\Requests\Transaksi\Jadwal\StoreJadwalRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreJadwalRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Jadwal  $jadwal
     * @return \Illuminate\Http\Response
     */
    public function show(Jadwal $jadwal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Jadwal  $jadwal
     * @return \Illuminate\Http\Response
     */
    public function edit(Jadwal $jadwal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Transaksi\Jadwal\UpdateJadwalRequest  $request
     * @param  \App\Models\Jadwal  $jadwal
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateJadwalRequest $request, Jadwal $jadwal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Jadwal  $jadwal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Jadwal $jadwal)
    {
        //
    }
}
