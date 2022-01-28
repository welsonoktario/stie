<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nik', 20)->nullable()->unique();
            $table->string('name');
            $table->string('nama_panggilan', 45)->nullable();
            $table->enum('jenis_kelamin', ['Laki-laki','Perempuan'])->nullable();
            $table->enum('agama', ['Islam', 'Kristen', 'Katolik', 'Budha', 'Hindu', 'Konghucu'])->nullable();
            $table->string('nomor_hp', 20)->nullable();
            $table->string('email')->unique();
            $table->string('tempat_lahir', 45)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('jalan', 50)->nullable();
            $table->string('kelurahan', 50)->nullable();
            $table->string('kecamatan', 50)->nullable();
            $table->string('kode_pos', 10)->nullable();
            $table->boolean('login')->default(0);
            $table->boolean('status_aktif')->default(1);
            $table->enum('kewarganegaraan', ['WNI','WNA'])->default('WNI');

            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
