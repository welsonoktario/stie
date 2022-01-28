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
            $table->string('nid', 20);
            $table->primary('nid');
            
            $table->string('staff_nip', 20);
            $table->foreign('staff_nip')->references('nip')->on('staffs');

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
