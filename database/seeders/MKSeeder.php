<?php

namespace Database\Seeders;

use App\Models\Kurikulum;
use Illuminate\Database\Seeder;

class MKSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $kurikulum = Kurikulum::find(1);
        for ($i = 1; $i <= 88; $i++) {
            $tipe = ['wajib', 'pilihan', 'pilihan wajib'];
            $kurikulum->matakuliahs()->create([
                'kode_matakuliah' => "MK$i",
                'nama_matakuliah' => "Matakuliah $i",
                'sks' => rand(1, 3),
                'tipe' => $tipe[rand(0, 2)]
            ]);
        }
    }
}
