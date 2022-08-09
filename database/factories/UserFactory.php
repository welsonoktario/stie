<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nik' => $this->faker->nik(),
            'name' => $this->faker->name(),
            'nama_panggilan' => $this->faker->firstName(),
            'jenis_kelamin' => $this->faker->randomElement(['Perempuan', 'Laki-laki']),
            'agama' => $this->faker->randomElement(['Islam', 'Kristen', 'Katolik', 'Budha', 'Hindu', 'Konghucu']),
            'nomor_hp' => $this->faker->e164PhoneNumber(),
            'email' => $this->faker->unique()->safeEmail(),
            'tempat_lahir' => 'Tarakan',
            'tanggal_lahir' => $this->faker->date(),
            'jalan' => $this->faker->streetAddress(),
            'kelurahan' => $this->faker->state(),
            'kecamatan' => $this->faker->state(),
            'kode_pos' => $this->faker->postcode(),
            'kewarganegaraan' => 'WNI',
            'email_verified_at' => now(),
            'password' => '$2y$10$npg8.sMJKyIACzvRUg/.oedQSkclhd8HLmjvOjB3GBxYtRi0S4tI2', // 123
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
