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
        $selectedTahunAkademik = (int) Request::get('ta') ?: TahunAjaran::firstWhere('aktif', true)->id;
        $tahunAkademiks = TahunAjaran::orderBy('tanggal_mulai', 'DESC')->get();
        $mahasiswas = Mahasiswa::select(['mahasiswas.npm', 'mahasiswas.status_mahasiswa', 'status_mahasiswa.status', 'users.name as nama', 'jurusans.nama as jurusan'])
            // ->doesntHave('mahasiswa_konversi')
            ->join('users', 'users.id', '=', 'mahasiswas.user_id')
            ->leftJoin('jurusans', 'jurusans.id', '=', 'mahasiswas.jurusan_id')
            ->when($selectedTahunAkademik, function ($query, $selectedTahunAkademik) {
                return $query->whereHas('status_mahasiswa', fn ($q) => $q->whereIn('status_mahasiswa.tahun_ajaran', [$selectedTahunAkademik]));
            }, function ($query) use ($tahunAkademiks) {
                return $query->whereHas('status_mahasiswa', fn ($q) => $q->whereIn('status_mahasiswa.tahun_ajaran', [$tahunAkademiks[0]->id]));
            })
            ->join('status_mahasiswa', 'status_mahasiswa.mahasiswa_npm', '=','mahasiswas.npm')
            ->where('status_mahasiswa.tahun_ajaran', $selectedTahunAkademik)
            ->filter(Request::only(['query', 'orderBy', 'orderType']))
            ->paginate(Request::get('perPage') ?: 10)
            ->withQueryString();

        // dd($mahasiswas);

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
        $selectedTahunAkademik = (int) Request::get('ta') ?: 0;
        $mahasiswa->load([
            'jadwals' => function ($q) use ($selectedTahunAkademik) {
                return $q->with(['matakuliah', 'tahun_ajaran'])->when($selectedTahunAkademik, function ($query, $selectedTahunAkademik) {
                    if ($selectedTahunAkademik == 'semua') {
                        return $query;
                    } else {
                        return $query->where('tahun_ajaran_id', (int) $selectedTahunAkademik);
                    }
                });
            },
            'tahun_ajaran' => function ($q) use ($selectedTahunAkademik) {
                return $q->when($selectedTahunAkademik, function ($query, $selectedTahunAkademik) {
                    if ($selectedTahunAkademik == 'semua' || $selectedTahunAkademik == 0) {
                        return $query->orderBy('tanggal_mulai', 'DESC');
                    } else {
                        $ta = TahunAjaran::find($selectedTahunAkademik);
                        return $query->where('tanggal_mulai', '<=', $ta->tanggal_mulai)
                            ->orderBy('tanggal_mulai','DESC');
                    }
                });
            },
            'user',
            'jurusan',
            'status_mahasiswa',
            'mahasiswa_konversi.matakuliah_konversis'
        ]);

        $ips = 0;
        $ipk = 0;

        // hitung ipk dari smt sekarang ke bawah
        $tas = $mahasiswa->tahun_ajaran->keyBy('id')->keys()->all();
        // dd(sort($tas));
        rsort($tas);
        // dd($tas);
        if ($selectedTahunAkademik) {
            // hitung ip dari semester yang dipilih

            // HItung IPS
            // dump('hitung ips');

            $ips = $mahasiswa->hitungIP([$selectedTahunAkademik]);

            // Hitung IPK
            $hitungIpKonversi = count($tas) == 1 ? true : false;
            $ipk = $mahasiswa->hitungIP($tas, $hitungIpKonversi);
            // dd($ipk);

        } else {
            // dump('ipk');
            // hitung ipk
            // dump('ipk');
            // $ips = $mahasiswa->hitungIP([array_shift($tas)]);
            // kalau ips nol, hitung ip ke belakang tanpa yang skrg
            // if ($ips === 0) {
            //     // kalau tasnya gak ada, berarti mhs baru di smt itu
            //     if ($tas === 0) {
            //         // dump('disini gak');
            //         $ipk = 'Baru';
            //     }
            //     else {
            //         $ipk = $mahasiswa->hitungIP($tas);
            //     }
            // }
            // else {
            // }
            $ipk = $mahasiswa->hitungIP([]);
            $ips = "";
        }

        // dump($ipk, $ips);

        $tahunAkademiks = $mahasiswa->tahun_ajaran()->orderBy('tanggal_mulai','DESC')->get();
        // dd($tahunAkademiks);
        // $tahunAkademiks = TahunAjaran::whereIn('id', $mahasiswa->tahun_ajaran->keyBy('id')->keys()->toArray())->orderBy('tanggal_mulai', 'DESC')->get();
        $tahunAkademiks->prepend(['id' => 0, 'tahun_ajaran' => 'Semua']);

        // dump($ips, $ipk);
        return Inertia::render('Transaksi/Nilai/NilaiDetail', [
            'tahunAkademiks' => fn () => $tahunAkademiks,
            'selectedTahunAkademik' => fn () => $selectedTahunAkademik,
            'mahasiswa' => $mahasiswa,
            'ips' => round($ips, 3),
            'ipk' => round($ipk, 3)
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
        // dd($request::get("jadwal_id"));
        try {
            $jadwal = $request::get('jadwal_id');

            $mahasiswa->jadwals()->syncWithPivotValues([$jadwal], [
                'nilai_akhir' => $request::get('nilai'),
                'nisbi'=> $request::get('nisbi'),
                'angka_mutu' => $request::get('angka_mutu'),
            ], false);
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
