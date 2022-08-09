<?php

namespace App\Http\Controllers\Master\Akademik;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\Akademik\Matakuliah\StoreMatakuliahRequest;
use App\Http\Requests\Master\Akademik\Matakuliah\UpdateMatakuliahRequest;
use App\Models\Jurusan;
use App\Models\Kurikulum;
use App\Models\Matakuliah;
use Illuminate\Support\Facades\Request;
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
        $matakuliahs = Matakuliah::index()
            ->filter(Request::only(['query', 'orderBy', 'orderType']))
            ->paginate(Request::get('perPage') ?: 10)
            ->withQueryString();

        return Inertia::render(
            'Master/Akademik/Matakuliah/AkademikMatakuliah',
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
        $jurusans = Jurusan::all();
        $kurikulums = Kurikulum::with(['matakuliahs'])->get();

        return Inertia::render(
            'Master/Akademik/Matakuliah/AkademikMatakuliahDetail',
            [
                'jurusans' => $jurusans,
                'kurikulums' => $kurikulums
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Master\Akademik\Matakuliah\StoreMatakuliahRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMatakuliahRequest $request)
    {
        $jurusan = $request->matakuliah_jurusan;
        $jurusan['jurusan_id'] = $jurusan['jurusan_id'] != '-' ? $jurusan['jurusan_id'] : null;
        $prasyarat = collect($request->prasyarats)->mapWithKeys(fn ($item, $key) => [
            $item['id'] => ['nilai_minimum' => $item['nilai_minimum']]
        ]);

        $matakuliah = Matakuliah::create($request->validated());
        $matakuliah->prasyarats()->sync($prasyarat);

        if ($jurusan['jurusan_id']) {
            $matakuliah->matakuliah_jurusan()->create([
                'jurusan_id' => $jurusan['jurusan_id']
            ]);
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Matakuliah  $matakuliah
     * @return \Illuminate\Http\Response
     */
    public function edit(Matakuliah $matakuliah)
    {
        $jurusans = Jurusan::all();
        $kurikulums = Kurikulum::with(['matakuliahs'])->get();
        $matakuliah->load(['matakuliah_jurusan', 'prasyarats']);

        return Inertia::render(
            'Master/Akademik/Matakuliah/AkademikMatakuliahDetail',
            [
                'jurusans' => $jurusans,
                'matakuliah' => $matakuliah,
                'kurikulums' => $kurikulums
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Master\Akademik\Matakuliah\UpdateMatakuliahRequest  $request
     * @param  \App\Models\Matakuliah  $matakuliah
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMatakuliahRequest $request, Matakuliah $matakuliah)
    {
        $jurusan = $request->matakuliah_jurusan;
        // dd($request->validated());
        // dd($jurusan['jurusan_id']);
        $jurusan['jurusan_id'] = $jurusan['jurusan_id'] != '-' ? $jurusan['jurusan_id'] : null;
        $prasyarat = collect($request->prasyarats)->mapWithKeys(fn ($item, $key) => [
            $item['id'] => ['nilai_minimum' => isset($item['pivot']) ? $item['pivot']['nilai_minimum'] : $item['nilai_minimum']]
        ]);

        $matakuliah->update($request->validated());
        $matakuliah->prasyarats()->sync($prasyarat);

        if ($jurusan['jurusan_id']) {
            if ($matakuliah->matakuliah_jurusan) {
                $matakuliah->matakuliah_jurusan()->update([
                    'jurusan_id' => $jurusan['jurusan_id']
                ]);
            } else {
                $matakuliah->matakuliah_jurusan()->create([
                    'jurusan_id' => $jurusan['jurusan_id']
                ]);
            }
        } else {
            if ($matakuliah->matakuliah_jurusan) {
                $matakuliah->matakuliah_jurusan()->delete();
            }
        }

        return redirect()
            ->route('master.matakuliah.index')
            ->with(
                [
                    'status' => 'OK',
                    'msg' => "Matakuliah {$matakuliah->nama_matakuliah} berhasil diperbarui"
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
                    'msg' => "Matakuliah {$matakuliah->nama_matakuliah} berhasil dihapus"
                ]
            );
    }
}
