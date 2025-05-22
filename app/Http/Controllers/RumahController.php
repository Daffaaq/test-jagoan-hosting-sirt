<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rumah;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\StoreRumahRequest;
use App\Http\Requests\UpdateRumahRequest;

class RumahController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:rumah.index')->only('index', 'list');
        $this->middleware('permission:rumah.create')->only('create', 'store');
        $this->middleware('permission:rumah.edit')->only('edit', 'update');
        $this->middleware('permission:rumah.destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     */
    public function list(Request $request)
    {
        if ($request->ajax()) {
            $rumah = Rumah::select(['id', 'nomor_rumah', 'status_huni']);
            return DataTables::of($rumah)
                ->addIndexColumn()
                ->make(true);
        }
    }

    public function index()
    {
        return view('rumah.index');
    }

    public function create()
    {
        return view('rumah.create');
    }

    public function store(StoreRumahRequest $request)
    {
        Rumah::create($request->validated());

        return redirect()->route('rumah.index')->with('success', 'Data Rumah berhasil ditambahkan.');
    }

    public function edit(Rumah $rumah)
    {
        return view('rumah.edit', compact('rumah'));
    }

    public function update(UpdateRumahRequest $request, Rumah $rumah)
    {
        $rumah->update($request->validated());

        return redirect()->route('rumah.index')->with('success', 'Data Rumah berhasil diupdate.');
    }

    public function destroy(Rumah $rumah)
    {
        try {
            $rumah->delete();
            return response()->json([
                'success' => true,
                'message' => 'Data Rumah berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus data Rumah.'
            ]);
        }
    }
}
