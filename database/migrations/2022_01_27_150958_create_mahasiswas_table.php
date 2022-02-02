<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMahasiswasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mahasiswas', function (Blueprint $table) {
            $table->string('npm', 25);
            $table->primary('npm');
            // foreign key
            // user id
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            // doswal
            $table->string('dosen_id', 20)->nullable();
            $table->foreign('dosen_id')->references('id')->on('dosens');

            // jurusan
            $table->unsignedBigInteger('jurusan_id')->nullable();
            $table->foreign('jurusan_id')->references('id')->on('jurusans');

            // data pribadi
            $table->string('jenis_tinggal', 45)->nullable();
            $table->string('alat_transportasi', 45)->nullable();
            $table->string('nisn', 20)->nullable();
            $table->string('npwp', 15)->nullable();
            
            // data ayah
            $table->string('nik_ayah', 20)->nullable();
            $table->string('nama_ayah', 100)->nullable();
            $table->string('tempat_lahir_ayah', 20)->nullable();
            $table->date('tanggal_lahir_ayah')->nullable();
            $table->string('pendidikan_ayah', 20)->nullable();
            $table->string('pekerjaan_ayah', 45)->nullable();
            $table->string('penghasilan_ayah', 15)->nullable();

            // data ibu
            $table->string('nik_ibu', 20)->nullable();
            $table->string('nama_ibu', 100)->nullable();
            $table->string('tempat_lahir_ibu', 20)->nullable();
            $table->date('tanggal_lahir_ibu')->nullable();
            $table->string('pendidikan_ibu', 20)->nullable();
            $table->string('pekerjaan_ibu', 45)->nullable();
            $table->string('penghasilan_ibu', 15)->nullable();
            
            $table->integer('uang_semester')->default(4000000)->nullable();
            $table->enum('status_mahasiswa', ['Aktif', 'Tidak Aktif', 'Lulus', 'Hilang', 'Cuti'])->default('Aktif');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mahasiswas');
    }
}
