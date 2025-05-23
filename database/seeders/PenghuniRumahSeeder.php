<?php

namespace Database\Seeders;

use App\Models\Penghuni;
use App\Models\PenghuniRumah;
use App\Models\Rumah;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PenghuniRumahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $penghuniList = Penghuni::all();
        $rumahList = Rumah::where('status_huni', 'tidak dihuni')->get();

        foreach ($penghuniList as $index => $penghuni) {
            // Ambil rumah satu per satu sesuai index penghuni
            $rumah = $rumahList[$index] ?? null;
            if (!$rumah) {
                break; // Tidak ada rumah lagi
            }

            $tanggalMulai = Carbon::now();
            $tanggalSelesai = $penghuni->status_penghuni === 'kontrak'
                ? $tanggalMulai->copy()->addDays(30)
                : null;

            // Buat relasi penghuni dan rumah
            PenghuniRumah::create([
                'penghuni_id' => $penghuni->id,
                'rumah_id' => $rumah->id,
                'tanggal_mulai' => $tanggalMulai,
                'tanggal_selesai' => $tanggalSelesai,
            ]);

            // Update status rumah jadi dihuni
            $rumah->update([
                'status_huni' => 'dihuni',
            ]);
        }
    }
}
