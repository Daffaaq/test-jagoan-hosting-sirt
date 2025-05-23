@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Edit Tagihan Iuran</h6>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('pembayaran-iuran.index') }}"
                            class="{{ request()->routeIs('pembayaran-iuran.index') ? 'active' : '' }}">Tagihan Iuran</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('pembayaran-iuran.edit', $pembayaran->id) }}"
                            class="{{ request()->routeIs('pembayaran-iuran.edit') ? 'active' : '' }}">Edit Tagihan</a>
                    </li>
                </ol>
            </div>
            <div class="card-body">
                <!-- Edit Form -->
                <form method="POST" action="{{ route('pembayaran-iuran.update', $pembayaran->id) }}">
                    @csrf
                    @method('PUT')

                    <!-- Penghuni Rumah -->
                    <div class="form-group">
                        <label for="penghuni_rumah_id">Penghuni Rumah:</label>
                        <select name="penghuni_rumah_id" id="penghuni_rumah_id"
                            class="form-control @error('penghuni_rumah_id') is-invalid @enderror">
                            <option value="">-- Pilih Penghuni --</option>
                            @foreach ($penghuniRumahs as $pr)
                                <option value="{{ $pr->id }}"
                                    {{ old('penghuni_rumah_id', $pembayaran->penghuni_rumah_id) == $pr->id ? 'selected' : '' }}>
                                    {{ $pr->penghuni->nama ?? '-' }} - {{ $pr->rumah->nomor_rumah ?? '-' }}
                                </option>
                            @endforeach
                        </select>
                        @error('penghuni_rumah_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Iuran -->
                    <div class="form-group">
                        <label for="iuran_id">Jenis Iuran:</label>
                        <select name="iuran_id" id="iuran_id" class="form-control @error('iuran_id') is-invalid @enderror">
                            <option value="">-- Pilih Iuran --</option>
                            @foreach ($iurans as $iuran)
                                <option value="{{ $iuran->id }}"
                                    {{ old('iuran_id', $pembayaran->iuran_id) == $iuran->id ? 'selected' : '' }}>
                                    {{ $iuran->jenis }} (Rp{{ number_format($iuran->jumlah) }})
                                </option>
                            @endforeach
                        </select>
                        @error('iuran_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Bulan -->
                    <div class="form-group">
                        <label for="bulan">Bulan:</label>
                        <input type="number" name="bulan" id="bulan" min="1" max="12"
                            class="form-control @error('bulan') is-invalid @enderror"
                            value="{{ old('bulan', $pembayaran->bulan) }}">
                        @error('bulan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Tahun -->
                    <div class="form-group">
                        <label for="tahun">Tahun:</label>
                        <input type="number" name="tahun" id="tahun" min="2020"
                            class="form-control @error('tahun') is-invalid @enderror"
                            value="{{ old('tahun', $pembayaran->tahun) }}">
                        @error('tahun')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Jumlah -->
                    <div class="form-group">
                        <label for="jumlah">Jumlah (Rp):</label>
                        <p id="jumlah-display">Rp {{ number_format($pembayaran->iuran->jumlah ?? 0) }}</p>
                    </div>

                    <!-- Status -->
                    <div class="form-group">
                        <label for="status">Status:</label>
                        <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
                            <option value="">-- Pilih Status --</option>
                            <option value="belum lunas"
                                {{ old('status', $pembayaran->status) == 'belum lunas' ? 'selected' : '' }}>Belum Lunas
                            </option>
                            <option value="lunas" {{ old('status', $pembayaran->status) == 'lunas' ? 'selected' : '' }}>
                                Lunas</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Submit -->
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <a class="btn btn-secondary" href="{{ route('pembayaran-iuran.index') }}">Batal</a>
                            <button type="submit" class="btn btn-primary">Update Tagihan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .breadcrumb {
            background-color: transparent;
            padding: 0;
            margin-bottom: 0;
        }

        .breadcrumb-item {
            font-size: 0.875rem;
        }

        .breadcrumb-item a {
            color: #464646;
            text-decoration: none;
        }

        .breadcrumb-item a:hover {
            text-decoration: underline;
        }

        .breadcrumb-item a.active {
            font-weight: bold;
            color: #007bff;
            pointer-events: none;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Data iuran dan jumlahnya dari backend
            const iurans = @json($iurans->mapWithKeys(fn($i) => [$i->id => $i->jumlah]));

            const iuranSelect = document.getElementById('iuran_id');
            const jumlahDisplay = document.getElementById('jumlah-display');

            function updateJumlah() {
                const selectedId = iuranSelect.value;
                if (selectedId && iurans[selectedId] !== undefined) {
                    // Format ke rupiah, misal simple
                    const formatted = new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR'
                    }).format(iurans[selectedId]);
                    jumlahDisplay.textContent = formatted;
                } else {
                    jumlahDisplay.textContent = 'Rp 0';
                }
            }

            iuranSelect.addEventListener('change', updateJumlah);

            // Inisialisasi saat halaman load
            updateJumlah();
        });
    </script>
@endpush
