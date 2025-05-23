<?php

namespace App\Http\Controllers;

use App\Models\Iuran;
use App\Models\PembayaranIuran;
use App\Models\PenghuniRumah;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PembayaranIuranController extends Controller
{
    public function list(Request $request)
    {
        if ($request->ajax()) {
            $data = PembayaranIuran::with([
                'penghuniRumah.penghuni',
                'penghuniRumah.rumah',
                'iuran'
            ]);
            return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
        }
    }
    public function index()
    {
        return view('pembayaran-iuran.index');
    }

    public function generateTagihanBulanIni($bulan, $tahun)
    {
        DB::beginTransaction();

        try {
            // Ambil semua iuran aktif bulanan
            $iurans = Iuran::where('status', 'aktif')
                ->where('periode', 'bulanan')
                ->get();

            // Ambil semua penghuni rumah yang aktif di bulan tsb
            $tanggal = now()->setYear($tahun)->setMonth($bulan)->startOfMonth();

            $penghuniRumahs = PenghuniRumah::where(function ($query) use ($tanggal) {
                $query->whereNull('tanggal_selesai')
                    ->orWhere('tanggal_selesai', '>=', $tanggal);
            })->get();

            foreach ($penghuniRumahs as $pr) {
                foreach ($iurans as $iuran) {
                    $exists = PembayaranIuran::where('penghuni_rumah_id', $pr->id)
                        ->where('iuran_id', $iuran->id)
                        ->where('bulan', $bulan)
                        ->where('tahun', $tahun)
                        ->exists();

                    if (!$exists) {
                        PembayaranIuran::create([
                            'penghuni_rumah_id' => $pr->id,
                            'iuran_id' => $iuran->id,
                            'bulan' => $bulan,
                            'tahun' => $tahun,
                            'jumlah' => $iuran->jumlah,
                            'status' => 'belum lunas',
                            'tanggal_bayar' => null,
                        ]);
                    }
                }
            }

            DB::commit();
            return redirect()->route('pembayaran-iuran.index')->with('success', "Tagihan bulan $bulan tahun $tahun berhasil digenerate.");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('pembayaran-iuran.index')->with('error', "Gagal menggenerate tagihan bulan $bulan tahun $tahun.");
        }
    }


    public function formGenerateTagihan()
    {
        $penghuni = PenghuniRumah::with('penghuni', 'rumah')->get();
        return view('pembayaran-iuran.form-generate-tagihan', compact('penghuni'));
    }

    public function generateTagihanManual(Request $request)
    {
        $request->validate([
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer|min:2020',
        ]);

        return $this->generateTagihanBulanIni($request->bulan, $request->tahun);
    }

    public function formGenerateTagihanPenghuni()
    {
        $now = now()->startOfDay();

        $penghuniRumahs = PenghuniRumah::with('penghuni', 'rumah')
            ->where(function ($query) use ($now) {
                $query->whereNull('tanggal_selesai')
                    ->orWhere('tanggal_selesai', '>=', $now);
            })
            ->get();
        return view('pembayaran-iuran.form-generate-tagihan-penghuni', compact('penghuniRumahs'));
    }

    public function generateTagihanPenghuni(Request $request)
    {
        $request->validate([
            'penghuni_rumah_id' => 'required|exists:penghuni_rumahs,id',
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer|min:2020',
        ]);

        DB::beginTransaction();

        try {
            $iurans = Iuran::where('status', 'aktif')
                ->where('periode', 'bulanan')
                ->get();

            foreach ($iurans as $iuran) {
                $exists = PembayaranIuran::where('penghuni_rumah_id', $request->penghuni_rumah_id)
                    ->where('iuran_id', $iuran->id)
                    ->where('bulan', $request->bulan)
                    ->where('tahun', $request->tahun)
                    ->exists();

                if (!$exists) {
                    PembayaranIuran::create([
                        'penghuni_rumah_id' => $request->penghuni_rumah_id,
                        'iuran_id' => $iuran->id,
                        'bulan' => $request->bulan,
                        'tahun' => $request->tahun,
                        'jumlah' => $iuran->jumlah,
                        'status' => 'belum lunas',
                        'tanggal_bayar' => null,
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('pembayaran-iuran.index')->with('success', 'Tagihan berhasil digenerate untuk penghuni yang dipilih.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('pembayaran-iuran.index')->with('error', 'Terjadi kesalahan saat generate tagihan.');
        }
    }

    public function edit($id)
    {
        $pembayaran = PembayaranIuran::findOrFail($id);
        $penghuniRumahs = PenghuniRumah::with('penghuni', 'rumah')->get();
        $iurans = Iuran::where('status', 'aktif')->get();

        return view('pembayaran-iuran.edit', compact('pembayaran', 'penghuniRumahs', 'iurans'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'penghuni_rumah_id' => 'required|exists:penghuni_rumahs,id',
            'iuran_id' => 'required|exists:iurans,id',
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer|min:2020',
            'status' => 'required|in:lunas,belum lunas',
        ]);

        $pembayaran = PembayaranIuran::findOrFail($id);

        // Ambil Iuran terkait
        $iuran = Iuran::findOrFail($request->iuran_id);

        $pembayaran->update([
            'penghuni_rumah_id' => $request->penghuni_rumah_id,
            'iuran_id' => $request->iuran_id,
            'bulan' => $request->bulan,
            'tahun' => $request->tahun,
            // Pakai jumlah dari Iuran, bukan dari input user
            'jumlah' => $iuran->jumlah,
            'status' => $request->status,
            'tanggal_bayar' => $request->status == 'lunas' ? now() : null,
        ]);

        return redirect()->route('pembayaran-iuran.index')->with('success', 'Tagihan berhasil diperbarui.');
    }


    public function updatePembayaran(Request $request, $id)
    {
        $pembayaran = PembayaranIuran::findOrFail($id);

        if ($pembayaran->status === 'lunas') {
            return redirect()->back()->with('info', 'Tagihan sudah lunas.');
        }

        $pembayaran->update([
            'status' => 'lunas',
            'tanggal_bayar' => now(),
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Pembayaran berhasil dilunasi.'
        ]);
    }

    public function destroy($id)
    {
        try {
            $pembayaran = PembayaranIuran::findOrFail($id);
            // Cek jika status sudah lunas, tidak boleh dihapus
            if ($pembayaran->status === 'lunas') {
                return response()->json([
                    'success' => false,
                    'message' => 'Tagihan yang sudah lunas tidak dapat dihapus.'
                ]);
            }

            $pembayaran->delete();

            return response()->json([
                'success' => true,
                'message' => 'Data tagihan berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus data tagihan.'
            ]);
        }
    }
}
