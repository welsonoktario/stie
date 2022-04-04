<?php

namespace App\Http\Controllers\Master\Karyawan;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Staff;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Throwable;

class KaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $karyawans = User::has('staff')->with(['staff' => function($query){
        //     $query->doesntHave('dosen');
        // }])->get();

        // $karyawans = Staff::doesntHave('dosen')->with(['user' => function($query){
        //     $query->select(['user.id','user.name']);
        // }])
        // ->select(['nip','divisi','level_pengguna','user_id','name'])
        // ->get()
        // ->toArray();
        // dd($karyawans);

        $karyawans = Staff::index()
            ->doesntHave('dosen')
            ->with(['user'])
            ->filter(request()->only(['query', 'orderBy', 'orderType']))
            ->orderBy('created_at', 'DESC')
            ->paginate(request()->get('perPage') ?: 10)
            ->withQueryString();

        return Inertia::render('Master/Karyawan/Karyawan/KaryawanKaryawan', [
            'karyawans' => $karyawans
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
        return Inertia::render('Master/Karyawan/Karyawan/KaryawanKaryawanDetail');
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
        $msg = 'Berhasil menambahkan data';
        $status = 'OK';
        try {
            $user = User::create($request->except(['id']));
            try {
                $user->staff()->create($request->all());
                if (!in_array($request->get('nitk'), [null, ""])) {
                    $user->staff->tenaga_kependidikan()->create([
                        'id' => $request->get('nitk')
                    ]);
                }
            } catch (\Throwable $th) {
                $msg = 'Gagal menambahkan data karyawan. Error: '.$th->getMessage();
                $user->delete();
                $status = 'FAIL';
                dd($msg, $th);
            }
        } catch (\Throwable $th) {
            // $user->delete();
            $status = 'FAIL';
            $msg = 'Gagal menambahkan data user. Error '.$th->getMessage();
            dd($msg, $th);

        }


        $header = ['status' => $status, 'msg' => $msg];
        if ($status != 'FAIL'){
            return redirect('master/karyawan')->with($header);
        }
        return redirect()->back()->with($header);


        // $name = $request->name;
        // $email = $request->email;
        // $nik = $request->nik;
        // $id = $request->id;


        // $user = new User();
        // $user->name = $name;
        // $user->email = $email;
        // $user->nik = $nik;
        // $user->password = Hash::make('12345678');
        // $user_completed = $user->save();

        // if ($user_completed) {
        //     $karyawan = new Staff;
        //     $karyawan->id = $id;
        //     $karyawan->user()->associate($user);
        //     $karyawan_completed = $karyawan->save();
        //     if ($karyawan_completed) {
        //         return redirect()->route('master.karyawan.index');
        //     }
        // }
        // $user->delete();
        // dd($name,$email,$nik,$status);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $staff = Staff::where('id', '=', $id)->with(['user','tenaga_kependidikan'])->get()->first();
        // dd($staff, $id);
        // dd($staff->tenaga_kependidikan->id);
        return Inertia::render('Master/Karyawan/Karyawan/KaryawanKaryawanDetail', [
            'staff' => $staff
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
        // $request['password'] = Hash::make('12345678');
        $msg = 'Berhasil menambahkan data';
        $status = 'OK';
        $nitk = $request->get('nitk');
        try {
            $staff = Staff::findOrFail($id);
            $user = User::findOrFail($staff->user_id);
            $user_old = $user->getOriginal();
            $user->update($request->all());
            try {
                $key = array_keys($user->staff->toArray());
                $staff_old = $user->staff->toArray();
                $user->staff()->update($request->only(($key)));

                if($staff_old['id'] != $request['id'])
                    $user = User::findOrFail($staff_old['user_id']);

                if(!in_array($nitk, [null, ""])){
                    try {
                        if($user->staff->tenaga_kependidikan == null){
                            $user->staff->tenaga_kependidikan()->create(
                                ['id' => $nitk]
                            );
                        }
                        $user->staff->tenaga_kependidikan()->update(
                            ['id' => $nitk]
                        );
                    } catch (\Throwable $th) {
                        $msg = 'Gagal menambahkan id tenaga kependidikan. Error: '.$th->getMessage();
                        $status = 'FAIL';

                        // dd('disini', $msg);
                        $user->update($user_old);
                        $user->staff()->update($staff_old);
                    }
                } else {
                    $user->staff->tenaga_kependidikan()->delete();
                }
            } catch (\Throwable $th) {
                $msg = 'Gagal menambahkan staff. Error: '.$th->getMessage();
                $status = 'FAIL';
                $user->update($user_old);
            }
        } catch (\Throwable $th) {
            $msg = 'Gagal menambahkan user. Error: '.$th->getMessage();
            $status = 'FAIL';
        }
        $header = ['status' => $status, 'msg' => $msg];
        // if ($status != 'FAIL'){
        //     return redirect('master/karyawan')->with($header);
        // }
        return redirect()->route('master.karyawan.edit',$request->id)->with($header);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // dd($id);
        // dd('wow');
        $staff = Staff::where('id', '=', $id)->firstOrFail();

        $staff->delete();
        $staff->user->delete();

        return redirect()->route('master.karyawan.index');
        // dd($staff);
    }
}
