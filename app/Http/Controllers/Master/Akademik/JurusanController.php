<?php

namespace App\Http\Controllers\Master\Akademik;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use App\Http\Requests\Master\Akademik\Jurusan\StoreJurusanRequest;
use App\Http\Requests\Master\Akademik\Jurusan\UpdateJurusanRequest;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class JurusanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jurusans = Jurusan::filter(Request::only(['query', 'orderBy', 'orderType']))
            ->paginate(Request::get('perPage') ?: 10)
            ->withQueryString();

        return Inertia::render(
            'Master/Akademik/Jurusan/AkademikJurusan',
            ['jurusans' => $jurusans]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Master/Akademik/Jurusan/AkademikJurusanDetail');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Master\Akademik\Jurusan\StoreJurusanRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreJurusanRequest $request)
    {
        $jurusan = Jurusan::create($request->validated());

        return redirect()
            ->route('master.jurusan.index')
            ->with(
                [
                    'status' => 'OK',
                    'msg' => "Jurusan {$jurusan->nama} berhasil ditambahkan"
                ]
            );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Jurusan  $jurusan
     * @return \Illuminate\Http\Response
     */
    public function edit(Jurusan $jurusan)
    {
        return Inertia::render(
            'Master/Akademik/Jurusan/AkademikJurusanDetail',
            ['jurusan' => $jurusan]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Master\Akademik\Jurusan\UpdateJurusanRequest  $request
     * @param  \App\Models\Jurusan  $jurusan
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateJurusanRequest $request, Jurusan $jurusan)
    {
        $jurusan->update($request->validated());

        return redirect()
            ->route('master.jurusan.index')
            ->with(
                [
                    'status' => 'OK',
                    'msg' => "Jurusan {$jurusan->nama} berhasil diperbarui"
                ]
            );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Jurusan  $jurusan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Jurusan $jurusan)
    {
        if (!$jurusan->delete()) {
            return redirect()
                ->route('master.jurusan.index')
                ->with(
                    [
                        'status' => 'FAIL',
                        'msg' => "Terjadi kesalahan menghapus jurusan {$jurusan->nama}"
                    ]
                );
        }

        return redirect()
            ->route('master.jurusan.index')
            ->with(
                [
                    'status' => 'OK',
                    'msg' => "Jurusan {$jurusan->nama} berhasil dihapus"
                ]
            );
    }
}
