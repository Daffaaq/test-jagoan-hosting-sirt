<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IuranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('iurans')->insert([
            [
                'jenis' => 'satpam',
                'jumlah' => 100000,
                'periode' => 'bulanan',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'jenis' => 'satpam',
                'jumlah' => 100000 * 12, // tahunan
                'periode' => 'tahunan',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'jenis' => 'kebersihan',
                'jumlah' => 15000,
                'periode' => 'bulanan',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'jenis' => 'kebersihan',
                'jumlah' => 15000 * 12, // tahunan
                'periode' => 'tahunan',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
