<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatakuliahsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matakuliahs', function (Blueprint $table) {
            $table->id();
            // $table->unsignedBigInteger('kurikulum_id');
            // $table->foreign('kurikulum_id')->references('id')->on('kurikulums');
            $table->foreignId('kurikulum_id')->constrained();

            $table->string('kode_matakuliah', 10)->nullable();
            $table->string('nama_matakuliah', 45)->nullable();
            $table->enum('semester', [1,2,3,4,5,6,7,8,9,10,11,12,13])->nullable();
            $table->tinyInteger('sks')->nullable();
            $table->enum('tipe', ['wajib', 'pilihan', 'pilihan wajib'])->nullable();
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
        Schema::dropIfExists('matakuliahs');
    }
}
