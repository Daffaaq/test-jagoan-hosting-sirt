<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePenghuniRumahRequest;
use App\Http\Requests\UpdatePenghuniRumahRequest;
use App\Models\PenghuniRumah;
use App\Models\Rumah;
use App\Models\Penghuni;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PenghuniRumahController extends Controller
{
    public function listPenghuniRumah($id)
    {
        $rumah = Rumah::findorfail($id);
        $penghuniRumah = PenghuniRumah::with('penghuni')->where('rumah_id', $rumah->id)->get();
        return DataTables::of($penghuniRumah)
            ->addIndexColumn()
            ->make(true);
    }
    public function createPenghuni($id)
    {
        $rumah = Rumah::findorfail($id);
        $penghunis = Penghuni::select('id', 'nama_lengkap', 'status_penghuni')->get();
        return view('penghuni_rumah.create', compact('penghunis', 'rumah'));
    }

    public function storePenghuni(StorePenghuniRumahRequest $request, $id)
    {
        $rumah = Rumah::findorfail($id);
        if ($rumah->status_huni == 'dihuni') {
            return redirect()->route('rumah.penghuni', $id)->with('info', 'Rumah sudah dihuni');
        }
        $penghuniRumah = PenghuniRumah::create([
            'rumah_id' => $rumah->id,
            'penghuni_id' => $request->penghuni_id,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai
        ]);
        //status_huni update 
        $rumah->update([
            'status_huni' => 'dihuni'
        ]);

        return redirect()->route('rumah.penghuni', $id)->with('success', 'Data penghuni rumah berhasil ditambahkan.');
    }

    public function editPenghuni($id)
    {
        $penghuniRumah = PenghuniRumah::findorfail($id);
        $penghunis = Penghuni::select('id', 'nama_lengkap', 'status_penghuni')->get();
        return view('penghuni_rumah.edit', compact('penghuniRumah', 'penghunis'));
    }

    public function updatePenghuni(UpdatePenghuniRumahRequest $request, $id)
    {
        $penghuniRumah = PenghuniRumah::findorfail($id);
        $rumah = Rumah::findorfail($penghuniRumah->rumah_id);
        $penghuniRumah->update([
            'penghuni_id' => $request->penghuni_id,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai
        ]);
        return redirect()->route('rumah.penghuni', $rumah->id)->with('success', 'Data penghuni rumah berhasil diperbarui.');
    }

    public function destroyPenghuni($id)
    {
        $PenghuniRumah = PenghuniRumah::findorfail($id);
        $rumah = Rumah::findorfail($PenghuniRumah->rumah_id);
        $PenghuniRumah->delete();
        //return json
        return response()->json(['success' => 'Data penghuni rumah berhasil dihapus.']);
    }
}
