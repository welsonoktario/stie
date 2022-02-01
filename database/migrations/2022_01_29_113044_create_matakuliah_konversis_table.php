<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatakuliahKonversisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matakuliah_konversis', function (Blueprint $table) {
            $table->id();
            $table->string('kode_matakuliah')->nullable();
            $table->string('nama_matakuliah')->nullable();
            $table->string('sks_matakuliah')->nullable();
            $table->string('nilai_matakuliah')->nullable();
            
            $table->unsignedBigInteger('mahasiswa_konversi_id');
            $table->foreign('mahasiswa_konversi_id')->references('id')->on('mahasiswa_konversis');
            
            $table->unsignedBigInteger('matakuliah_id');
            $table->foreign('matakuliah_id')->references('id')->on('matakuliahs');
            
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
        Schema::dropIfExists('matakuliah_konversis');
    }
}
