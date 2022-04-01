<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MatakuliahFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'kurikulum_id' => $this->faker->numberBetween(1, 2),
            'kode_matakuliah' => $this->faker->text(10),
            'nama_matakuliah' => $this->faker->words(2, true),
            'sks' => $this->faker->numberBetween(1, 3),
            'tipe' => $this->faker->randomElement(['wajib', 'pilihan', 'pilihan wajib'])
        ];
    }
}
