<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJadwalMahasiswaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jadwal_mahasiswa', function (Blueprint $table) {
            // $table->id();

            // $table->unsignedBigInteger('jadwal_id');
            // $table->foreign('jadwal_id')->references('id')->on('jadwals');
            $table->foreignId('jadwal_id')->constrained();

            $table->string('mahasiswa_npm', 25);
            $table->foreign('mahasiswa_npm')->references('npm')->on('mahasiswas');

            $table->decimal('nilai_uts')->nullable();
            $table->decimal('nilai_nas')->nullable();
            $table->decimal('nilai_akhir')->nullable();
            $table->decimal('angka_mutu')->nullable();
            $table->string('nisbi', 3)->nullable();

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
        Schema::dropIfExists('jadwal_mahasiswa');
    }
}
