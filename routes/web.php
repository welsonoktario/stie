<?php

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

Route::group(['middleware' => ['auth']], function () {
    Route::get('dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('master.dashboard');

    Route::get('testing', [ModelTestingController::class, 'index']);

    // Master route
    Route::group(['prefix' => 'master', 'as' => 'master.'], function () {
        Route::get('kurikulum/{kurikulum}/prasyarat', [KurikulumController::class, 'loadPrasyarats'])->name('kurikulum.prasyarat');

        Route::resources([
            'karyawan' => KaryawanController::class,
            'jurusan' => JurusanController::class,
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

        Route::get('/mahasiswa-konversi/{mahasiswa_konversi_id}/matakuliah-konversi/create', [MatakuliahKonversiController::class, 'create'])->name('mahasiswa-konversi.matakuliah.create');
        Route::get('/mahasiswa-konversi/{mahasiswa_konversi_id}/matakuliah-konversi', [MatakuliahKonversiController::class, 'index'])->name('mahasiswa-konversi.matakuliah.index');
        Route::post('/mahasiswa-konversi/{mahasiswa_konversi_id}/matakuliah-konversi/store', [MatakuliahKonversiController::class, 'store'])->name('mahasiswa-konversi.matakuliah.store');
        Route::get('/mahasiswa-konversi/{mahasiswa_konversi_id}/matakuliah-konversi/{matakuliah_konversi_id}', [MatakuliahKonversiController::class, 'show'])->name('mahasiswa-konversi.matakuliah.show');
        Route::put('/mahasiswa-konversi/{mahasiswa_konversi_id}/matakuliah-konversi/{matakuliah_konversi_id}', [MatakuliahKonversiController::class, 'update'])->name('mahasiswa-konversi.matakuliah.update');
        Route::delete('/mahasiswa-konversi/{mahasiswa_konversi_id}/matakuliah-konversi/{matakuliah_konversi_id}', [MatakuliahKonversiController::class, 'destroy'])->name('mahasiswa-konversi.matakuliah.destroy');
    });


    // Transaksi route
    Route::group(['prefix' => 'transaksi', 'as' => 'transaksi.'], function () {
        Route::get('kurikulum/{kurikulum}/prasyarat', [KurikulumController::class, 'loadPrasyarats'])->name('kurikulum.prasyarat');

        Route::get('testing', [TestingController::class, 'index'])->name('testing');
    });
});

require __DIR__ . '/auth.php';
