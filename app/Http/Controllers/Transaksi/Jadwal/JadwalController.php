<?php

namespace App\Http\Controllers\Transaksi\Jadwal;

use App\Http\Controllers\Controller;
use App\Http\Requests\Transaksi\Jadwal\StoreJadwalRequest;
use App\Http\Requests\Transaksi\Jadwal\UpdateJadwalRequest;
use App\Models\Jadwal;
use App\Models\Matakuliah;
use App\Models\Ruangan;
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
        $selectedTahunAkademik = (int) Request::get('ta');
        $tahunAkademiks = TahunAjaran::orderBy('id', 'DESC')->get();
        $jadwals = Jadwal::index();

        

        if ($selectedTahunAkademik) {
            $jadwals = $jadwals->where('tahun_ajaran_id', $selectedTahunAkademik);
        } else {
            $selectedTahunAkademik = $tahunAkademiks->where('aktif', '=', true)->first()->id;
        }

        // dd($selectedTahunAkademik);

        $jadwals = $jadwals->filter(Request::only(['query', 'orderBy', 'orderType']))
            ->paginate(Request::get('perPage') ?: 10)
            ->withQueryString();

        // dd($selectedTahunAkademik, $jadwals);

        // dd($selectedTahunAkademik);

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
        $tahunAkademik = TahunAjaran::find(Request::get('ta'));
        $ruangans = Ruangan::all();
        $matakuliahs = Matakuliah::all();

        return Inertia::render(
            'Transaksi/Jadwal/JadwalDetail',
            [
                'tahunAkademik' => $tahunAkademik,
                'ruangans' => $ruangans,
                'matakuliahs' => $matakuliahs
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Transaksi\Jadwal\StoreJadwalRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreJadwalRequest $request)
    {
        Jadwal::create($request->validated());

        return redirect()
            ->route('transaksi.jadwal.index')
            ->with(
                [
                    'status' => 'OK',
                    'msg' => "Jadwal berhasil ditambahkan"
                ]
            );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Jadwal  $jadwal
     * @return \Illuminate\Http\Response
     */
    public function edit(Jadwal $jadwal)
    {
        $tahunAkademik = TahunAjaran::find($jadwal->tahun_ajaran_id);
        $ruangans = Ruangan::all();
        $matakuliahs = Matakuliah::all();

        return Inertia::render(
            'Transaksi/Jadwal/JadwalDetail',
            [
                'jadwal' => $jadwal,
                'tahunAkademik' => $tahunAkademik,
                'ruangans' => $ruangans,
                'matakuliahs' => $matakuliahs
            ]
        );
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
        $jadwal->update($request->validated());

        return redirect()
            ->route('transaksi.jadwal.index')
            ->with(
                [
                    'status' => 'OK',
                    'msg' => "Jadwal berhasil diubah"
                ]
            );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Jadwal  $jadwal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Jadwal $jadwal)
    {
        if (!$jadwal->delete()) {
            return redirect()
                ->route('transaksi.jadwal.index')
                ->with(
                    [
                        'status' => 'FAIL',
                        'msg' => "Terjadi kesalahan menghapus jadwal"
                    ]
                );
        }

        return redirect()
            ->route('transaksi.jadwal.index')
            ->with(
                [
                    'status' => 'OK',
                    'msg' => "Jadwal berhasil dihapus"
                ]
            );
    }
}
