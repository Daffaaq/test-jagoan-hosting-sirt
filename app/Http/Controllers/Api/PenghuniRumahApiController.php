<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePenghuniRumahRequest;
use App\Http\Requests\UpdatePenghuniRumahRequest;
use App\Models\PenghuniRumah;
use App\Models\Rumah;
use Illuminate\Http\Request;

class PenghuniRumahApiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    // GET /api/rumah/{id}/penghuni
    public function index($id)
    {
        $rumah = Rumah::findOrFail($id);
        $penghuniRumah = PenghuniRumah::with('penghuni')->where('rumah_id', $rumah->id)->get();
        return response()->json([
            'success' => true,
            'message' => 'List semua Penghuni rumah' . $rumah->nomor_rumah,
            'data' => $penghuniRumah,
        ], 200);
    }

    // POST /api/rumah/{id}/penghuni
    public function store(StorePenghuniRumahRequest $request, $id)
    {
        $rumah = Rumah::findOrFail($id);

        if ($rumah->status_huni === 'dihuni') {
            return response()->json([
                'message' => 'Rumah sudah dihuni.'
            ], 400);
        }

        $penghuniRumah = PenghuniRumah::create([
            'rumah_id' => $rumah->id,
            'penghuni_id' => $request->penghuni_id,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai
        ]);

        $rumah->update(['status_huni' => 'dihuni']);

        return response()->json([
            'message' => 'Penghuni rumah berhasil ditambahkan.',
            'data' => $penghuniRumah
        ], 201);
    }

    // GET /api/penghuni-rumah/{id}
    public function show($id)
    {
        $penghuniRumah = PenghuniRumah::with('penghuni', 'rumah')->findOrFail($id);

        return response()->json($penghuniRumah, 200);
    }

    // PUT /api/penghuni-rumah/{id}
    public function update(UpdatePenghuniRumahRequest $request, $id)
    {
        $penghuniRumah = PenghuniRumah::findOrFail($id);

        $penghuniRumah->update([
            'penghuni_id' => $request->penghuni_id,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai
        ]);

        return response()->json([
            'message' => 'Data penghuni rumah berhasil diperbarui.',
            'data' => $penghuniRumah
        ], 200);
    }

    // DELETE /api/penghuni-rumah/{id}
    public function destroy($id)
    {
        $penghuniRumah = PenghuniRumah::findOrFail($id);
        $penghuniRumah->delete();

        return response()->json([
            'message' => 'Data penghuni rumah berhasil dihapus.'
        ], 200);
    }
}
