<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJadwalDosenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jadwal_dosen', function (Blueprint $table) {
            // $table->id();
            $table->string('dosen_id');
            $table->foreign('dosen_id')->references('id')->on('dosens');
            $table->unsignedBigInteger('jadwal_id');
            $table->foreign('jadwal_id')->references('id')->on('jadwals');
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
        Schema::dropIfExists('jadwal_dosen');
    }
}
