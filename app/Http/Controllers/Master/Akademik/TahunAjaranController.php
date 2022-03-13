<?php

namespace App\Http\Controllers\Master\Akademik;

use App\Http\Controllers\Controller;
use App\Models\TahunAjaran;
use App\Http\Requests\Master\Akademik\TahunAjaran\StoreTahunAjaranRequest;
use App\Http\Requests\Master\Akademik\TahunAjaran\UpdateTahunAjaranRequest;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

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
        // dd('disini');
        // dd($request->toArray());
        $tahunAjaran = TahunAjaran::create($request->validated());

        return redirect()
            ->route('master.tahun-ajaran.index')
            ->with(
                [
                    'status' => 'OK',
                    'msg' => "Tahun ajaran {$tahunAjaran->tahun_ajaran} berhasil ditambahkan"
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
            ['tahunAjaran' => $tahunAjaran]
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
        $tahunAjaran->update($request->validated());
        // dd($tahunAjaran);
        return redirect()
            ->route('master.tahun-ajaran.index')
            ->with(
                [
                    'status' => 'OK',
                    'msg' => "Tahun ajaran {$tahunAjaran->tahun_ajaran} berhasil diperbarui"
                ]
            );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TahunAjaran  $tahunAjaran
     * @return \Illuminate\Http\Response
     */
    public function destroy(TahunAjaran $tahunAjaran)
    {
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

        return redirect()
            ->route('master.tahun-ajaran.index')
            ->with(
                [
                    'status' => 'OK',
                    'msg' => "Tahun ajaran {$tahunAjaran->tahun_ajaran} berhasil dihapus"
                ]
            );
    }
}
