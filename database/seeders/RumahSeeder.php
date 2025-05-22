<?php

namespace Database\Seeders;

use App\Models\Rumah;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RumahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $nomors = ['A1', 'A2', 'B1', 'B2', 'C1'];
        foreach ($nomors as $nomor) {
            Rumah::create([
                'nomor_rumah' => $nomor,
                'status_huni' => 'tidak dihuni',
            ]);
        }
    }
}
