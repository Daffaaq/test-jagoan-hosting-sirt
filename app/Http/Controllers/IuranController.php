<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Iuran;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\StoreIuranRequest;
use App\Http\Requests\UpdateIuranRequest;

class IuranController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:iuran.index')->only('index', 'list');
        $this->middleware('permission:iuran.create')->only('create', 'store');
        $this->middleware('permission:iuran.edit')->only('edit', 'update');
        $this->middleware('permission:iuran.destroy')->only('destroy');
    }

    /**
     * Display a listing of the resource (via DataTables).
     */
    public function list(Request $request)
    {
        if ($request->ajax()) {
            $iuran = Iuran::select(['id', 'jenis', 'jumlah', 'periode','status']);
            return DataTables::of($iuran)
                ->addIndexColumn()
                ->make(true);
        }
    }

    /**
     * Show the list of iuran.
     */
    public function index()
    {
        return view('iuran.index');
    }

    /**
     * Show the form for creating a new iuran.
     */
    public function create()
    {
        return view('iuran.create');
    }

    /**
     * Store a newly created iuran in the database.
     */
    public function store(StoreIuranRequest $request)
    {
        Iuran::create($request->validated());

        return redirect()->route('iuran.index')->with('success', 'Data Iuran berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified iuran.
     */
    public function edit(Iuran $iuran)
    {
        return view('iuran.edit', compact('iuran'));
    }

    /**
     * Update the specified iuran in the database.
     */
    public function update(UpdateIuranRequest $request, Iuran $iuran)
    {
        $iuran->update($request->validated());

        return redirect()->route('iuran.index')->with('success', 'Data Iuran berhasil diperbarui.');
    }

    /**
     * Remove the specified iuran from the database.
     */
    public function destroy(Iuran $iuran)
    {
        try {
            $iuran->delete();
            return response()->json([
                'success' => true,
                'message' => 'Data Iuran berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus data Iuran.'
            ]);
        }
    }
}
