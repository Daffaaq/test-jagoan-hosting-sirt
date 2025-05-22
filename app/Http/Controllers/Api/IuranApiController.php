<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreIuranRequest;
use App\Http\Requests\UpdateIuranRequest;
use App\Models\Iuran;

class IuranApiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    // Get /api/iuran
    public function index()
    {
        $data = Iuran::all();
        return response()->json([
            'success' => true,
            'message' => 'List semua iuran',
            'data' => $data,
        ]);
    }

    // POST /api/iuran
    public function store(StoreIuranRequest $request)
    {
        $iuran = Iuran::create($request->validated());
        return response()->json([
            'success' => true,
            'message' => 'Iuran berhasil ditambahkan',
            'data' => $iuran,
        ], 201);
    }

    // GET /api/iuran/{id}
    public function show($id)
    {
        $iuran = Iuran::find($id);
        if (!$iuran) {
            return response()->json([
                'success' => false,
                'message' => 'Iuran tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $iuran,
        ]);
    }

    // PUT/PATCH /api/iuran/{id}
    public function update(UpdateIuranRequest $request, $id)
    {
        $iuran = Iuran::find($id);
        if (!$iuran) {
            return response()->json([
                'success' => false,
                'message' => 'Iuran tidak ditemukan',
            ], 404);
        }

        $iuran->update($request->validated());
        return response()->json([
            'success' => true,
            'message' => 'Iuran berhasil diupdate',
            'data' => $iuran,
        ]);
    }

    // DELETE /api/iuran/{id}
    public function destroy($id)
    {
        $iuran = Iuran::find($id);
        if (!$iuran) {
            return response()->json([
                'success' => false,
                'message' => 'Iuran tidak ditemukan',
            ], 404);
        }

        $iuran->delete();
        return response()->json([
            'success' => true,
            'message' => 'Iuran berhasil dihapus',
        ]);
    }
}
