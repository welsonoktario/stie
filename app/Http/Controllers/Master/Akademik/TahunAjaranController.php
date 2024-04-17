<?php

namespace App\Http\Controllers\Master\Akademik;

use Carbon\Carbon;
use Inertia\Inertia;
use App\Models\TahunAjaran;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use App\Http\Requests\Master\Akademik\TahunAjaran\StoreTahunAjaranRequest;
use App\Http\Requests\Master\Akademik\TahunAjaran\UpdateTahunAjaranRequest;
use Exception;
use Illuminate\Database\Events\TransactionBeginning;

class TahunAjaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tahunAjarans = TahunAjaran::filter(Request::only(['query', 'orderBy', 'orderType']))
            ->paginate(Request::get('perPage') ?: 10)
            ->withQueryString();

        return Inertia::render(
            'Master/Akademik/TahunAjaran/AkademikTahunAjaran',
            ['tahunAjarans' => $tahunAjarans]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Master/Akademik/TahunAjaran/AkademikTahunAjaranDetail');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Master\Akademik\TahunAjaran\StoreTahunAjaranRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTahunAjaranRequest $request)
    {
        $msg = '';
        try {
            DB::beginTransaction();
            $tahunAjaran = TahunAjaran::create($request->validated());

            // jika aktif, ubah kolom lainnya jadi tidak aktif
            if ($tahunAjaran->aktif){
                $affected = DB::table('tahun_ajarans')
                    ->where('id', '!=', $tahunAjaran->id)
                    ->update(['aktif' => false]);
            }
            if ($request['tambahMahasiswa']) {

                // $tahunSekarang = (new Carbon($request['tanggal_mulai']))->year;
                // $periodeSekarang = $request['periode'];

                // Ambil tahun yang sblmnya
                $tahunAjaranLalu = TahunAjaran::where('tanggal_mulai', '<', $request['tanggal_mulai'])
                    ->orderBy('tanggal_mulai','DESC')
                    ->with('mahasiswas')
                    ->first();

                // dd($tahunAjaranLalu);

                /* OLD SCRIPT
                $p = ['1'=>'2', '2'=>'1'];
                $periodeTerakhir = $p[$periodeSekarang];
                $tahunTerakhir = $periodeSekarang == '1' ? $tahunSekarang - 1 : $tahunSekarang;

                $tahunAjaranLalu = TahunAjaran::whereYear('tanggal_mulai', '=', $tahunTerakhir)
                    ->where('periode','=',$periodeTerakhir)->with('mahasiswas')->first();

                dd($tahunAjaranLalu, $tahunTerakhir, $periodeTerakhir,
                    TahunAjaran::whereYear('tanggal_mulai', '=', $tahunTerakhir)->get()
                );
                 */

                $msg = `Tahun ajaran {$tahunAjaran->tahun_ajaran} berhasil ditambahkan. Peringatan: Data mahasiswa tidak ditemukan pada semester sebelumnya. Gagal menambahkan data mahasiswa.`;
                // select semua mhs di smt terakhir tersebut dengan
                // status tidak lulus, dikeluarkan, meninggal
                if ($tahunAjaranLalu) {
                    // dd($tahunAjaranLalu, !$tahunAjaranLalu);
                    $mahasiswas = $tahunAjaranLalu->mahasiswas;//->has('mahasiswas')->get();
                    $id_mhs = [];
                    foreach ($mahasiswas as $mhs) {
                        // Tambahkan mahasiswa yang belum lulus
                        if(in_array($mhs->pivot->status, ['Aktif','Tidak Aktif','Cuti']) &&
                            !isset($mhs->tanggal_selesai)){
                            $id_mhs[$mhs->pivot->mahasiswa_npm] = ['status' => 'Tidak Aktif'];
                        }
                    }
                    $tahunAjaran->mahasiswas()->sync($id_mhs, false);
                    $msg = `Tahun ajaran {$tahunAjaran->tahun_ajaran} berhasil ditambahkan`;
                }
            }
            DB::commit();
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            dd($th);
        }

        return redirect()
            ->route('master.tahun-ajaran.index')
            ->with(
                [
                    'status' => 'OK',
                    'msg' => $msg,
                ]
            );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TahunAjaran  $tahunAjaran
     * @return \Illuminate\Http\Response
     */
    public function edit(TahunAjaran $tahunAjaran)
    {
        return Inertia::render(
            'Master/Akademik/TahunAjaran/AkademikTahunAjaranDetail',
            ['tahunAjaran' => $tahunAjaran, 'hasMahasiswas' => $tahunAjaran->mahasiswas->isNotEmpty()]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Master\Akademik\TahunAjaran\UpdateTahunAjaranRequest  $request
     * @param  \App\Models\TahunAjaran  $tahunAjaran
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTahunAjaranRequest $request, TahunAjaran $tahunAjaran)
    {
        // dd($request->toArray());

        DB::beginTransaction();
        try {

            $tahunAjaran->update($request->validated());
            if ($tahunAjaran->aktif){
                $affected = DB::table('tahun_ajarans')
                    ->where('id', '!=', $tahunAjaran->id)
                    ->update(['aktif' => false]);
            }

            if ($request->tambahMahasiswa && $tahunAjaran->mahasiswas->isEmpty()) {
                // Ambil tahun yang sblmnya
                $tahunAjaranLalu = TahunAjaran::where('tanggal_mulai', '<', $request['tanggal_mulai'])
                ->orderBy('tanggal_mulai','DESC')
                ->with('mahasiswas')
                ->first();

                if ($tahunAjaranLalu) {
                    $mahasiswas = $tahunAjaranLalu->mahasiswas;
                    $id_mhs = [];
                    foreach ($mahasiswas as $mhs) {
                        // Tambahkan mahasiswa yang belum lulus
                        if(in_array($mhs->pivot->status, ['Aktif','Tidak Aktif','Cuti']) &&
                            !isset($mhs->tanggal_selesai)){
                            $id_mhs[$mhs->pivot->mahasiswa_npm] = ['status' => 'Tidak Aktif'];
                        }
                    }
                    $tahunAjaran->mahasiswas()->sync($id_mhs, false);
                }
            }
            DB::commit();

            return redirect()
            ->route('master.tahun-ajaran.index')
            ->with(
                [
                    'status' => 'OK',
                    'msg' => "Tahun ajaran {$tahunAjaran->tahun_ajaran} berhasil diperbarui"
                ]
            );
        }
        catch (Exception $e) {
            DB::rollBack();
            dd('Error on updating Tahun Akademik', $e);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TahunAjaran  $tahunAjaran
     * @return \Illuminate\Http\Response
     */
    public function destroy(TahunAjaran $tahunAjaran)
    {
        DB::beginTransaction();
        try {
            $mahasiswas = $tahunAjaran->mahasiswas;
            if ($mahasiswas->isNotEmpty()){
                $tahunAjaran->mahasiswas()->detach();
            }

            if (!$tahunAjaran->delete()) {
                return redirect()
                    ->route('master.tahun-ajaran.index')
                    ->with(
                        [
                            'status' => 'FAIL',
                            'msg' => "Terjadi kesalahan menghapus tahun ajaran {$tahunAjaran->tahun_ajaran}"
                        ]
                    );
            }

            DB::commit();
            return redirect()
                ->route('master.tahun-ajaran.index')
                ->with(
                    [
                        'status' => 'OK',
                        'msg' => "Tahun ajaran {$tahunAjaran->tahun_ajaran} berhasil dihapus"
                    ]
                );
        }
        catch (\Throwable $ex) {
            DB::rollBack();
            dd("Error, " .$ex);
        }

    }
}
