<?php

namespace App\Http\Controllers\Master\Akademik;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\Akademik\Kurikulum\StoreKurikulumRequest;
use App\Http\Requests\Master\Akademik\Kurikulum\UpdateKurikulumRequest;
use App\Models\Kurikulum;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class KurikulumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kurikulums = Kurikulum::filter(Request::only(['query', 'orderBy', 'orderType']))
            ->paginate(Request::get('perPage') ?: 10)
            ->withQueryString();

        return Inertia::render(
            'Master/Akademik/Kurikulum/AkademikKurikulum.vue',
            ['kurikulums' => $kurikulums]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Master/Akademik/Kurikulum/AkademikKurikulumDetail.vue');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Master\Akademik\Kurikulum\StoreKurikulumRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreKurikulumRequest $request)
    {
        $kurikulum = Kurikulum::create($request->validated());

        return redirect()
            ->route('master.kurikulum.index')
            ->with(
                [
                    'status' => 'OK',
                    'msg' => "Kurikulum {$kurikulum->nama} berhasil ditambahkan"
                ]
            );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kurikulum  $kurikulum
     * @return \Illuminate\Http\Response
     */
    public function edit(Kurikulum $kurikulum)
    {
        return Inertia::render(
            'Master/Akademik/Kurikulum/AkademikKurikulumDetail.vue',
            ['kurikulum' => $kurikulum]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Master\Akademik\Kurikulum\UpdateKurikulumRequest  $request
     * @param  \App\Models\Kurikulum  $kurikulum
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateKurikulumRequest $request, Kurikulum $kurikulum)
    {
        $kurikulum->update($request->validated());

        return redirect()
            ->route('master.kurikulum.index')
            ->with(
                [
                    'status' => 'OK',
                    'msg' => "Kurikulum {$kurikulum->nama} berhasil diperbarui"
                ]
            );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kurikulum  $kurikulum
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kurikulum $kurikulum)
    {
        if (!$kurikulum->delete()) {
            return redirect()
                ->route('master.kurikulum.index')
                ->with(
                    [
                        'status' => 'FAIL',
                        'msg' => "Terjadi kesalahan menghapus Kurikulum {$kurikulum->nama}"
                    ]
                );
        }

        return redirect()
            ->route('master.kurikulum.index')
            ->with(
                [
                    'status' => 'OK',
                    'msg' => "Kurikulum {$kurikulum->nama} berhasil dihapus"
                ]
            );
    }

    public function loadPrasyarats(Kurikulum $kurikulum)
    {
        Log::debug(json_encode($kurikulum));
        $kurikulum->load('matakuliahs');

        return response()->json(['matakuliahs' => $kurikulum->matakuliahs]);
    }
}
