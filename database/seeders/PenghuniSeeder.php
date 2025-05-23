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
        // 15 Penghuni Tetap
        for ($i = 0; $i < 15; $i++) {
            Penghuni::create([
                'nama_lengkap' => fake()->name(),
                'foto_ktp' => null,
                'status_penghuni' => 'tetap',
                'nomor_telepon' => fake()->phoneNumber(),
                'status_menikah' => fake()->randomElement(['menikah', 'belum menikah']),
            ]);
        }

        // 5 Penghuni Kontrak
        for ($i = 0; $i < 5; $i++) {
            Penghuni::create([
                'nama_lengkap' => fake()->name(),
                'foto_ktp' => null,
                'status_penghuni' => 'kontrak',
                'nomor_telepon' => fake()->phoneNumber(),
                'status_menikah' => fake()->randomElement(['menikah', 'belum menikah']),
            ]);
        }
    }
}
