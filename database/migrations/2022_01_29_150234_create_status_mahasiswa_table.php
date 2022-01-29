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
            
            $table->unsignedBigInteger('tahun_ajaran');
            $table->foreign('tahun_ajaran')->references('id')->on('tahun_ajarans');

            $table->string('mahasiswa_npm', 25);
            $table->foreign('mahasiswa_npm')->references('npm')->on('mahasiswas');

            $table->enum('status', ['Aktif', 'Tidak Aktif', 'Lulus', 'Hilang', 'Cuti'])->nullable();
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
