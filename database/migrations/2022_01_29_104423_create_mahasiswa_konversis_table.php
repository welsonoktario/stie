<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMahasiswaKonversisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mahasiswa_konversis', function (Blueprint $table) {
            $table->id();
            $table->string('mahasiswa_npm', 25)->nullable();
            $table->foreign('mahasiswa_npm')->references('npm')->on('mahasiswas')->onDelete('cascade')->onUpdate('cascade');
            $table->string("npm_asal", 45)->nullable();
            $table->string('perguruan_tinggi_asal', 125)->nullable();
            $table->string('jurusan_asal', 125)->nullable();
            $table->string('jenjang_pendidikan', 45)->nullable();
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
        Schema::dropIfExists('mahasiswa_konversis');
    }
}
