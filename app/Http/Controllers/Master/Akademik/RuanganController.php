<?php

namespace App\Http\Controllers\Master\Akademik;

use App\Http\Controllers\Controller;
use App\Models\Ruangan;
use App\Http\Requests\Master\Akademik\Ruangan\StoreRuanganRequest;
use App\Http\Requests\Master\Akademik\Ruangan\UpdateRuanganRequest;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class RuanganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ruangans = Ruangan::filter(Request::only(['query', 'orderBy', 'orderType']))
            ->paginate(Request::get('perPage') ?: 10)
            ->withQueryString();

        return Inertia::render(
            'Master/Akademik/Ruangan/AkademikRuangan',
            ['ruangans' => $ruangans]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Master/Akademik/Ruangan/AkademikRuanganDetail');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Master\Akademik\Ruangan\StoreRuanganRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRuanganRequest $request)
    {
        $ruangan = Ruangan::create($request->validated());

        return redirect()
            ->route('master.ruangan.index')
            ->with(
                [
                    'status' => 'OK',
                    'msg' => "Ruangan {$ruangan->nama} berhasil ditambahkan"
                ]
            );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ruangan  $ruangan
     * @return \Illuminate\Http\Response
     */
    public function edit(Ruangan $ruangan)
    {
        return Inertia::render(
            'Master/Akademik/Ruangan/AkademikRuanganDetail',
            ['ruangan' => $ruangan]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Master\Akademik\Ruangan\UpdateRuanganRequest  $request
     * @param  \App\Models\Ruangan  $ruangan
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRuanganRequest $request, Ruangan $ruangan)
    {
        $ruangan->update($request->validated());

        return redirect()
            ->route('master.ruangan.index')
            ->with(
                [
                    'status' => 'OK',
                    'msg' => "Ruangan {$ruangan->nama} berhasil diperbarui"
                ]
            );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ruangan  $ruangan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ruangan $ruangan)
    {
        if (!$ruangan->delete()) {
            return redirect()
                ->route('master.ruangan.index')
                ->with(
                    [
                        'status' => 'FAIL',
                        'msg' => "Terjadi kesalahan menghapus ruangan {$ruangan->nama}"
                    ]
                );
        }

        return redirect()
            ->route('master.ruangan.index')
            ->with(
                [
                    'status' => 'OK',
                    'msg' => "Ruangan {$ruangan->nama} berhasil dihapus"
                ]
            );
    }
}
