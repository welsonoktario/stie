<?php

namespace App\Http\Controllers\Master\Karyawan;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Dosen;
use App\Models\Staff;
use App\Models\Jurusan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class DosenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dosens = Dosen::index()
            ->with(['staff.user', 'jurusan'])
            ->filter(request()->only(['query', 'orderBy', 'orderType']))
            ->paginate(request()->get('perPage') ?: 10)
            ->withQueryString();

        // dd($dosens);

        // dd(Dosen::index()->get());
        return Inertia::render('Master/Karyawan/Dosen/KaryawanDosen', [
            'dosens' => $dosens
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $jurusans = Jurusan::all();
        return Inertia::render('Master/Karyawan/Dosen/KaryawanDosenDetail', [
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
        $this->saveDosenHandler($request, 'store');

        return redirect()->route('master.dosen.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $dosen = Dosen::where('id', '=', $id)->with(['staff.user', 'jurusan'])->get()->first();
        $jurusans = Jurusan::all();

        return Inertia::render('Master/Karyawan/Dosen/KaryawanDosenDetail', [
            'dosen' => $dosen,
            'jurusans' => $jurusans
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
        //

        $this->saveDosenHandler($request, 'update', $id);

        return redirect()->route('master.dosen.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $dosen = Dosen::findOrFail($id);

        $dosen->delete();

        $dosen->staff->delete();

        $dosen->staff->user->delete();

        return redirect()->route('master.dosen.index');
    }

    public function saveDosenHandler(Request $request, $mode = 'store', $id = null)
    {

        // Data User
        $email = $request->email;
        $name = $request->name;
        $nik = $request->nik;

        // Data Karyawan
        $id_karyawan = $request->id_karyawan;

        // Data Dosen
        $id_dosen = $request->id_dosen;
        $tipe_id = $request->tipe_id;
        $jabatan_akademik = $request->jabatan_akademik;
        $konsentrasi = $request->konsentrasi;

        // Jurusan dosen
        $jurusan = null;
        if ($request->jurusan != '-')
            $jurusan = Jurusan::findOrFail($request->jurusan);

        // Find Dosen untuk update
        if ($mode == 'update')
            $dosen = Dosen::findOrFail($id);

        // Insert / Update User
        if ($mode == 'store')
            $user = new User();
        else if ($mode == 'update')
            $user = $dosen->staff->user;
        $user->email = $email;
        $user->name = $name;
        $user->nik = $nik;
        $user->password = Hash::make('12345678');
        $user_save = $user->save();
        if (!$user_save) {
            return dd('Gagal menyimpan user');
        }

        // Insert / Update Staff
        if ($mode == 'store')
            $staff = new Staff();
        else if ($mode == 'update')
            $staff = $dosen->staff;

        $staff->id = $id_karyawan;
        $staff->user()->associate($user);
        $staff_save = $staff->save();
        if (!$staff_save) {
            $user->delete();
            return dd('Gagal menyimpan staff');
        }

        // Insert / Update Dosen
        if ($mode == 'store')
            $dosen = new Dosen();
        // else if ($mode == 'update')
        //     $dosen = Dosen::find($id);
        $dosen->id = $id_dosen;
        $dosen->tipe_id = $tipe_id;
        $dosen->jabatan_akademik = $jabatan_akademik;
        $dosen->konsentrasi = $konsentrasi;
        $dosen->staff()->associate($staff);
        if ($jurusan != null)
            $dosen->jurusan()->associate($jurusan);
        $dosen_save = $dosen->save();

        if (!$dosen_save) {
            $staff->delete();
            $user->delete();
            return dd('gagal menyimpan dosen');
        }

        return true;
    }
}
