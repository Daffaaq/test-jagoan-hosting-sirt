<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Rumah;
use App\Http\Requests\StoreRumahRequest;
use App\Http\Requests\UpdateRumahAPIRequest;
use App\Http\Requests\UpdateRumahRequest;
use Illuminate\Http\Request;

class RumahApiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum'); // Jaga dengan token
    }

    // GET /api/rumah
    public function index()
    {
        $data = Rumah::all();
        return response()->json([
            'success' => true,
            'message' => 'List semua rumah',
            'data' => $data,
        ]);
    }

    // POST /api/rumah
    public function store(StoreRumahRequest $request)
    {
        $rumah = Rumah::create($request->validated());
        return response()->json([
            'success' => true,
            'message' => 'Rumah berhasil ditambahkan',
            'data' => $rumah,
        ], 201);
    }

    // GET /api/rumah/{id}
    public function show($id)
    {
        $rumah = Rumah::find($id);
        if (!$rumah) {
            return response()->json([
                'success' => false,
                'message' => 'Rumah tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $rumah,
        ]);
    }

    // PUT/PATCH /api/rumah/{id}
    public function update(UpdateRumahAPIRequest $request, $id)
    {
        $rumah = Rumah::find($id);
        if (!$rumah) {
            return response()->json([
                'success' => false,
                'message' => 'Rumah tidak ditemukan',
            ], 404);
        }

        $rumah->update($request->validated());
        return response()->json([
            'success' => true,
            'message' => 'Rumah berhasil diupdate',
            'data' => $rumah,
        ]);
    }

    // DELETE /api/rumah/{id}
    public function destroy($id)
    {
        $rumah = Rumah::find($id);
        if (!$rumah) {
            return response()->json([
                'success' => false,
                'message' => 'Rumah tidak ditemukan',
            ], 404);
        }

        $rumah->delete();
        return response()->json([
            'success' => true,
            'message' => 'Rumah berhasil dihapus',
        ]);
    }
}
