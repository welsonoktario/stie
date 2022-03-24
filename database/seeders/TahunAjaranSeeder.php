<?php

namespace Database\Seeders;

use App\Models\TahunAjaran;
use Illuminate\Database\Seeder;

class TahunAjaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TahunAjaran::insert([
            [
                'tahun_ajaran' => 'Ganjil 2022/2023',
                'tanggal_mulai' => '2022-01-01',
                'tanggal_selesai' => '2022-06-01',
                'periode' => 1
            ],
            [
                'tahun_ajaran' => 'Genap 2022/2023',
                'tanggal_mulai' => '2022-06-01',
                'tanggal_selesai' => '2023-01-01',
                'periode' => 2
            ],
        ]);
    }
}
