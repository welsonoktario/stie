<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Inertia\Inertia;
use League\CommonMark\Parser\Block\SkipLinesStartingWithLettersParser;

class TranskripController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd('wow');
        //
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
     * @param  \App\Models\Mahasiswa  $mahasiswa
     * @return \Illuminate\Http\Response
     */
    public function show(Mahasiswa $mahasiswa)
    {
        //
        $selectedTahunAkademik = 0;
        $mahasiswa->load([
            'jadwals' => function ($q) use ($selectedTahunAkademik) {
                return $q->with(['matakuliah', 'tahun_ajaran'])->when($selectedTahunAkademik, function ($query, $selectedTahunAkademik) {
                    if ($selectedTahunAkademik == 'semua') {
                        return $query;
                    } else {
                        return $query->where('tahun_ajaran_id', (int) $selectedTahunAkademik);
                    }
                });
            },
            'user',
            'jurusan',
            'status_mahasiswa',
            // 'matakuliah_konversis.matakuliah'
        ]);

        // echo('Transkrip Mahasiswa (versi preview) <br><br>');
        // print("Nama: ".$mahasiswa->user->name. " <br> NPM: ". $mahasiswa->npm."<br><br>");

        // apakah mhs adalah mhs konversi?
        $matakuliah_konversis = $mahasiswa->mahasiswa_konversi()->with('matakuliah_konversis.matakuliah')->get();
        // dump();
        $ipk_konversi = 0;
        $total_sks_konversi = 0;
        $total_nilai_kali_sks_konversi = 0;
        if (count($matakuliah_konversis) > 0) {
            // echo("Daftar Konversi: <br>");
            // dd($matakuliah_konversis);
            foreach ($matakuliah_konversis[0]->matakuliah_konversis as $m) {
                // echo($m->matakuliah->kode_matakuliah. " - ".$m->matakuliah->nama_matakuliah. " - SKS: ". $m->matakuliah->sks. " - Nilai: ". $m->nilai_matakuliah ." <br>");
                $total_nilai_kali_sks_konversi += $m->nilai_matakuliah * $m->matakuliah->sks;
                $total_sks_konversi += $m->matakuliah->sks;
            }
            // dump('ya benar');
            // echo ('IP Matakuliah Diakui : '. $total_nilai_kali_sks_konversi/$total_sks_konversi."<br>");
        }
        if ($total_sks_konversi != 0){
            $ipk_konversi = $total_nilai_kali_sks_konversi/$total_sks_konversi;
        }

        $jadwals = $mahasiswa->jadwals->groupBy('matakuliah.kode_matakuliah')->all();
        // dd($jadwals);
        // dd($jadwals);

        $total_sks = 0;
        $total_nilai_kali_sks = 0;
        $ipk = 0;
        foreach ($jadwals as $kode_matakuliah => $jadwal) {
            // dd($jadwals);
            // dd($jadwal);
            $nilai = $jadwal->max("pivot.angka_mutu");
            // dd($nilai);
            $sks = $jadwal->max("matakuliah.sks");

            // echo ($kode_matakuliah."<br>");
            // dd($jadwal);
            foreach ($jadwal as $j) {
                // echo ($j->matakuliah->nama_matakuliah. " - SKS: " . $j->matakuliah->sks. " - Nilai: " . $j->pivot->angka_mutu."<br>");
            }
            $total_nilai_kali_sks += $nilai * $sks;
            $total_sks += $sks;

        }
        // dd(($total_nilai_kali_sks + $total_nilai_kali_sks_konversi) / ($total_sks + $total_sks_konversi));

        // dd($total_nilai_kali_sks);
        // echo('<br>IPK '. ($total_nilai_kali_sks +$total_nilai_kali_sks_konversi)/($total_sks + $total_sks_konversi));
        if (($total_sks + $total_sks_konversi) != 0) {
            $ipk = ($total_nilai_kali_sks +$total_nilai_kali_sks_konversi)/($total_sks + $total_sks_konversi);
        }



        /*
            Data yang digunakan

            // Data Mahasiswa
            $mahasiswa

            // Data jadwal yang diambil
            $jadwals ($kode_matakuliah => $jadwal (1 kode bisa memiliki lebih dari 1 jadwal karena ngulang))

            // IPK Konversi jika ada
            $total_nilai_kali_sks_konversi
            $total_sks_konversi
            $ipk_konversi

            // IPK Semua (plus dengan konversi jika ada)
            $total_nilai_kali_sks
            $total_sks
            $ipk

        */

        // return Inertia::render('Master/Akademik/JabatanStruktural/JabatanStruktural',[]);
        return Inertia::render('Transaksi/PrintView/PrintTranscript', compact(
            "mahasiswa",
            "matakuliah_konversis",
            "jadwals",
            "total_nilai_kali_sks_konversi",
            "total_sks_konversi",
            "ipk_konversi",
            "total_nilai_kali_sks",
            "total_sks",
            "ipk"));


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Mahasiswa  $mahasiswa
     * @return \Illuminate\Http\Response
     */
    public function edit(Mahasiswa $mahasiswa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Mahasiswa  $mahasiswa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mahasiswa $mahasiswa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Mahasiswa  $mahasiswa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mahasiswa $mahasiswa)
    {
        //
    }
}
