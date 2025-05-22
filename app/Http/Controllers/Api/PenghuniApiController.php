<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePenghuniRequest;
use App\Http\Requests\UpdatePenghuniRequest;
use App\Models\Penghuni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PenghuniApiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    // GET /api/penghuni
    public function index()
    {
        $data = Penghuni::all();
        return response()->json([
            'success' => true,
            'message' => 'List semua iuran',
            'data' => $data,
        ], 200);
    }

    // POST /api/penghuni
    public function store(StorePenghuniRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('foto_ktp')) {
            $data['foto_ktp'] = $request->file('foto_ktp')->store('ktp', 'public');
        }

        $penghuni = Penghuni::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Penghuni berhasil ditambahkan.',
            'data' => $penghuni
        ], 201);
    }

    // GET /api/penghuni/{id}
    public function show(Penghuni $penghuni)
    {
        $data = $penghuni;
        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Penghuni tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail penghuni',
            'data' => $data
        ], 200);
    }

    // PUT /api/penghuni/{id}
    public function update(UpdatePenghuniRequest $request, Penghuni $penghuni)
    {
        $data = $request->validated();

        if ($request->hasFile('foto_ktp')) {
            if ($penghuni->foto_ktp && Storage::disk('public')->exists($penghuni->foto_ktp)) {
                Storage::disk('public')->delete($penghuni->foto_ktp);
            }

            $data['foto_ktp'] = $request->file('foto_ktp')->store('ktp', 'public');
        }

        $penghuni->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Penghuni berhasil diperbarui.',
            'data' => $penghuni
        ], 200);
    }

    // DELETE /api/penghuni/{id}
    public function destroy(Penghuni $penghuni)
    {
        $penghuni->delete();
        if (!$penghuni) {
            return response()->json([
                'success' => false,
                'message' => 'Penghuni tidak ditemukan',
            ], 404);
        }
        return response()->json([
            'success' => true,
            'message' => 'Penghuni berhasil dihapus',
        ], 200);
    }
}
