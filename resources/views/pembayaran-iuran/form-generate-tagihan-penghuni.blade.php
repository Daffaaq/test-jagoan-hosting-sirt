@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Generate Tagihan Penghuni Baru</h6>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('pembayaran-iuran.index') }}"
                            class="{{ request()->routeIs('pembayaran-iuran.index') ? 'active' : '' }}">
                            Pembayaran Iuran
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('pembayaran-iuran.form-generate-tagihan-penghuni') }}"
                            class="{{ request()->routeIs('pembayaran-iuran.form-generate-tagihan-penghuni') ? 'active' : '' }}">
                            Generate Tagihan Penghuni Baru
                        </a>
                    </li>
                </ol>
            </div>

            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @elseif(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <form method="POST" action="{{ route('pembayaran-iuran.generate-tagihan-penghuni') }}">
                    @csrf

                    <!-- Penghuni Rumah -->
                    <div class="form-group">
                        <label for="penghuni_rumah_id">Penghuni Rumah:</label>
                        <select name="penghuni_rumah_id" id="penghuni_rumah_id"
                            class="form-control @error('penghuni_rumah_id') is-invalid @enderror" required>
                            <option value="">-- Pilih Penghuni --</option>
                            @foreach ($penghuniRumahs as $pr)
                                <option value="{{ $pr->id }}"
                                    {{ old('penghuni_rumah_id') == $pr->id ? 'selected' : '' }}>
                                    {{ $pr->penghuni->nama_lengkap ?? 'N/A' }} - {{ $pr->penghuni->status_penghuni ?? 'N/A' }} - Rumah {{ $pr->rumah->nomor_rumah ?? 'N/A' }}
                                </option>
                            @endforeach
                        </select>
                        @error('penghuni_rumah_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Bulan -->
                    <div class="form-group">
                        <label for="bulan">Bulan:</label>
                        <select name="bulan" id="bulan" class="form-control @error('bulan') is-invalid @enderror">
                            @for ($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}" {{ old('bulan') == $i ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                                </option>
                            @endfor
                        </select>
                        @error('bulan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Tahun -->
                    <div class="form-group">
                        <label for="tahun">Tahun:</label>
                        <input type="number" name="tahun" id="tahun"
                            class="form-control @error('tahun') is-invalid @enderror"
                            value="{{ old('tahun', now()->year) }}" placeholder="Contoh: 2025" min="2020" required>
                        @error('tahun')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Buttons -->
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <a href="{{ route('pembayaran-iuran.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Generate</button>
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
