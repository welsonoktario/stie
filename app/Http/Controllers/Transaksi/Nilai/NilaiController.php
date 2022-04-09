<?php

namespace App\Http\Controllers\Transaksi\Nilai;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use App\Models\TahunAjaran;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use Throwable;

class NilaiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        $selectedTahunAkademik = Request::get('ta');
        $tahunAkademiks = TahunAjaran::orderBy('id', 'DESC')->get();
        $mahasiswas = Mahasiswa::select(['mahasiswas.npm', 'mahasiswas.status_mahasiswa', 'users.name as nama', 'jurusans.nama as jurusan'])
            // ->doesntHave('mahasiswa_konversi')
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
     * @return \Inertia\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
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
        $selectedTahunAkademik = Request::get('ta');
        $tahunAkademiks = TahunAjaran::orderBy('id', 'DESC')->get();
        $mahasiswa->load([
            'jadwals' => function ($q) use ($selectedTahunAkademik) {
                return $q->with('matakuliah')->when($selectedTahunAkademik, function ($query, $selectedTahunAkademik) {
                    if ($selectedTahunAkademik == 'semua') {
                        $query;
                    } else {
                        $query->where('tahun_ajaran_id', (int) $selectedTahunAkademik);
                    }
                });
            },
            'user',
            'jurusan',
            'status_mahasiswa'
        ]);

        $tahunAkademiks->prepend(['id' => 'semua', 'tahun_ajaran' => 'Semua']);

        return Inertia::render('Transaksi/Nilai/NilaiDetail', [
            'tahunAkademiks' => fn () => $tahunAkademiks,
            'selectedTahunAkademik' => fn () => $selectedTahunAkademik,
            'mahasiswa' => $mahasiswa
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\Mahasiswa  $mahasiswa
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Mahasiswa $mahasiswa)
    {
        try {
            $jadwal = $request::get('jadwal_id');

            $mahasiswa->jadwals()->syncWithPivotValues([$jadwal], ['nilai_akhir' => $request::get('nilai')], false);
        } catch (Throwable $e) {
            Log::error($e);
            return Redirect::route(
                'transaksi.nilai.edit',
                [
                    'mahasiswa' => $mahasiswa->npm,
                    'ta' => $request::get('ta')
                ]
            )->with(
                [
                    'status' => 'FAIL',
                    'msg' => "Terjadi kesalahan mengubah nilai"
                ]
            );
        }

        return Redirect::route(
            'transaksi.nilai.edit',
            [
                'mahasiswa' => $mahasiswa->npm,
                'ta' => Request::get('ta')
            ]
        )->with(
            [
                'status' => 'OK',
                'msg' => "Berhasil mengubah nilai"
            ]
        );
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
