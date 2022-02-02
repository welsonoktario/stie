<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDosensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dosens', function (Blueprint $table) {
            $table->string('id', 20);
            $table->primary('id');
            
            $table->string('staff_id', 45);
            $table->foreign('staff_id')->references('id')->on('staffs');

            $table->enum('tipe_id', ['NIDN', 'NIDK', 'NUPN'])->nullable()->default('NIDN');

            $table->unsignedBigInteger('jurusan_id')->nullable();
            $table->foreign('jurusan_id')->references('id')->on('jurusans');

            $table->enum('jabatan_akademik',['Tenaga Pengajar', 'Asisten Ahli', 'Lektor']);
            $table->enum('tipe_dosen',['Dosen Tetap', 'Dosen Khusus']);
            $table->string('konsentrasi');
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
        Schema::dropIfExists('dosens');
    }
}
