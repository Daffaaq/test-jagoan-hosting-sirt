<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePengeluaranRequest;
use App\Http\Requests\UpdatePengeluaranRequest;
use App\Models\Pengeluaran;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class PengeluaranController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:pengeluaran.index')->only('index', 'list');
        $this->middleware('permission:pengeluaran.create')->only('create', 'store');
        $this->middleware('permission:pengeluaran.edit')->only('edit', 'update');
        $this->middleware('permission:pengeluaran.destroy')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function list(Request $request)
    {
        if ($request->ajax()) {
            $pengeluaran = Pengeluaran::select(['id', 'kategori', 'jumlah', 'tanggal', 'keterangan']);
            return DataTables::of($pengeluaran)
                ->addIndexColumn()
                ->make(true);
        }
    }

    public function index()
    {
        return view('pengeluaran.index');
    }

    public function create()
    {
        return view('pengeluaran.create');
    }

    public function store(StorePengeluaranRequest $request)
    {
        Pengeluaran::create($request->validated());

        return redirect()->route('pengeluaran.index')->with('success', 'Data Pengeluaran berhasil ditambahkan.');
    }

    public function edit(Pengeluaran $pengeluaran)
    {
        return view('pengeluaran.edit', compact('pengeluaran'));
    }

    public function update(UpdatePengeluaranRequest $request, Pengeluaran $pengeluaran)
    {
        $pengeluaran->update($request->validated());

        return redirect()->route('pengeluaran.index')->with('success', 'Data Pengeluaran berhasil diupdate.');
    }

    public function destroy(Pengeluaran $pengeluaran)
    {
        try {
            $pengeluaran->delete();
            return response()->json([
                'success' => true,
                'message' => 'Data Pengeluaran berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus data Pengeluaran.'
            ]);
        }
    }
}
