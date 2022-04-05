<?php

namespace App\Http\Controllers\Master\Mahasiswa;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Dosen;
use App\Models\Jurusan;
use App\Models\Mahasiswa;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use App\Models\MahasiswaKonversi;
use App\Models\MatakuliahKonversi;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class MahasiswaKonversiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $mahasiswas = Mahasiswa::select(['mahasiswas.npm','mahasiswas.status_mahasiswa','users.name as nama','jurusans.nama as jurusan'])
            ->has('mahasiswa_konversi')
            ->join('users','users.id','=','mahasiswas.user_id')
            ->leftJoin('jurusans','jurusans.id','=','mahasiswas.jurusan_id')
            ->filter($request->only(['query', 'orderBy', 'orderType']))
            ->paginate($request->get('perPage') ?: 10)
            ->withQueryString();

        return Inertia::render('Master/Mahasiswa/Konversi/MahasiswaKonversi',[
            'mahasiswas' => $mahasiswas,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $dosens = Dosen::with('staff.user')->get();
        $jurusans = Jurusan::all();
        return Inertia::render('Master/Mahasiswa/Konversi/MahasiswaKonversiDetail',[
            'dosens' => $dosens,
            'jurusans' => $jurusans,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request['password'] = Hash::make('12345678');
        $request['jurusan_id'] = $request['jurusan_id'] != '-' ? $request['jurusan_id']: null;
        $request['dosen_id'] = $request['dosen_id'] != '-' ? $request['dosen_id']: null;
        $msg = 'Berhasil menambahkan data';
        $status = 'OK';

        try {
            $user = User::create($request->all());
            try {
                $user->mahasiswa()->create($request->all());
                try {
                    $user->mahasiswa->mahasiswa_konversi()->create($request->all());

                    // assign ke tahun akademik (dari tanggal masuk sampai thn terakhir)
                    $tm = $request['tanggal_masuk'];
                    $tas = TahunAjaran::where('tanggal_selesai', '>', $tm)->get();
                    // $user->mahasiswa->tahun_ajaran()->detach();
                    $sync_ta = [];
                    foreach ($tas as $ta) {
                        $sync_ta[$ta['id']] = ['status' => 'Aktif'];
                    }
                    // $user->mahasiswa->tahun_ajaran()->attach($ta->id, ['status' => 'Aktif']);
                    $user->mahasiswa->tahun_ajaran()->sync($sync_ta);

                } catch (\Throwable $th) {
                    $user->delete();
                    $msg = 'Gagal menambahkan mahasiswa konversi. Error: '. $th->getMessage();
                    $status = 'FAIL';
                    dd($msg, $status, $request->all());
                }
            } catch (\Throwable $th) {
                $user->delete();
                $msg = 'Gagal menambahkan mahasiswa. Error: '. $th->getMessage();
                $status = 'FAIL';
                dd($msg, $status, $request->all());
            }
        } catch (\Throwable $th) {
            $msg = 'Gagal menambahkan data. Error: '. $th->getMessage();
            $status = 'FAIL';
            dd($msg, $status);
        }

        $header = ['status' => $status, 'msg' => $msg];
        if ($status != 'FAIL'){
            return redirect('master/mahasiswa-konversi')->with($header);
        }
        return redirect()->back()->with($header);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $mahasiswa = Mahasiswa::has('mahasiswa_konversi')
        ->where('npm','=',$id)
        ->with(['user','dosen','jurusan','tahun_ajaran','mahasiswa_konversi.matakuliah_konversis.matakuliah'])
        ->get()->first();

        $matakuliahs = $mahasiswa->mahasiswa_konversi->matakuliah_konversis;

        $dosens = Dosen::with('staff.user')->get();
        $jurusans = Jurusan::all();
        return Inertia::render('Master/Mahasiswa/Konversi/MahasiswaKonversiDetail',[
            'dosens' => $dosens,
            'jurusans' => $jurusans,
            'mahasiswa' => $mahasiswa,
            'matakuliahs' => $matakuliahs,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request['password'] = Hash::make('12345678');
        $msg = 'Berhasil menyimpan data';
        $status = 'OK';
        $key = '';
        $npm_dirty = false;
        try {
            $user = User::findOrFail($request->id);
            $user_old = $user->getOriginal();
            $user->update($request->all());
            try {
                $request['jurusan_id'] = $request['jurusan_id'] != '-' ? $request['jurusan_id']: null;
                $request['dosen_id'] = $request['dosen_id'] != '-' ? $request['dosen_id']: null;
                $mahasiswa_old = $user->mahasiswa->getOriginal();
                $key = array_keys($user->mahasiswa->toArray());
                // dd($mahasiswa_old['npm'], $request['npm']);

                $user->mahasiswa()->update($request->only($key));
                try {
                    if($mahasiswa_old['npm'] != $request['npm'])
                        // refresh model, karena npm berubah tidak terbaca
                        // dari model sebelumnya
                        $npm_dirty = true;
                        $user = User::findOrFail($request->id);
                        // dd($mahasiswa_old['npm'], $request['npm']);
                    $key = array_keys($user->mahasiswa->mahasiswa_konversi->toArray());
                    unset($key[0]);
                    $user->mahasiswa->mahasiswa_konversi()->update($request->only($key));

                    // Riwayat status mahasiswa - update
                    try {
                        $ta_mahasiswa = $user->mahasiswa->tahun_ajaran();
                        $updated_data_ta = [];
                        $request_ta = $request->tahun_ajaran;

                        foreach ($request_ta as $ta) {
                            $updated_data_ta[$ta['id']] = ['status' => $ta['pivot']['status']];
                        }

                        // dd($updated_data_ta);
                        $ta_mahasiswa->sync($updated_data_ta, false);

                    } catch (\Throwable $th) {
                        // throw $th;
                        dd($th->getMessage());
                    }

                } catch (\Throwable $th) {
                    $user->update($user_old);
                    $user->mahasiswa()->update($mahasiswa_old);
                    $msg = 'Gagal menyimpan data mahasiswa konversi. Error: '. $th->getMessage();
                    $status = 'FAIL';
                    dd($status, $msg);
                }

            } catch (\Throwable $th) {
                $user->update($user_old);
                $msg = 'Gagal menyimpan data mahasiswa. Error: '. $th->getMessage();
                $status = 'FAIL';
                dd($status, $msg);
            }
        } catch (\Throwable $th) {
            // dd($status, $msg);
            $msg = 'Gagal menyimpan data user. Error: '. $th->getMessage();
            $status = 'FAIL';
            dd($msg, $status);
        }

        $header = ['status' => $status, 'msg' => $msg];
        // if ($status != 'FAIL'){
            // return redirect('master/mahasiswa-konversi')->with($header);
        return redirect()->route('master.mahasiswa-konversi.edit', $request['npm'])->with($header);
        // }
        // if(!$npm_dirty){
        //     return redirect()->back()->with($header);
        // }
        // return redirect()->route('master.mahasiswa-konversi.show', $request['npm'])
        //     ->with($header);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $mahasiswa = Mahasiswa::where('npm','=',$id)->first();

        $nama = $mahasiswa->user->nama;
        $npm = $mahasiswa->npm;
        $msg = "Berhasil menghapus mahasiswa konversi. Data: $nama $npm";
        $status = 'OK';
        // Hapus riwayat kuliah mahasiswa
        try {
            $res = $mahasiswa->tahun_ajaran()->detach();
        } catch (\Throwable $th) {
            //throw $th;
            dd('Gagal menghapus data TA'. $th->getMessage(), $th);
        }

        try {
            $delete = $mahasiswa->user()->delete();
        } catch (\Throwable $th) {
            $status = 'FAIL';
            $msg = `Gagal menghapus mahasiswa konversi. Data: $nama $npm. Error: `.$th->getMessage();
            dd($msg, $th);
        }

        $header = ['status' => $status, 'msg' => $msg];
        if ($status != 'FAIL'){
            return redirect('master/mahasiswa-konversi')->with($header);
        }
        return redirect()->back()->with($header);
    }
}
