<?php

namespace App\Http\Controllers\Transaksi\Jadwal;

use App\Http\Controllers\Controller;
use App\Http\Requests\Transaksi\JadwalMahasiswa\UpdateJadwalRequest;
use App\Models\Jadwal;
use App\Models\Mahasiswa;
use App\Models\TahunAjaran;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Inertia\Inertia;
use Throwable;

class JadwalMahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd("wo");
        $jadwal = Jadwal::with('matakuliah')->find(Request::get('jadwal'));
        $tahunAkademik = TahunAjaran::find(Request::get('ta'));

        $mahasiswas = Mahasiswa::indexJadwal()
            // ->with(['jadwals' => function($query) use ($jadwal){
            //     return $query->where('id', $jadwal->id);
            // }])
            ->whereHas('jadwals', function ($q) use ($jadwal) {
                return $q->where('id', $jadwal->id);
            })
            ->where('jadwal_mahasiswa.jadwal_id', $jadwal->id)
            ->filter(Request::only(['query', 'orderBy', 'orderType']))
            ->paginate(Request::get('perPage') ?: 10)
            ->withQueryString();

        // dd($mahasiswas->toJson());

        return Inertia::render('Transaksi/Jadwal/JadwalMahasiswa', [
            'mahasiswas' => $mahasiswas,
            'jadwal' => $jadwal,
            'tahunAkademik' => $tahunAkademik
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            $tahunAkademik = TahunAjaran::find(Request::get('ta'));
            $mahasiswas = Mahasiswa::with(['user', 'jurusan'])->whereHas('tahun_ajaran', function ($q) use ($tahunAkademik) {
                $q->where('id', $tahunAkademik->id);
            })->get();
        } catch (Throwable $e) {
            return Response::json(['status' => 'FAIL', 'msg' => $e->getMessage()]);
        }
        // dd($mahasiswas);
        return Response::json([
            'status' => 'OK',
            'data' => $mahasiswas
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Transaksi\JadwalMahasiswa\UpdateJadwalRequest  $request
     * @param  \App\Models\Jadwal  $jadwal
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateJadwalRequest $request, Jadwal $jadwal)
    {
        // dd(Request::all());
        Log::debug(json_encode(Request::all()));
        try {
            $data = $request->validated();
            $mahasiswa = Mahasiswa::find(Request::input('mahasiswa_npm'));
            $mahasiswa->jadwals()->attach([Request::input('jadwal_id')]);
        } catch (Throwable $e) {
            return redirect()
                ->route(
                    'transaksi.jadwal.mahasiswa.index',
                    [
                        'jadwal' => Request::get('jadwal_id'),
                        'ta' => Request::get('ta')
                    ]
                )
                ->with(
                    [
                        'status' => 'FAIL',
                        'msg' => "Terjadi kesalahan menghapus jadwal"
                    ]
                );
        }

        return redirect()
            ->route(
                'transaksi.jadwal.mahasiswa.index',
                [
                    'jadwal' => Request::get('jadwal_id'),
                    'ta' => Request::get('ta')
                ]
            )
            ->with(
                [
                    'status' => 'OK',
                    'msg' => "Jadwal berhasil dihapus"
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
        Log::debug(json_encode(Request::all()));
        try {
            $jadwal = Jadwal::find(Request::get('jadwal_id'));
            $jadwal->mahasiswas()->detach(Request::get('mahasiswa_npm'));
        } catch (Throwable $e) {
            return redirect()
                ->route(
                    'transaksi.jadwal.mahasiswa.index',
                    [
                        'jadwal' => Request::get('jadwal_id'),
                        'ta' => Request::get('ta')
                    ]
                )
                ->with(
                    [
                        'status' => 'FAIL',
                        'msg' => "Terjadi kesalahan menghapus jadwal"
                    ]
                );
        }

        return redirect()
            ->route(
                'transaksi.jadwal.mahasiswa.index',
                [
                    'jadwal' => Request::get('jadwal_id'),
                    'ta' => Request::get('ta')
                ]
            )
            ->with(
                [
                    'status' => 'OK',
                    'msg' => "Jadwal berhasil dihapus"
                ]
            );
    }

    public function loadNilai(Jadwal $jadwal, Mahasiswa $mahasiswa)
    {
        $nilai = $mahasiswa->jadwals()
            ->firstWhere('jadwal_id', $jadwal->id);

        return response()->json($nilai);
    }

    public function editNilai(Jadwal $jadwal, Mahasiswa $mahasiswa)
    {
        $data = Request::only(['nilaiAkhir', 'nisbi', 'angkaMutu']);
        DB::beginTransaction();
        try {
            $mahasiswa->jadwals()->sync([$jadwal->id => [
                    'nilai_akhir' => $data['nilaiAkhir'],
                    'nisbi' => $data['nisbi'],
                    'angka_mutu' => $data['angkaMutu']
                ]
            ], false);

            DB::commit();

            return redirect()
                ->route(
                    'transaksi.jadwal.mahasiswa.index',
                    [
                        'jadwal' => $jadwal->id,
                        'ta' => Request::get('ta')
                    ]
                )
                ->with(
                    [
                        'status' => 'OK',
                        'msg' => "Jadwal berhasil dihapus"
                    ]
                );
        } catch (Throwable $e) {
            DB::rollBack();

            return response()->json(['status' => 'FAIL', 'msg' => $e->getMessage()]);
        }
    }
}
