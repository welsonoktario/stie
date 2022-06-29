<?php

namespace App\Http\Controllers\Transaksi\KRS;

use Inertia\Inertia;
use App\Models\Mahasiswa;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\Matakuliah;
use SebastianBergmann\CodeUnit\FunctionUnit;

class KRSController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        $tahun_ajarans = TahunAjaran::orderBy('tanggal_mulai','desc')->get();
        $ta = in_array($request->ta, [null, ''])
            ? strval(($tahun_ajarans->firstWhere('aktif', '=', true))->id) : $request->ta;

        $mahasiswas = Mahasiswa::select([
            'mahasiswas.npm',
            'mahasiswas.status_mahasiswa',
            'users.name as nama',
            'jurusans.nama as jurusan',
            'status_mahasiswa.status as status',
            'status_mahasiswa.tanggal_cicilan_1 as cicilan_1',
            'status_mahasiswa.tanggal_cicilan_2 as cicilan_2',
            'status_mahasiswa.tanggal_cicilan_3 as cicilan_3'
        ])
            // ->doesntHave('mahasiswa_konversi')
            ->join('users', 'users.id', '=', 'mahasiswas.user_id')
            ->leftJoin('jurusans', 'jurusans.id', '=', 'mahasiswas.jurusan_id')
            ->filter($request->only(['query', 'orderBy', 'orderType']))
            ->when($ta ?? null, function ($query, $ta) {
                return $query->join('status_mahasiswa', 'mahasiswas.npm', '=', 'mahasiswa_npm')
                    ->where('tahun_ajaran', '=', $ta);
            })
            ->paginate($request->get('perPage') ?: 10)
            ->withQueryString();

        // dd('wow');
        return Inertia::render('Transaksi/KRS/KRS.vue', [
            'mahasiswas' => $mahasiswas,
            'tahun_ajarans' => $tahun_ajarans,
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
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
     * @return \Inertia\Response
     */
    public function edit($id, Request $request)
    {
        if (!isset($request['ta'])) {
            return redirect()->route('transaksi.krs.index');
        }

        $filters = $request->only(['query', 'orderBy', 'orderType']);
        // cari mahasiswa ada atau engga
        $taken = DB::table('status_mahasiswa')
            ->where('mahasiswa_npm', '=', $id)
            ->where('tahun_ajaran', '=', $request['ta'])->get()->count();

        if (!($taken > 0)) {
            return redirect()->route('transaksi.keuangan.index');
        }

        $mahasiswa = Mahasiswa::with(['user', 'tahun_ajaran'])
            ->find($id);
        $jadwal_mhs = Mahasiswa::where('npm', '=', $id)
            ->select(
                'mahasiswas.npm as npm',
                'matakuliahs.kode_matakuliah as kode_matakuliah',
                'matakuliahs.nama_matakuliah as nama_matakuliah',
                'matakuliahs.sks as sks',
                'matakuliahs.tipe as tipe',
                'jadwals.local as lokal',
                'jadwals.hari as hari',
                'jadwals.jam as jam',
                'jadwals.id as jadwal_id',
                'ruangans.nama_ruangan as ruangan',
            )
            ->join('jadwal_mahasiswa', 'jadwal_mahasiswa.mahasiswa_npm', '=', 'mahasiswas.npm')
            ->join('jadwals', 'jadwals.id', '=', 'jadwal_mahasiswa.jadwal_id')
            ->join('matakuliahs', 'matakuliahs.id', '=', 'jadwals.matakuliah_id')
            ->join('ruangans', 'ruangans.id', '=', 'jadwals.ruangan_id')
            ->where('jadwals.tahun_ajaran_id', '=', $request['ta'])
            ->when($filters['query'] ?? null, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('kode_matakuliah', 'LIKE', "%$search%")
                        ->orWhere('nama_matakuliah', 'LIKE', "%$search%");
                });
            })->when($filters['orderBy'] ?? null, function ($query, $orderBy) use (&$filters) {
                $query->orderBy($orderBy, $filters['orderType']);
            });
        // $sksDiambil = 0;
        $sksDiambil = $jadwal_mhs->sum("matakuliahs.sks");
        // dd($sksDiambil);
        $jadwal_mhs = $jadwal_mhs
            // ->get()
            ->paginate($request->get('perPage') ?: 20);
        // dd($jadwal_mhs);
        // dd($sksSebelumnya = );

        $jadwals = Jadwal::where('tahun_ajaran_id', '=', $request['ta'])
            // ->join('matakuliahs', 'matakuliahs.id', 'jadwals.id')
            ->with(['matakuliah'])
            // ->orderBy('matakuliahs.semester','asc')
            ->get();

        $tahunAjaran = TahunAjaran::find($request['ta']);
        // $ipsSebelumnya = TahunAjaran::firstWhere('tanggal_mulai', '<', $tahunAjaran->tanggal_mulai);

        $ipsSebelumnya = $mahasiswa->tahun_ajaran->firstWhere('tanggal_mulai', '<', $tahunAjaran->tanggal_mulai);
        // dd($ipsSebelumnya);
        // $res = array();
        if ($ipsSebelumnya) {
            $ipsSebelumnya = $this->calcIP($mahasiswa->npm, $ipsSebelumnya->id);
            // $ipsSebelumnya = $res[0];
            // $sksDiambil
        }
        else {
            $ipsSebelumnya = "Baru";
        }


        // if ()

        return Inertia::render('Transaksi/KRS/KRSDetail.vue', [
            'mahasiswa' => $mahasiswa,
            'jadwals' => $jadwals,
            'jadwalMahasiswa' => $jadwal_mhs,
            'ipsSebelumnya' => $ipsSebelumnya,
            'sksDiambil' => $sksDiambil,
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
        // dd('bisa', $id);
        if (!isset($request['jadwal_id'])) {
            return redirect()->back();
        }

        $ta = $request['ta'];
        // $mahasiswa = Mahasiswa::with('tahun_ajarans')->where("npm","=",$id)->get();

        $mahasiswa = Mahasiswa::with(['tahun_ajaran' => function ($query) use ($ta) {
            return $query->where('id', '=', $ta);
        }, 'jadwals' => function($query) use ($ta) {
            return $query->where('tahun_ajaran_id', '=', $ta);
        }])->findOrFail($id);
        $jadwal = Jadwal::find($request['jadwal_id']);
        // dd($mahasiswa, $jadwal);

        // dd(count($mahasiswa->jadwals));


        $mahasiswa->tahun_ajaran()->sync([$ta => ['status' => 'Aktif']], false);
        // dd($mahasiswa);


        try {
            $mahasiswa->jadwals()->sync($jadwal->id, false);
        } catch (\Throwable $th) {
            //throw $th;
            dd($th->getMessage());
        }
        return redirect()
            ->route('transaksi.krs.edit', ['kr' => $mahasiswa->npm, 'ta' => $ta])
            ->with(['status' => 'OK', 'msg' => 'Berhasil menambah jadwal mahasiswa']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        //
        $ta = $request->ta;
        $mahasiswa = Mahasiswa::with(['tahun_ajaran' => function ($query) use ($ta) {
            return $query->where('id', '=', $ta);
        }, 'jadwals' => function($query) use ($ta) {
            return $query->where('tahun_ajaran_id', '=', $ta);
        }])->findOrFail($id);
        $jadwal = Jadwal::find($request['jadwal_id']);

        // dd($mahasiswa, $jadwal, $request['jadwal_id']);

        // $route = route('transaksi.krs.edit', ['kr' => $mahasiswa->npm, 'ta' =>$jadwal->tahun_ajaran_id]);
        // dd($route);

        try {
            $mahasiswa->jadwals()->detach($jadwal->id);
        } catch (\Throwable $th) {
            //throw $th;
            dd($th->getMessage());
        }

        // dd(count($mahasiswa->jadwals) - 1);
        if (!(count($mahasiswa->jadwals) - 1)) {
            $mahasiswa->tahun_ajaran()->sync([$ta => ['status' => 'Tidak Aktif']], false);
        }

        return redirect()
            ->route('transaksi.krs.edit', ['kr' => $mahasiswa->npm, 'ta' => $jadwal->tahun_ajaran_id])
            ->with(['status' => 'OK', 'msg' => 'Berhasil menambah jadwal mahasiswa']);
    }

    public function copy(Request $request, Mahasiswa $mahasiswa)
    {
        // dd($request->npm_salin, $request->tahun_ajaran, $mahasiswa);

        // $mahasiswa_salin = Mahasiswa::where("npm","=",$request->npm_salin)->first();
        $mahasiswa_salin = Mahasiswa::findOrFail($request->npm_salin);

        // $jadwals = $mahasiswa_salin->inner("jadwals")->get();

        // $jadwals = Jadwal::where("tahun_ajaran_id", "=", $request->tahun_ajaran)->get();
        // dd($mahasiswa_salin->jadwals);

        $jadwals = $mahasiswa_salin->jadwals;

        $jadwal_ids = array();
        $jadwal_names = array();
        foreach ($jadwals as $jadwal) {
            if ($jadwal->tahun_ajaran_id == $request->tahun_ajaran) {
                $jadwal_ids[] = $jadwal->id;
                $jadwal_names[] = $jadwal->matakuliah->nama_matakuliah;
            }
        }

        // dd($jadwal_ids, $jadwal_names);
        // sync matakuliah
        $mahasiswa->jadwals()->sync($jadwal_ids, false);

        // jadikan status aktif jika ada matkulnya
        if ((count($mahasiswa->jadwals))) {
            $mahasiswa->tahun_ajaran()->sync([$request->tahun_ajaran => ['status' => 'Aktif']], false);
        }

        return redirect()
            ->route('transaksi.krs.edit', ['kr' => $mahasiswa->npm, 'ta' => $request->tahun_ajaran])
            ->with(['status' => 'OK', 'msg' => 'Berhasil menyalin matakuliah mahasiswa ' . $request->npm_salin]);
    }



    private function calcIP($mhs, $ta)
    {
        $mahasiswa = Mahasiswa::query()
            ->with(['jadwals' => function ($q) use ($ta) {
                return $q->where('tahun_ajaran_id', $ta);
            }])
            ->find($mhs);

        // hitung ip smt lalu
        $totalSks = 0;
        $nisbiSks = 0;
        $angkaMutu = [
            'A' => 4,
            'B' => 3,
            'C' => 2,
            'D' => 1,
            'E' => 0,
            null => 0,
        ];

        foreach ($mahasiswa->jadwals as $jadwal) {
            $sks = $jadwal->matakuliah->sks;
            $totalSks = $totalSks + $sks;
            $nisbiSks = $nisbiSks + ($angkaMutu[$jadwal->pivot->nisbi] * $sks);
        }
        // dd($totalSks, $nisbiSks, $nisbiSks/$totalSks);
        if ($totalSks == 0) {
            return 0;
        }
        return [$nisbiSks/$totalSks, $totalSks];
        // dd($mahasiswa->toJson());
    }


}
