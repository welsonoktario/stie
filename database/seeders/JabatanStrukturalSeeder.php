<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JabatanStrukturalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $data = [
            ['nama_jabatan' => 'Ketua'],
            ['nama_jabatan' => 'Wakil Ketua I'],
            ['nama_jabatan' => 'Wakil Ketua II'],
            ['nama_jabatan' => 'Wakil Ketua II'],
            ['nama_jabatan' => 'Ketua Bagian Administrasi Akademik, Kemahasiswaan, Alumni $ Kerjasama'],
            ['nama_jabatan' => 'Kepala Departemen Manajemen'],
            ['nama_jabatan' => 'Kepala Departemen Ekonomi Pembangunan'],
            ['nama_jabatan' => 'Ketua Lembaga Penelitian dan Pengabdian Kepada Masyarakat'],
            ['nama_jabatan' => 'Ketua Bagian Administrasi Umum, Sumber Daya Manusia, Keuangan & Aset'],
            ['nama_jabatan' => 'Ketua Unit Pelayanan Teknis Perpustakaan'],
            ['nama_jabatan' => 'Ketua Unit Pelayanan Teknis Pusat Data & Lab Komputer'],
        ];
        DB::table('jabatan_strukturals')->insert($data);
    }
}
