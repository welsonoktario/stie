<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Master\Mahasiswa\MahasiswaRegulerController;
use App\Models\Mahasiswa;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class TestingController extends Controller
{
    public function index()
    {
        // return Inertia::render('Transaksi/PrintView/PrintTranscript');
        $tas = TahunAjaran::all();

        foreach ($tas as $ta) {
            $mhss = $ta->mahasiswas;

            if (!$mhss) {
                continue;
            }

            foreach ($mhss as $mhs) {
                // dump($mhs);
                $jadwals = $mhs->jadwals()->where('tahun_ajaran_id', $ta->id)->get();

                // dump($jadwals);
                if (count($jadwals) == 0) {
                    $status = $mhs->status_mahasiswa();
                    // dump($status);
                    $status->sync([$ta->id => [
                        'status' => 'Tidak Aktif'
                    ]], false);
                } else {
                    $status = $mhs->status_mahasiswa();
                    // dump($status);
                    $status->sync([$ta->id => [
                        'status' => 'Aktif'
                    ]], false);
                }
            }
        }
    }

    //
    public function index2()
    {

        /*
        Sudah di Seed:
        2020
        - Manajemen
        - Ekonomi Pembangunan
        */

        // $mhs = Mahasiswa::first();
        // // $ta = TahunAjaran::all();

        // // ubah status
        // // $stat = $mhs->tahun_ajaran[0]->pivot->status = 'Tidak Aktif';
        // // $stat = $mhs->tahun_ajaran[0]->pivot->save();
        // // $stat = $mhs->tahun_ajaran;
        // // dd($stat);
        // // tambah TA saat tambah mhs

        // // $smt =
        // $tm = $mhs->tanggal_masuk;
        // // $ta = TahunAjaran::where('tanggal_mulai', '>=', $tm)->get();
        // $tas = TahunAjaran::where('tanggal_selesai', '>', $tm)->get();
        // $mhs->tahun_ajaran()->detach();
        // foreach ($tas as $ta) {
        //     $mhs->tahun_ajaran()->attach($ta->id, ['status' => 'Aktif']);
        // }
        // // dd($tas);
        // dd($mhs->tahun_ajaran);
        // // echo "tes";

        $mhscon = new MahasiswaRegulerController();



        // $mhs = [
        //     'npm'=>'120120',
        //     'name'=>'Coba hack',
        //     'agama'=>'kristen',
        //     'tanggal_masuk' => '2017-07-10'
        // ];
        // $req = new Request();
        // $req->replace($mhs);
        // $mhscon->store($req);

        // $file =
        $row = 0;
        $header = array();
        $mahasiswas = array();
        $mahasiswa_req = new Request();

        if (($handle = fopen(Storage::path("mahasiswa_ep_2021_clean.csv"), "r")) !== false) {
            while (($data = fgetcsv($handle, 1000, ",")) !== false) {
                $num = count($data);
                if ($row == 0) {
                    // $header = collect($data)->map(function($d) {return});
                    $header = $data;
                    $row++;
                    continue;
                }

                $mahasiswa = array_combine($header, $data);
                // if (($row) <= 160){
                //     // dd($mahasiswa);
                //     $row++;
                //     echo $mahasiswa['npm']." ".$mahasiswa['name']." - ".($row-1)."<br>";
                //     continue;
                // }
                $row++;

                if ($mahasiswa['jenis_kelamin'] == "") {
                    unset($mahasiswa['jenis_kelamin']);
                }
                if (isset($mahasiswa['agama'])) {
                    if ($mahasiswa['agama'] == "") {
                        unset($mahasiswa['agama']);
                    }
                    // if($mahasiswa['agama'] == "Katholik"){
                //     $mahasiswa['agama'] = 'Katolik';
                // }
                }
                // else {
                //     unset($mahasiswa['agama']);
                // }


                $mahasiswa_req->replace($mahasiswa);
                // $mhscon->store($mahasiswa_req);
                // dd($mahasiswa);
                echo $mahasiswa['npm']." ".$mahasiswa['name']." ".($row-1)."<br>";
            }
            fclose($handle);
        }
    }


    public function export2(TahunAjaran $ta)
    {
        $nilaiMahasiswas = DB::table('mahasiswas', 'm')
            ->select([
                DB::raw('m.npm'),
                DB::raw('users.name nama'),
                DB::raw('jurusans.nama departmen'),
                DB::raw('max(jadwal_mahasiswa.angka_mutu) angka_mutu'),
                DB::raw('jadwals.matakuliah_id matakuliah_id'),
                DB::raw('tahun_ajarans.tahun_ajaran tahun_ajaran'),
                DB::raw('matakuliahs.sks sks'),
                DB::raw('tahun_ajarans.tanggal_mulai tanggal_mulai')
            ])
            ->join('jadwal_mahasiswa', 'jadwal_mahasiswa.mahasiswa_npm', '=', 'm.npm')
            ->join('jadwals', 'jadwals.id', '=', 'jadwal_mahasiswa.jadwal_id')
            ->join('tahun_ajarans', 'tahun_ajarans.id', '=', 'jadwals.tahun_ajaran_id')
            ->join('matakuliahs', 'matakuliahs.id', '=', 'jadwals.matakuliah_id')
            ->join('jurusans', 'jurusans.id', '=', 'm.jurusan_id')
            ->join('users', 'users.id', '=', 'm.user_id')
            ->whereRaw("tahun_ajarans.tanggal_mulai <= '{$ta->tanggal_mulai}'")
            ->groupBy(['m.npm', 'jadwals.matakuliah_id'])
            ->orderByDesc('tahun_ajarans.tanggal_mulai')
            ->toSql();

        $dataMahasiswas = DB::table(DB::raw("($nilaiMahasiswas) as nilai_mhs"))
            ->select([
                'nilai_mhs.npm',
                'nilai_mhs.nama',
                'nilai_mhs.departmen',
                DB::raw('round(sum(nilai_mhs.angka_mutu * nilai_mhs.sks) / sum(nilai_mhs.sks), 2) ips'),
                DB::raw('round(sum(nilai_mhs.sks), 2) sks_per'),
                'nilai_mhs.tanggal_mulai'
            ])
            ->whereNotNull('nilai_mhs.angka_mutu')
            ->groupBy([
                'nilai_mhs.tanggal_mulai',
                'nilai_mhs.npm'
            ])
            ->toSql();

        $data = DB::table(DB::raw("({$dataMahasiswas}) as data_mhs"))
            ->select([
                'npm',
                'nama',
                'departmen',
                DB::raw("if (tanggal_mulai = '{$ta->tanggal_mulai}', ips, 0) ips"),
                DB::raw('round((sum(ips * sks_per) / sum(sks_per)), 2) ipk'),
                'sks_per',
                DB::raw('status_mahasiswa.status status'),
                DB::raw('sum(sks_per) sks_total')
            ])
            ->join('status_mahasiswa', 'status_mahasiswa.mahasiswa_npm', '=', 'npm')
            ->where('status_mahasiswa.tahun_ajaran', '=', $ta->id)
            ->groupBy('npm')
            ->get();

        $this->createSheet(compact('ta', 'data'));
    }

    public function export4 (TahunAjaran $ta) {

        // jangan lupa ini wherenya dihapus, ini cuma untuk cindy karolin
        $mhss = $ta->mahasiswas()->with('tahun_ajaran')->get();//->where('npm', '=','20.113023.61201.008');
        foreach($mhss as $mhs) {
            $tas_mahasiswa = $mhs->tahun_ajaran()->where('tanggal_mulai', '<=', $ta->tanggal_mulai)->orderBy('tanggal_mulai', 'desc')->get();

            $ips = 0;
            $ipk = 0;
            foreach($tas_mahasiswa as $ta_mahasiswa) {

                $jadwal_all = $mhs->jadwals();
                // START HITUNG IPS DI SMT TERTENTU
                $jadwal_smt = $mhs->jadwals()->where('tahun_ajaran_id', '=', $ta_mahasiswa->id)->with('matakuliah')->get();
                // dd($jadwal_all->get());
                // dd();
                $total_nilai_kali_sks = 0;
                $total_sks = 0;
                foreach ($jadwal_smt as $j) {
                    $am = $j->pivot->angka_mutu;
                    $sks = $j->matakuliah->sks;
                    $total_nilai_kali_sks = $total_nilai_kali_sks + ($sks * $am);
                    $total_sks = $total_sks + $sks;
                    // dump($sks);
                }

                if ($total_sks == 0) {
                    $ips = 0;
                } else {
                    $ips = $total_nilai_kali_sks / $total_sks;
                }
                // dump($ips);

                // END HITUNG IPS


                // START HITUNG IPK
                $total_nilai_kali_sks = 0;
                $total_sks = 0;

                // group by jadwal by id, ambil max angka mutu di jadwal (karena kemungkinan mengulang matkul)
                $jadwal_all = $jadwal_all->groupBy('matakuliah_id')->select("*","max(pivot_angka_mutu)")->get();//->toSql(); // belum ambil max nilainya
                // dd($jadwal_all);
                // hitung
                foreach ($jadwal_all as $j) {
                    $am = $j->pivot->angka_mutu;
                    $sks = $j->matakuliah->sks;
                    $total_nilai_kali_sks = $total_nilai_kali_sks + ($sks * $am);
                    $total_sks = $total_sks + $sks;
                    // dump($sks);

                }

                if ($total_sks == 0) {
                    $ipk = 0;
                } else {
                    $ipk = $total_nilai_kali_sks / $total_sks;
                }
                break;
                // dd($jadwal_all);

            }

            dump($mhs->npm. ' IPS: '. round($ips, 3). ' IPK: '. round($ipk, 3));
        }



    }

    public function export (TahunAjaran $ta) {
        // print)
        // jangan lupa ini wherenya dihapus, ini cuma untuk cindy karolin
        $mhss = $ta->mahasiswas()->with(['tahun_ajaran' => function($query) use ($ta) {
            return $query->where('tanggal_mulai', '<=', $ta->tanggal_mulai)
                ->orderBy('tanggal_mulai', 'desc');
            }, 'jadwals.matakuliah','user','jurusan', 'mahasiswa_konversi.matakuliah_konversis.matakuliah'])
            ->get();

        // // ->where('npm', '=','20.113023.61201.008')->toSql();
        // dd($mhss = $ta->mahasiswas[0]);
        // dd($mhss[0]);
        $c = 0;
        // dump('Jumlah Mahasiswa Semester '. $ta->tahun_ajaran. ": ". count($mhss));

        $data = array();
        $data['ta']['tahun_ajaran'] = $ta->tahun_ajaran;

        foreach($mhss as $mhs) {
            // dump(isset(($mhs->mahasiswa_konversi)));
            // continue;
            $tas_mahasiswa = $mhs->tahun_ajaran;
            $ips = 0;
            $ipk = 0;
            $sks_per = 0;
            $keterangan = array();
            $jadwal_all = $mhs->jadwals;

            foreach($tas_mahasiswa as $ta_mahasiswa) {
                // START HITUNG IPS DI SMT TERTENTU
                $jadwal_smt = $mhs->jadwals->where('tahun_ajaran_id', '=', $ta_mahasiswa->id)->all();

                $total_nilai_kali_sks = 0;
                $total_sks = 0;
                $total_sks_tidak_lulus_semester = 0;
                $nilai_null = false;
                foreach ($jadwal_smt as $j) {
                    if ($j->pivot->angka_mutu === null) {
                        $nilai_null = true;
                    }
                    $am = $j->pivot->angka_mutu;
                    $sks = $j->matakuliah->sks;
                    if ($am === 0) {
                        $total_sks_tidak_lulus_semester += $sks;
                    }
                    $total_nilai_kali_sks = $total_nilai_kali_sks + ($sks * $am);
                    $total_sks = $total_sks + $sks;
                    // dump($sks);
                }

                if (($total_sks) == 0) {
                    $ips = '-';
                    $keterangan[] = 'Tidak ikut KRS';
                    // dump($ips);
                } else {
                    $ips = $total_nilai_kali_sks / ($total_sks);
                }
                $sks_per = $total_sks;
                break;

                // END HITUNG IPS

            }
            // break;
            // return 0;

            // JIKA TAHUN INI BELUM DIISI NILAINYA, RETURN 0
            $ips = $nilai_null ? '0' : $ips;
            $keterangan[] = $nilai_null ? 'Nilai belum ada / tidak lengkap semester ini' : "";


            // START HITUNG IPK ALL HINGGA SEMESTER YANG DIPILIH SEKARANG
            $total_nilai_kali_sks = 0;
            $total_sks = 0;

            // ta yang telah diambil hingga sekarang
            $tas = $tas_mahasiswa->keyBy('id')->keys()->all();

            // JIKA TAHUN INI BELUM DIISI NILAINYA, IPK TAHUN INI TIDAK DIIKUTKAN
            if ($nilai_null) {
                array_shift($tas);
            }

            // group by jadwal by id, ambil max angka mutu di jadwal (karena kemungkinan mengulang matkul)
            $jadwal_all = $jadwal_all->whereIn('tahun_ajaran_id', $tas)->groupBy('matakuliah_id')->all();//->toSql(); // belum ambil max nilainya
            // dd($jadwal_all);
            $total_sks_tidak_lulus = 0;
            // hitung
            foreach ($jadwal_all as $j) {
                // $am = $j->pivot->angka_mutu;
                $am = $j->max('pivot.angka_mutu'); // max angka mutu
                $sks = ($j->max('matakuliah.sks')); // hanya select sksnya (karena sks sama)

                // SKS GA LULUS JIKA
                if ($am === 0) {
                    $total_sks_tidak_lulus += $sks;
                }

                $total_nilai_kali_sks = $total_nilai_kali_sks + ($sks * $am);
                $total_sks = $total_sks + $sks;
            }

            if (($total_sks - $total_sks_tidak_lulus) == 0) {
                $ipk = '0';
            } else {
                $ipk = $total_nilai_kali_sks / ($total_sks - $total_sks_tidak_lulus);
            }

            if ($nilai_null) {
                array_shift($tas);
                $total_sks += $sks_per;
            }

            // MAHASISWA KONVERSI

            if($mhs->mahasiswa_konversi) {
                // AMBIL MK KONVERSI
                $matakuliah_konversis = $mhs->mahasiswa_konversi->matakuliah_konversis;
                $total_nilai_kali_sks_konversi = 0;
                $total_sks_konversi = 0;
                // HITUNG TOTAL SKS DAN SKS*BOBOT
                foreach ($matakuliah_konversis as $mkk) {
                    $total_nilai_kali_sks += $mkk->nilai_matakuliah * $mkk->matakuliah->sks;
                    $total_sks += $mkk->matakuliah->sks;
                }
                // HITUNG IPK AKHIR
                $keterangan[] = 'Mahasiswa Konversi';
                if (($total_sks - $total_sks_tidak_lulus) != 0 && $total_sks_konversi != 0) {
                    $ipk = ($total_nilai_kali_sks + $total_nilai_kali_sks_konversi) / ($total_sks + $total_sks_konversi - $total_sks_tidak_lulus);
                }
            }

            // dd($mhs);

            $keterangan[] = !$total_sks ? 'Tidak ditemukan data matakuliah yang diambil' : "";
            $ipk = !$total_sks ? '-' : $ipk;
            $total_sks = !$total_sks ? '-' : $total_sks;
            $sks_per = !$sks_per ? '-' : $sks_per;

            // $data['data']
            $tmp['npm'] = $mhs->npm;
            $tmp['nama'] = $mhs->user->name;
            $tmp['departmen'] = $mhs->jurusan ? $mhs->jurusan->nama : "-";
            $tmp['status'] = $mhs->tahun_ajaran[0]->pivot->status;
            $tmp['ips'] = $ips;
            $tmp['ipk'] = $ipk;
            $tmp['sks_per'] = $sks_per;
            $tmp['sks_total'] = $total_sks;
            $tmp['keterangan'] = join("; ", $keterangan);
            $data['data'][] = $tmp;

            // print($mhs->jurusan->nama." ".$mhs->npm. " - ". $mhs->user->name. " Status: ". $mhs->tahun_ajaran[0]->pivot->status. ' IPS: '. round($ips, 3). ' IPK: '. round($ipk, 3). "<br>");
            $c++;
            if ($c == 1000) {
                die();
            }
        }
        // return 0;
        $this->createSheet($data);
    }


    public function export3(TahunAjaran $ta)
    {
        $nilaiMahasiswas = DB::table('mahasiswas', 'm')
        ->select([
            DB::raw('m.npm'),
            DB::raw('users.name nama'),
            DB::raw('jurusans.nama departmen'),
            DB::raw('max(jadwal_mahasiswa.angka_mutu) angka_mutu'),
            DB::raw('jadwals.matakuliah_id matakuliah_id'),
            DB::raw('tahun_ajarans.tahun_ajaran tahun_ajaran'),
            DB::raw('matakuliahs.sks sks'),
            DB::raw('tahun_ajarans.tanggal_mulai tanggal_mulai')
        ])
        ->join('jadwal_mahasiswa', 'jadwal_mahasiswa.mahasiswa_npm', '=', 'm.npm')
        ->join('jadwals', 'jadwals.id', '=', 'jadwal_mahasiswa.jadwal_id')
        ->join('tahun_ajarans', 'tahun_ajarans.id', '=', 'jadwals.tahun_ajaran_id')
        ->join('matakuliahs', 'matakuliahs.id', '=', 'jadwals.matakuliah_id')
        ->join('jurusans', 'jurusans.id', '=', 'm.jurusan_id')
        ->join('users', 'users.id', '=', 'm.user_id')
        ->whereRaw("tahun_ajarans.tanggal_mulai <= '{$ta->tanggal_mulai}'")
        ->groupBy(['m.npm', 'jadwals.matakuliah_id'])
        ->orderByDesc('tahun_ajarans.tanggal_mulai')
        ->toSql();

        // dd($nilaiMahasiswas);

        $dataMahasiswas = DB::table(DB::raw("($nilaiMahasiswas) as nilai_mhs"))
            ->select([
                'nilai_mhs.npm',
                'nilai_mhs.nama',
                'nilai_mhs.departmen',
                DB::raw('if(angka_mutu is not null, round(sum(angka_mutu * sks)/ sum(sks), 2), 0) as ips'),
                DB::raw('if(angka_mutu is not null, round(sum(nilai_mhs.sks), 2), 0) sks_per'),
                'nilai_mhs.tanggal_mulai'
            ])
            // ->whereNotNull('nilai_mhs.angka_mutu')
            ->groupBy([
                'nilai_mhs.tanggal_mulai',
                'nilai_mhs.npm'
            ])
            ->toSql();


        // dd($dataMahasiswas, "wk");

        $data = DB::table(DB::raw("({$dataMahasiswas}) as data_mhs"))
            ->select([
                'npm',
                'nama',
                'departmen',
                DB::raw("if (tanggal_mulai = '{$ta->tanggal_mulai}', ips, 0) ips"),
                DB::raw('round((sum(ips * sks_per) / sum(sks_per)), 2) ipk'),
                'sks_per',
                DB::raw('status_mahasiswa.status status'),
                DB::raw('sum(sks_per) sks_total')
            ])
            ->join('status_mahasiswa', 'status_mahasiswa.mahasiswa_npm', '=', 'npm')
            ->where('status_mahasiswa.tahun_ajaran', '=', $ta->id)
            ->groupBy('npm')
            ->toSql();
            // ->get();
        dd($data);
        // dd($data, $ta->id);
        $this->createSheet(compact('ta', 'data'));
    }


    public function createSheet($data)
    {
        $ta = $data['ta'];
        $fileName = "Laporan_{$ta['tahun_ajaran']}.xlsx";
        $mhs = collect($data['data'])->map(function ($m, $key) {
            $tmp = [
                $key+1,
                $m['npm'],
                $m['nama'],
                $m['departmen'],
                $m['status'],
                $m['ips'],
                $m['sks_per'],
                $m['ipk'],
                $m['sks_total'],
                $m['keterangan']
            ];

            Log::debug($tmp);

            return $tmp;
        });

        $cellValue = [
            ["Semester {$ta['tahun_ajaran']}"],
            ['NO', 'NPM', 'NAMA', 'DEPARTMEN', 'STATUS MAHASISWA', 'IPS', 'JUMLAH SKS SEMESTER', 'IPK', 'JUMLAH SKS TOTAL', 'KETERANGAN'],
            ...$mhs
        ];

        $spreadsheet = new Spreadsheet();
        $spreadsheet->getActiveSheet()
            ->fromArray(
                $cellValue,  // The data to set
                null,        // Array values with this value will not be set
                'A1'         // Top left coordinate of the worksheet range where
            );
        $spreadsheet->getActiveSheet()->mergeCells('A1:J1');
        $styleArray = [
            'font' => [
                'bold' => true,
            ],
        ];
        $styleData = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];
        $styleHeader = [
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
            ],
        ];
        $styleNilai = [
            'numberFormat' => [
                'formatCode' => \PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_00
            ],
        ];
        $styleCenter = [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
            ],
        ];
        $highestRow = $spreadsheet->getActiveSheet()->getHighestRowAndColumn();

        $spreadsheet->getActiveSheet()
            ->getStyle('A1')
            ->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()
            ->getStyle("A2:{$highestRow['column']}{$highestRow['row']}")
            ->applyFromArray($styleData);
        $spreadsheet->getActiveSheet()
            ->getStyle("A2:J2")
            ->applyFromArray($styleHeader);
        $spreadsheet->getActiveSheet()
            ->getStyle("F3:F{$highestRow['row']}")
            ->applyFromArray($styleNilai);
        $spreadsheet->getActiveSheet()
            ->getStyle("H3:H{$highestRow['row']}")
            ->applyFromArray($styleNilai);

        $spreadsheet->getActiveSheet()
            ->getStyle("J3:J{$highestRow['row']}")
            ->applyFromArray($styleCenter);

        $spreadsheet->getActiveSheet()
            ->getStyle("D3:I{$highestRow['row']}")
            ->applyFromArray($styleCenter);
        $spreadsheet->getActiveSheet()
            ->getStyle("A3:A{$highestRow['row']}")
            ->applyFromArray($styleCenter);

        foreach (range('A', 'J') as $col) {
            $spreadsheet->getActiveSheet()
                ->getColumnDimension($col)
                ->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);
        // $writer->save('php://output');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$fileName.'"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        die;
    }

    public function createSheet2($data)
    {
        $ta = $data['ta'];
        $fileName = "Laporan_{$ta['tahun_ajaran']}.xlsx";
        $mhs = collect($data['data'])->map(function ($m, $key) {
            $tmp = [
                $key+1,
                $m->npm,
                $m->nama,
                $m->departmen,
                $m->status,
                $m->ips,
                $m->sks_per,
                $m->ipk,
                $m->sks_total
            ];

            if ($tmp[4] == 'Tidak Aktif') {
                $tmp[6] = '0.00';
            }
            Log::debug($tmp);

            return $tmp;
        });

        $cellValue = [
            ["Semester {$ta->tahun_ajaran}"],
            ['NO', 'NPM', 'NAMA', 'DEPARTMEN', 'STATUS MAHASISWA', 'IPS', 'JUMLAH SKS SEMESTER', 'IPK', 'JUMLAH SKS TOTAL'],
            ...$mhs
        ];

        $spreadsheet = new Spreadsheet();
        $spreadsheet->getActiveSheet()
            ->fromArray(
                $cellValue,  // The data to set
                null,        // Array values with this value will not be set
                'A1'         // Top left coordinate of the worksheet range where
            );
        $spreadsheet->getActiveSheet()->mergeCells('A1:I1');
        $styleArray = [
            'font' => [
                'bold' => true,
            ],
        ];
        $styleData = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];
        $styleHeader = [
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
            ],
        ];
        $styleNilai = [
            'numberFormat' => [
                'formatCode' => \PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_00
            ],
        ];
        $styleCenter = [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
            ],
        ];
        $highestRow = $spreadsheet->getActiveSheet()->getHighestRowAndColumn();

        $spreadsheet->getActiveSheet()
            ->getStyle('A1')
            ->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()
            ->getStyle("A2:{$highestRow['column']}{$highestRow['row']}")
            ->applyFromArray($styleData);
        $spreadsheet->getActiveSheet()
            ->getStyle("A2:I2")
            ->applyFromArray($styleHeader);
        $spreadsheet->getActiveSheet()
            ->getStyle("F3:F{$highestRow['row']}")
            ->applyFromArray($styleNilai);
        $spreadsheet->getActiveSheet()
            ->getStyle("H3:H{$highestRow['row']}")
            ->applyFromArray($styleNilai);
        $spreadsheet->getActiveSheet()
            ->getStyle("D3:I{$highestRow['row']}")
            ->applyFromArray($styleCenter);
        $spreadsheet->getActiveSheet()
            ->getStyle("A3:A{$highestRow['row']}")
            ->applyFromArray($styleCenter);

        foreach (range('A', 'I') as $col) {
            $spreadsheet->getActiveSheet()
                ->getColumnDimension($col)
                ->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$fileName.'"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        die;
    }
}
