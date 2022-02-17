<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatakuliahJurusansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matakuliah_jurusans', function (Blueprint $table) {
            $table->id();
            // $table->unsignedBigInteger('matakuliah_id');
            // $table->foreign('matakuliah_id')->references('id')->on('matakuliahs');
            $table->foreignId('matakuliah_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();;
            // $table->unsignedBigInteger('jurusan_id');
            // $table->foreign('jurusan_id')->references('id')->on('jurusans');
            $table->foreignId('jurusan_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();;

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
        Schema::dropIfExists('matakuliah_jurusans');
    }
}
