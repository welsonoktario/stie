<?php

namespace App\Http\Controllers\Master\Mahasiswa;

use Inertia\Inertia;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\Jurusan;
use App\Models\User;
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
                // $mahasiswa
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
        $mahasiswa = Mahasiswa::where('npm','=',$id)->with(['dosen','jurusan','user'])->first();
        $dosens = Dosen::with('staff.user')->get();
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
        try {
            $delete = $mahasiswa->user()->delete();
        } catch (\Throwable $th) {
            $status = 'FAIL';
            $msg = `Gagal menghapus mahasiswa. Data: $nama $npm. Error: $th->getMessage()`;
        }

        $header = ['status' => $status, 'msg' => $msg];
        if ($status != 'FAIL'){
            return redirect('master/mahasiswa-reguler')->with($header);
        }
        return redirect()->back()->with($header);
    }
}
