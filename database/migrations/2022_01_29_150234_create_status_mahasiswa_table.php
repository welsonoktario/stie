<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatusMahasiswaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('status_mahasiswa', function (Blueprint $table) {
            // $table->id();

            // $table->unsignedBigInteger('tahun_ajaran');
            // $table->foreign('tahun_ajaran')->references('id')->on('tahun_ajarans');
            $table->foreignId('tahun_ajaran')->constrained();

            $table->string('mahasiswa_npm', 25);
            $table->foreign('mahasiswa_npm')->references('npm')->on('mahasiswas');

            $table->enum('status', [
                'Aktif',
                'Tidak Aktif',
                'Lulus',
                'Mutasi',
                'Dikeluarkan',
                'Mengundurkan Diri',
                'Hilang',
                'Cuti',
                'Wafat'
            ])->nullable();

            $table->decimal('jumlah_cicilan_1')->nullable();
            $table->dateTime('tanggal_cicilan_1')->nullable();
            $table->string('keterangan_ciilan_1')->nullable();

            $table->decimal('jumlah_cicilan_2')->nullable();
            $table->dateTime('tanggal_cicilan_2')->nullable();
            $table->string('keterangan_ciilan_2')->nullable();

            $table->decimal('jumlah_cicilan_3')->nullable();
            $table->dateTime('tanggal_cicilan_3')->nullable();
            $table->string('keterangan_ciilan_3')->nullable();

            $table->decimal('total_cicilan')->nullable();
            $table->decimal('uang_semester')->nullable();

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
        Schema::dropIfExists('status_mahasiswa');
    }
}
