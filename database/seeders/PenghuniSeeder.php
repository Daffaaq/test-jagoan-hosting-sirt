<?php

namespace Database\Seeders;

use App\Models\Penghuni;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PenghuniSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 10; $i++) {
            Penghuni::create([
                'nama_lengkap' => fake()->name(),
                'foto_ktp' => null,
                'status_penghuni' => fake()->randomElement(['kontrak', 'tetap']),
                'nomor_telepon' => fake()->phoneNumber(),
                'status_menikah' => fake()->randomElement(['menikah', 'belum menikah']),
            ]);
        }
    }
}
