<?php

namespace App\Http\Controllers\Master\Akademik;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\Akademik\StoreMatakuliahRequest;
use App\Http\Requests\Master\Akademik\UpdateMatakuliahRequest;
use App\Models\Kurikulum;
use App\Models\Matakuliah;
use Inertia\Inertia;

class MatakuliahController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $matakuliahs = Matakuliah::all();

        return Inertia::render(
            'Master/Akademik/Matakuliah/Index',
            ['matakuliahs' => $matakuliahs]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kurikulums = Kurikulum::all();

        return Inertia::render(
            'Master/Akademik/Matakuliah/Create',
            ['kurikulums' => $kurikulums]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Master\Akademik\StoreMatakuliahRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMatakuliahRequest $request)
    {
        $matakuliah = Matakuliah::create($request->validated());

        return redirect()
            ->route('master.matakuliah.index')
            ->with(
                [
                    'status' => 'OK',
                    'msg' => "Matakuliah {$matakuliah->nama_matakuliah} berhasil ditambahkan"
                ]
            );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Matakuliah  $matakuliah
     * @return \Illuminate\Http\Response
     */
    public function edit(Matakuliah $matakuliah)
    {
        $kurikulums = Kurikulum::all();

        return Inertia::render(
            'Master/Akademik/Matakuliah/Detail',
            [
                'matakuliah' => $matakuliah,
                'kurikulums' => $kurikulums
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Master\Akademik\UpdateMatakuliahRequest  $request
     * @param  \App\Models\Matakuliah  $matakuliah
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMatakuliahRequest $request, Matakuliah $matakuliah)
    {
        $matakuliah = Matakuliah::create($request->validated());

        return redirect()
            ->route('master.matakuliah.index')
            ->with(
                [
                    'status' => 'OK',
                    'msg' => "Matakuliah {$matakuliah->nama_matakuliah} berhasil ditambahkan"
                ]
            );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Matakuliah  $matakuliah
     * @return \Illuminate\Http\Response
     */
    public function destroy(Matakuliah $matakuliah)
    {
        if (!$matakuliah->delete()) {
            return redirect()
                ->route('master.matakuliah.index')
                ->with(
                    [
                        'status' => 'FAIL',
                        'msg' => "Terjadi kesalahan menghapus matakuliah {$matakuliah->nama_matakuliah}"
                    ]
                );
        }

        return redirect()
            ->route('master.matakuliah.index')
            ->with(
                [
                    'status' => 'OK',
                    'msg' => "Matakuliah {$matakuliah->nama_matakuliah} berhasil ditambahkan"
                ]
            );
    }
}
