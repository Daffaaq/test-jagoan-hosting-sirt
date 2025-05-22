<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penghuni;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\StorePenghuniRequest;
use App\Http\Requests\UpdatePenghuniRequest;
use Illuminate\Support\Facades\Storage;

class PenghuniController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:penghuni.index')->only('index', 'list');
        $this->middleware('permission:penghuni.create')->only('create', 'store');
        $this->middleware('permission:penghuni.edit')->only('edit', 'update');
        $this->middleware('permission:penghuni.destroy')->only('destroy');
    }

    /**
     * Display a listing of the resource (via DataTables).
     */
    public function list(Request $request)
    {
        if ($request->ajax()) {
            $penghuni = Penghuni::select(['id', 'nama_lengkap', 'nomor_telepon', 'status_penghuni']);
            return DataTables::of($penghuni)
                ->addIndexColumn()
                ->make(true);
        }
    }

    public function index()
    {
        return view('penghuni.index');
    }

    public function create()
    {
        return view('penghuni.create');
    }

    public function store(StorePenghuniRequest $request)
    {
        $data = $request->validated();

        // Jika ada upload foto_ktp, simpan ke storage
        if ($request->hasFile('foto_ktp')) {
            $data['foto_ktp'] = $request->file('foto_ktp')->store('ktp', 'public');
        }

        Penghuni::create($data);

        return redirect()->route('penghuni.index')->with('success', 'Data Penghuni berhasil ditambahkan.');
    }

    public function show(Penghuni $penghuni)
    {
        return view('penghuni.show', compact('penghuni'));
    }

    public function edit(Penghuni $penghuni)
    {
        return view('penghuni.edit', compact('penghuni'));
    }

    public function update(UpdatePenghuniRequest $request, Penghuni $penghuni)
    {
        $data = $request->validated();

        // Jika ada file baru, upload & ganti yang lama
        if ($request->hasFile('foto_ktp')) {
            // Hapus file lama (optional)
            if ($penghuni->foto_ktp && Storage::disk('public')->exists($penghuni->foto_ktp)) {
                Storage::disk('public')->delete($penghuni->foto_ktp);
            }

            $data['foto_ktp'] = $request->file('foto_ktp')->store('ktp', 'public');
        }

        $penghuni->update($data);

        return redirect()->route('penghuni.index')->with('success', 'Data Penghuni berhasil diperbarui.');
    }

    public function destroy(Penghuni $penghuni)
    {
        try {
            $penghuni->delete();
            return response()->json([
                'success' => true,
                'message' => 'Data Penghuni berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus data Penghuni.'
            ]);
        }
    }
}
