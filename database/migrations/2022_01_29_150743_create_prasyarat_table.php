<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrasyaratTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prasyarat', function (Blueprint $table) {
            // $table->id();
            // $table->unsignedBigInteger('matakuliah_id');
            // $table->foreign('matakuliah_id')->references('id')->on('matakuliahs');
            $table->foreignId('matakuliah_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            // $table->unsignedBigInteger('prasyarat_id');
            // $table->foreign('prasyarat_id')->references('id')->on('matakuliahs');
            $table->foreignId('prasyarat_id')->constrained('matakuliahs')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('nilai_minimum', 3)->nullable();
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
        Schema::dropIfExists('prasyarat');
    }
}
