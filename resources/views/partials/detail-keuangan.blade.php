<div class="card-header">
    <h6 class="m-0 font-weight-bold text-primary">
        Detail Keuangan Bulan {{ $bulan }}/{{ $tahun }}
    </h6>
</div>

<div class="card-body">
    {{-- TABEL PEMASUKAN --}}
    <h5 class="mb-3">Pemasukan</h5>
    <table class="table table-bordered table-striped mb-5" id="pemasukanTable">
        <thead>
            <tr>
                <th>Nama Penghuni</th>
                <th>Jumlah (Rp)</th>
                <th>Status</th>
                <th>Tanggal Bayar</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($detailPemasukan as $p)
                <tr>
                    <td>{{ $p->penghuniRumah->penghuni->nama_lengkap }}</td>
                    <td>Rp {{ number_format($p->jumlah, 0, ',', '.') }}</td>
                    <td>{{ ucfirst($p->status) }}</td>
                    <td>{{ $p->tanggal_bayar ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">Tidak ada data pemasukan</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- TABEL PENGELUARAN --}}
    <h5 class="mb-3">Pengeluaran</h5>
    <table class="table table-bordered table-striped" id="pengeluaranTable">
        <thead>
            <tr>
                <th>No</th>
                <th>Kategori</th>
                <th>Jumlah (Rp)</th>
                <th>Tanggal</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($detailPengeluaran as $peng)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $peng->kategori }}</td>
                    <td>Rp {{ number_format($peng->jumlah, 0, ',', '.') }}</td>
                    <td>{{ $peng->tanggal }}</td>
                    <td>{{ $peng->keterangan ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Tidak ada data pengeluaran</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
