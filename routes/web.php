<?php

use App\Http\Controllers\Master\Akademik\JabatanStruktural;
use App\Http\Controllers\Master\Akademik\JabatanStrukturalController;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\TestingController;

// Master Menu Controller
use App\Http\Controllers\ModelTestingController;
use App\Http\Controllers\Master\Karyawan\DosenController;
use App\Http\Controllers\Master\Akademik\JurusanController;
use App\Http\Controllers\Master\Akademik\RuanganController;
use App\Http\Controllers\Master\Mahasiswa\MahasiswaReguler;

use App\Http\Controllers\Master\Karyawan\KaryawanController;
use App\Http\Controllers\Master\Akademik\KurikulumController;

use App\Http\Controllers\Master\Akademik\MatakuliahController;
use App\Http\Controllers\Master\Akademik\TahunAjaranController;
use App\Http\Controllers\Master\Mahasiswa\MahasiswaRegulerController;
use App\Http\Controllers\Master\Mahasiswa\MahasiswaKonversiController;
use App\Http\Controllers\Master\Mahasiswa\MatakuliahKonversiController;
use App\Http\Controllers\Transaksi\Jadwal\JadwalController;
use App\Http\Controllers\Transaksi\Jadwal\JadwalMahasiswaController;

use App\Http\Controllers\Transaksi\Keuangan\KeuanganController;
use App\Http\Controllers\Transaksi\KRS\KRSController;
use App\Http\Controllers\Transaksi\Nilai\NilaiController;
use App\Http\Controllers\Transaksi\Ujian\UjianController;
use App\Http\Controllers\TranskripController;

// use App\Models\TahunAjaran;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/print/{ta}', [TestingController::class, 'export'])->name("print.aktivitas");

Route::group(['middleware' => ['auth']], function () {
    Route::get('dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('master.dashboard');

    Route::get('testing', [TestingController::class, 'index']);

    // Master route
    Route::group(['prefix' => 'master', 'as' => 'master.'], function () {
        Route::get('kurikulum/{kurikulum_id}/prasyarat', [KurikulumController::class, 'loadPrasyarats'])->name('kurikulum.prasyarat');

        Route::group(['prefix' => 'mahasiswa-konversi'], function () {
            Route::get('{mahasiswa_konversi_id}/matakuliah-konversi/create', [MatakuliahKonversiController::class, 'create'])->name('mahasiswa-konversi.matakuliah.create');
            Route::get('{mahasiswa_konversi_id}/matakuliah-konversi', [MatakuliahKonversiController::class, 'index'])->name('mahasiswa-konversi.matakuliah.index');
            Route::post('{mahasiswa_konversi_id}/matakuliah-konversi/store', [MatakuliahKonversiController::class, 'store'])->name('mahasiswa-konversi.matakuliah.store');
            Route::get('{mahasiswa_konversi_id}/matakuliah-konversi/{matakuliah_konversi_id}', [MatakuliahKonversiController::class, 'show'])->name('mahasiswa-konversi.matakuliah.show');
            Route::put('{mahasiswa_konversi_id}/matakuliah-konversi/{matakuliah_konversi_id}', [MatakuliahKonversiController::class, 'update'])->name('mahasiswa-konversi.matakuliah.update');
            Route::delete('{mahasiswa_konversi_id}/matakuliah-konversi/{matakuliah_konversi_id}', [MatakuliahKonversiController::class, 'destroy'])->name('mahasiswa-konversi.matakuliah.destroy');
        });

        Route::resources([
            'karyawan' => KaryawanController::class,
            'jurusan' => JurusanController::class,
            'jabatan-struktural' => JabatanStrukturalController::class,
            'tahun-ajaran' => TahunAjaranController::class,
            'ruangan' => RuanganController::class,
            'kurikulum' => KurikulumController::class,
            'dosen' => DosenController::class,
            'matakuliah' => MatakuliahController::class,
            'mahasiswa-reguler' => MahasiswaRegulerController::class,
            'mahasiswa-konversi' => MahasiswaKonversiController::class,
        ], [
            'except' => ['show']
        ]);
    });


    // Transaksi route
    Route::group(['prefix' => 'transaksi', 'as' => 'transaksi.'], function () {
        Route::get('kurikulum/{kurikulum}/prasyarat', [KurikulumController::class, 'loadPrasyarats'])
            ->name('kurikulum.prasyarat');

        Route::get('testing', [TestingController::class, 'index'])->name('testing');

        // transkrip dan KRS
        Route::get('transkrip/{mahasiswa}', [TranskripController::class, 'show'])->name('transkrip');
        Route::get('transkrip/{mahasiswa}/{ta}', [TranskripController::class, 'khs'])->name('khs');

        Route::post('krs/{mahasiswa}/copy', [KRSController::class, 'copy'])->name('krs.copy');

        Route::group(['prefix' => 'jadwal', 'as' => 'jadwal.'], function () {
            Route::patch('mahasiswa/{jadwal}/nilai/{mahasiswa}', [JadwalMahasiswaController::class, 'editNilai'])->name('mahasiswa.editNilai');
            Route::get('mahasiswa/{jadwal}/nilai/{mahasiswa}', [JadwalMahasiswaController::class, 'loadNilai'])->name('mahasiswa.loadNilai');
            Route::resource('mahasiswa', JadwalMahasiswaController::class, ['except' => ['store', 'edit', 'show']]);
        });

        Route::get('ujian/{mahasiswa}/print/{ta}', [UjianController::class, 'show'])
            ->name('ujian.print');

        Route::get('jadwal/{jadwal}/print', [JadwalController::class, 'print'])
            ->name('jadwal.print');

        Route::resources([
            'jadwal' => JadwalController::class,
            'keuangan' => KeuanganController::class,
            'krs' => KRSController::class,
            'nilai' => NilaiController::class,
            'ujian' => UjianController::class,
        ], [
            'except' => 'show',
            'parameters' => [
                'nilai' => 'mahasiswa',
                'ujian' => 'mahasiswa'
            ]
        ]);
    });
});

require __DIR__ . '/auth.php';
