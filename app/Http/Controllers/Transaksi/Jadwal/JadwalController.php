<?php

namespace App\Http\Controllers\Transaksi\Jadwal;

use App\Http\Controllers\Controller;
use App\Http\Requests\Transaksi\Jadwal\StoreJadwalRequest;
use App\Http\Requests\Transaksi\Jadwal\UpdateJadwalRequest;
use App\Models\Jadwal;
use App\Models\Kurikulum;
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
        $tahunAkademiks = TahunAjaran::orderBy('tanggal_mulai', 'DESC')->get();
        $kurikulums = Kurikulum::where('aktif', 1)->orderBy('nama', 'DESC')->get();
        // dd($kurikulums);


        $jadwals = Jadwal::index();
        $selectedKurikulum = (int) Request::get('kur');

        if ($selectedTahunAkademik) {
            $jadwals = $jadwals->where('tahun_ajaran_id', $selectedTahunAkademik);
        } else {
            $selectedTahunAkademik = $tahunAkademiks->firstWhere('aktif', '=', true)->id;

            $jadwals = $jadwals->where('tahun_ajaran_id', $selectedTahunAkademik);
        }

        // dd($selectedKurikulum);
        if ($selectedKurikulum) {
            $jadwals = $jadwals->where('kurikulums.id', $selectedKurikulum);
        } else {
            $jadwals = $jadwals->where('kurikulums.aktif', 1);
        }
        // dd($jadwals, $selectedKurikulum);

        $jadwals = $jadwals->filter(Request::only(['query', 'orderBy', 'orderType']))
            ->paginate(Request::get('perPage') ?: 10)
            ->withQueryString();

        return Inertia::render(
            'Transaksi/Jadwal/Jadwal',
            [
                'tahunAkademiks' => fn () => $tahunAkademiks,
                'kurikulums' => fn () => $kurikulums,
                'selectedTahunAkademik' => fn () => $selectedTahunAkademik,
                'selectedKurikulum' => fn () => $selectedKurikulum,
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
        $kurikulumAktif = Kurikulum::where('aktif', 1)->get();
        $kurikulumAktifId = array();
        foreach ($kurikulumAktif as $kurikulum) {
            $kurikulumAktifId[] = $kurikulum->id;
        }
        $ruangans = Ruangan::all();
        $matakuliahs = Matakuliah::whereIn('kurikulum_id', $kurikulumAktifId)->orderBy('semester')->get();

        return Inertia::render(
            'Transaksi/Jadwal/JadwalDetail',
            [
                'tahunAkademik' => $tahunAkademik,
                'ruangans' => $ruangans,
                'matakuliahs' => $matakuliahs->sortBy('semester')->toArray()
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
        $kurikulumAktif = Kurikulum::where('aktif', 1)->get();
        $kurikulumAktifId = array();
        foreach ($kurikulumAktif as $kurikulum) {
            $kurikulumAktifId[] = $kurikulum->id;
        }
        $ruangans = Ruangan::all();
        $matakuliahs = Matakuliah::whereIn('kurikulum_id', $kurikulumAktifId)->orderBy('semester')->get();

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
        // dd($request->all());
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

    public function print($jadwal)
    {
        $jadwal = Jadwal::query()
            ->with([
                'matakuliah.matakuliah_jurusan.jurusan',
                'tahun_ajaran',
                'ruanganUts',
                'ruanganUas',
                'dosens.staff.user',
                'mahasiswas.user',
                'mahasiswas.jadwals' => function ($q) use ($jadwal) {
                    return $q->where('jadwal_id', $jadwal);
                }
            ])
            ->find($jadwal);

        // return ($jadwal->mahasiswas->toJson());

        return Inertia::render('Transaksi/Jadwal/JadwalPrint', [
            'jadwal' => $jadwal,
            'tipe' => Request::input('tipe')
        ]);
    }
}
