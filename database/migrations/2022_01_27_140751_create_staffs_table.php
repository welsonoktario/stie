<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staffs', function (Blueprint $table) {
            // id karyawan default dari kampus (NI Karyawan)
            $table->string('id', 45);
            $table->primary('id');
            $table->enum('divisi', ['BAAK','Keuangan','Dosen','Data'])->nullable();
            $table->enum('level_pengguna',['Administrator','Staff','Super Admin'])->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('jenjang_pendidikan', 20)->nullable();
            $table->string('gelar_depan', 45)->nullable();
            $table->string('gelar_belakang', 45)->nullable();
            $table->enum('status_karyawan',['Aktif','Keluar'])->default('Aktif')->nullable();
            // tambahan SK
            $table->string('nomor_sk_awal', 125)->nullable();
            $table->date('tanggal_sk_awal')->nullable();
            $table->string('nomor_sk_akhir', 125)->nullable();
            $table->date('tanggal_sk_akhir')->nullable();
            
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
        Schema::dropIfExists('staffs');
    }
}
