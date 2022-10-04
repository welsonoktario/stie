<?php

namespace App\Http\Controllers\Transaksi\Jadwal;

use App\Http\Controllers\Controller;
use App\Http\Requests\Transaksi\Jadwal\StoreJadwalRequest;
use App\Http\Requests\Transaksi\Jadwal\UpdateJadwalRequest;
use App\Models\JabatanStruktural;
use App\Models\Dosen;
use App\Models\Jadwal;
use App\Models\Kurikulum;
use App\Models\Matakuliah;
use App\Models\Ruangan;
use App\Models\TahunAjaran;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use Throwable;

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
        $kurikulumAktifId = [];
        foreach ($kurikulumAktif as $kurikulum) {
            $kurikulumAktifId[] = $kurikulum->id;
        }
        $ruangans = Ruangan::all();
        $dosens = Dosen::query()
            ->with(['staff.user'])
            ->get();
        $matakuliahs = Matakuliah::whereIn('kurikulum_id', $kurikulumAktifId)->orderBy('semester')->get();

        return Inertia::render(
            'Transaksi/Jadwal/JadwalDetail',
            [
                'tahunAkademik' => $tahunAkademik,
                'ruangans' => $ruangans,
                'dosens' => $dosens,
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
        // dd($request->all());
        DB::beginTransaction();

        try {
            // dd()
            $dosens = collect($request->dosens)->map(fn ($dosen) => $dosen['id']);
            $jadwal = Jadwal::create($request->validated());
            $jadwal->dosens()->sync($dosens, false);

            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();

            return redirect()
                ->route('transaksi.jadwal.index')
                ->with(
                    [
                        'status' => 'FAIL',
                        'msg' => "Terjadi kesalahan menambah jadwal"
                    ]
                );
        }

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
        $jadwal->load(['dosens.staff.user']);

        $dosens = Dosen::query()
            ->with(['staff.user'])
            ->get();

        return Inertia::render(
            'Transaksi/Jadwal/JadwalDetail',
            [
                'jadwal' => $jadwal,
                'tahunAkademik' => $tahunAkademik,
                'ruangans' => $ruangans,
                'matakuliahs' => $matakuliahs,
                'dosens' => $dosens
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
        // dd($request->dosens);
        DB::beginTransaction();

        try {
            $jadwal->update($request->validated());
            $dosens = collect($request->dosens)->map(fn ($dosen) => $dosen['id']);
            $jadwal->dosens()->sync($dosens);

            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();

            return redirect()
                ->route('transaksi.jadwal.index')
                ->with(
                    [
                        'status' => 'FAIL',
                        'msg' => "Jadwal gagal diubah"
                    ]
                );
        }

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
        DB::beginTransaction();

        try {
            $jadwal->dosens()->sync([]);
            $jadwal->delete();

            DB::commit();

            return redirect()
                ->route('transaksi.jadwal.index')
                ->with(
                    [
                        'status' => 'FAIL',
                        'msg' => "Terjadi kesalahan menghapus jadwal"
                    ]
                );
        } catch (Throwable $e) {
            DB::rollBack();

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

    public function print($jadwal)
    {
        $jadwal = Jadwal::query()
            ->with([
                'matakuliah.matakuliah_jurusan.jurusan',
                'tahun_ajaran',
                'ruangan',
                'ruanganUts',
                'ruanganUas',
                'dosens.staff.user',
                'mahasiswas.user',
                'mahasiswas.jadwals' => function ($q) use ($jadwal) {
                    return $q->where('jadwal_id', $jadwal);
                }
            ])
            ->find($jadwal);

        // Hardcode hubungan jurusan dengan jabatan struktural
        $jurusan = strtolower($jadwal->matakuliah->matakuliah_jurusan->jurusan->nama);
        // 6 adalah id jabatan untuk kepala departemen manajemen
        // 7 untuk departemen ekonomi pembangunan (sesuaikan dgn db)
        $jabatanId = str_contains($jurusan, "manajemen") ? 6 : 7;

        $kepala_departemen = JabatanStruktural::with(['staff.user','staff.dosen'])->findOrFail($jabatanId)->staff;
        // $kepala_departemen =
        // dd($kepala_departemen);
        return Inertia::render('Transaksi/Jadwal/JadwalPrint', [
            'jadwal' => $jadwal,
            'tipe' => Request::input('tipe'),
            'kepalaDepartemen' => $kepala_departemen,
        ]);
    }
}
