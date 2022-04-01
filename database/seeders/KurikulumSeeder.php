<?php

namespace Database\Seeders;

use App\Models\Kurikulum;
use Illuminate\Database\Seeder;

class KurikulumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Kurikulum::insert([
            [
                'nama' => '2015',
                'aktif' => false,
            ],
            [
                'nama' => '2020',
                'aktif' => true,
            ],
        ]);
    }
}
