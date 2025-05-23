<?php

namespace App\Http\Controllers;

use App\Models\PembayaranIuran;
use App\Models\Pengeluaran;
use App\Models\Saldo;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $saldos = Saldo::orderBy('tahun', 'desc')->orderBy('bulan', 'desc')->get();

        // Gunakan bulan & tahun dari query, fallback ke sekarang
        $bulan = $request->input('bulan', now()->format('m'));
        $tahun = $request->input('tahun', now()->format('Y'));

        $current = Saldo::where('bulan', $bulan)->where('tahun', $tahun)->first();

        $currentPemasukan = PembayaranIuran::where('status', 'lunas')
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->sum('jumlah');

        $currentPengeluaran = Pengeluaran::whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->sum('jumlah');

        $needsUpdate = false;

        if ($current) {
            $needsUpdate = $current->total_pemasukan != $currentPemasukan ||
                $current->total_pengeluaran != $currentPengeluaran;
        } else {
            $needsUpdate = $currentPemasukan > 0 || $currentPengeluaran > 0;
        }

        $detailPemasukan = PembayaranIuran::with('penghuniRumah')->where('status', 'lunas')
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->get();

        $detailPengeluaran = Pengeluaran::whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->get();

        return view('home', compact(
            'saldos',
            'needsUpdate',
            'bulan',
            'tahun',
            'detailPemasukan',
            'detailPengeluaran'
        ));
    }

    public function filterDetail(Request $request)
    {
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');

        $detailPemasukan = PembayaranIuran::where('status', 'lunas')
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->get();

        $detailPengeluaran = Pengeluaran::whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->get();

        return view('partials.detail-keuangan', compact('detailPemasukan', 'detailPengeluaran', 'bulan', 'tahun'));
    }



    public function getFinancialData()
    {
        $year = Carbon::now()->year;

        $months = range(1, 12);
        $incomeData = [];
        $expenseData = [];

        foreach ($months as $month) {
            $incomeData[] = PembayaranIuran::where('status', 'lunas')
                ->where('bulan', $month)
                ->where('tahun', $year)
                ->sum('jumlah');

            $expenseData[] = Pengeluaran::whereMonth('tanggal', $month)
                ->whereYear('tanggal', $year)
                ->sum('jumlah');
        }

        return response()->json([
            'labels' => array_map(fn($m) => Carbon::create()->month($m)->format('F'), $months),
            'income' => $incomeData,
            'expenses' => $expenseData,
        ]);
    }

    public function createOrUpdateSaldo(Request $request)
    {
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');

        $totalPemasukan = PembayaranIuran::where('status', 'lunas')
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->sum('jumlah');

        $totalPengeluaran = Pengeluaran::whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->sum('jumlah');

        $saldo = $totalPemasukan - $totalPengeluaran;

        Saldo::updateOrCreate(
            ['bulan' => $bulan, 'tahun' => $tahun],
            [
                'total_pemasukan' => $totalPemasukan,
                'total_pengeluaran' => $totalPengeluaran,
                'saldo' => $saldo
            ]
        );

        return redirect()->route('dashboard')->with('success', "Saldo bulan $bulan-$tahun berhasil dihitung.");
    }
}
