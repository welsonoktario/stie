<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJadwalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jadwals', function (Blueprint $table) {
            $table->id();
            $table->time('jam')->nullable();
            $table->enum('hari', ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu', 'Daring'])->nullable();

            // $table->unsignedBigInteger('matakuliah_id');
            // $table->foreign('matakuliah_id')->references('id')->on('matakuliahs');
            $table->foreignId('matakuliah_id')->constrained();

            // $table->unsignedBigInteger('ruangan_id');
            // $table->foreign('ruangan_id')->references('id')->on('ruangans');
            $table->foreignId('ruangan_id')->constrained();

            // $table->unsignedBigInteger('tahun_ajaran_id');
            // $table->foreign('tahun_ajaran_id')->references('id')->on('tahun_ajarans');
            $table->foreignId('tahun_ajaran_id')->constrained();
            
            $table->string('local', 1)->nullable();
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
        Schema::dropIfExists('jadwals');
    }
}
