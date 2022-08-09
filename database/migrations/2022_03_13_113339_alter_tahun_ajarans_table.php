<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTahunAjaransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tahun_ajarans', function (Blueprint $table) {
            //
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');

            $table->dropColumn(['tahun_mulai','tahun_selesai']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tahun_ajarans', function (Blueprint $table) {
            //
            $table->year('tahun_mulai');
            $table->year('tahun_selesai');

            $table->dropColumn(['tanggal_mulai','tanggal_selesai']);
        });
    }
}
