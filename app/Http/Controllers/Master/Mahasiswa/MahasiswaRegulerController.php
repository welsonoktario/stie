<?php

namespace App\Http\Controllers\Master\Mahasiswa;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Dosen;
use App\Models\Jurusan;
use App\Models\Mahasiswa;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class MahasiswaRegulerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $mahasiswas = Mahasiswa::select(['mahasiswas.npm','mahasiswas.status_mahasiswa','users.name as nama','jurusans.nama as jurusan'])
            ->doesntHave('mahasiswa_konversi')
            ->join('users','users.id','=','mahasiswas.user_id')
            ->leftJoin('jurusans','jurusans.id','=','mahasiswas.jurusan_id')
            ->filter($request->only(['query', 'orderBy', 'orderType']))
            ->paginate($request->get('perPage') ?: 10)
            ->withQueryString();
            // ->withQueryString();
        // ->with(['user','jurusan'])->get();

        // dd($mahasiswas);
        return Inertia::render('Master/Mahasiswa/Reguler/MahasiswaReguler',[
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
        //
        $dosens = Dosen::with('staff.user')->get();
        $jurusans = Jurusan::all();
        $tahun_ajaran = TahunAjaran::where('aktif','=',1)->get();
        return Inertia::render('Master/Mahasiswa/Reguler/MahasiswaRegulerDetail',[
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
        // dd('g dl');
        $request['password'] = Hash::make('12345678');
        $request['jurusan_id'] = $request['jurusan_id'] != '-' ? $request['jurusan_id']: null;
        $request['dosen_id'] = $request['dosen_id'] != '-' ? $request['dosen_id']: null;
        $msg = 'Berhasil menambahkan data';
        $status = 'OK';

        try {
            $user = User::create($request->all());
            try {
                $user->mahasiswa()->create($request->all());

                // assign ke tahun akademik (dari tanggal masuk sampai thn terakhir)
                $tm = $request['tanggal_masuk'];
                $tas = TahunAjaran::where('tanggal_selesai', '>', $tm)->get();
                $user->mahasiswa->tahun_ajaran()->detach();
                foreach ($tas as $ta) {
                    $user->mahasiswa->tahun_ajaran()->attach($ta->id, ['status' => 'Aktif']);
                }
            } catch (\Throwable $th) {
                $user->delete();
                $msg = 'Gagal menambahkan data. Error: '. $th->getMessage();
                $status = 'FAIL';
                dd($msg, $status, $request->all());
            }
        } catch (\Throwable $th) {
            $msg = 'Gagal menambahkan data. Error: '. $th->getMessage();
            $status = 'FAIL';
            dd($msg, $status);
        }

        // dd($user->mahasiswa->tahun_ajaran(), $msg);
        $header = ['status' => $status, 'msg' => $msg];
        if ($status != 'FAIL'){
            return redirect('master/mahasiswa-reguler')->with($header);
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
        //
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
        $mahasiswa = Mahasiswa::with(['dosen','jurusan','user', 'tahun_ajaran'])->firstWhere('npm','=',$id);
        $dosens = Dosen::whereHas('staff.user', function ($q) {
            return $q->where([
                ['level_pengguna', 'Staff'],
                ['divisi', 'Dosen']
            ]);
        })->with(['staff.user'])->get();
        $jurusans = Jurusan::all();
        // dd($mahasiswa);
        return Inertia::render('Master/Mahasiswa/Reguler/MahasiswaRegulerDetail',[
            'dosens' => $dosens,
            'jurusans' => $jurusans,
            'mahasiswa' => $mahasiswa,
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
        // dd($request['tahun_ajaran']);
        $request['password'] = Hash::make('12345678');
        $msg = 'Berhasil menambahkan data';
        $status = 'OK';
        $key = '';
        try {
            $user = User::findOrFail($request->id);
            $user_old = $user->getOriginal();
            $user->update($request->all());
            try {
                $request['jurusan_id'] = $request['jurusan_id'] != '-' ? $request['jurusan_id']: null;
                $request['dosen_id'] = $request['dosen_id'] != '-' ? $request['dosen_id']: null;
                $key = array_keys($user->mahasiswa->toArray());
                $user->mahasiswa()->update($request->only($key));
                // Riwayat Status Mahasiswa
                try {
                    $ta_mahasiswa = $user->mahasiswa->tahun_ajaran();
                    $updated_data_ta = [];
                    $request_ta = $request->tahun_ajaran;

                    // dd($request_ta);
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
                $msg = 'Gagal menambahkan data mahasiswa. Error: '. $th->getMessage();
                $status = 'FAIL';
            }
        } catch (\Throwable $th) {
            $msg = 'Gagal menambahkan data user. Error: '. $th->getMessage();
            $status = 'FAIL';
            dd($msg, $status);
        }

        $header = ['status' => $status, 'msg' => $msg];
        if ($status != 'FAIL'){
            return redirect('master/mahasiswa-reguler')->with($header);
        }
        return redirect()->back()->with($header);
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
        $msg = "Berhasil menghapus mahasiswa. Data: $nama $npm";
        $status = 'OK';
        // Hapus tahun Ajaran
        try {
            $delete = $mahasiswa->tahun_ajaran()->detach();
        }
        catch (\Throwable $th) {
            $status = 'FAIL';
            $msg = `Gagal menghapus tahun ajaran. Data: $nama $npm. Error: `.$th->getMessage();
            dd($msg, $th);
        }
        
        try {
            $delete = $mahasiswa->user()->delete();
        } catch (\Throwable $th) {
            $status = 'FAIL';
            $msg = `Gagal menghapus mahasiswa. Data: $nama $npm. Error: `.$th->getMessage();
            dd($msg, $th);
        }

        $header = ['status' => $status, 'msg' => $msg];
        if ($status != 'FAIL'){
            return redirect('master/mahasiswa-reguler')->with($header);
        }
        return redirect()->back()->with($header);
    }
}
