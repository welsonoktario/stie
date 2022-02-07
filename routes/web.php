<?php

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\ModelTestingController;

// Master Menu Controller
use App\Http\Controllers\Master\Akademik\JurusanController;
use App\Http\Controllers\Master\Akademik\KurikulumController;
use App\Http\Controllers\Master\Akademik\MatakuliahController;
use App\Http\Controllers\Master\Akademik\RuanganController;
use App\Http\Controllers\Master\Akademik\TahunAjaranController;

use App\Http\Controllers\Master\Karyawan\DosenController;
use App\Http\Controllers\Master\Karyawan\KaryawanController;

use App\Http\Controllers\Master\Mahasiswa\MahasiswaReguler;
use App\Http\Controllers\Master\Mahasiswa\MahasiswaRegulerController;

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
    });
    Route::get('testing', [ModelTestingController::class, 'index']);

    // Master route
    Route::group(['prefix' => 'master'], function(){
        // Karyawan
        Route::resource('karyawan', KaryawanController::class);
        Route::resource('dosen', DosenController::class); 

        // Akademik
        Route::resource('jurusan', JurusanController::class);
        Route::resource('tahun_ajaran', TahunAjaranController::class);
        Route::resource('ruangan', RuanganController::class);
        Route::resource('kurikulum', KurikulumController::class);
        Route::resource('matakuliah', MatakuliahController::class); 
        
        // Mahasiswa
        Route::resource('mahasiswa-reguler', MahasiswaRegulerController::class); 
    });
});

// Route::get('/testing', function() {
//     return dd(User::all());
// });
require __DIR__ . '/auth.php';
