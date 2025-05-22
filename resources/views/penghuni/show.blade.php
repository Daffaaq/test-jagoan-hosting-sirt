@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Detail Penghuni</h6>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('penghuni.index') }}" class="{{ request()->routeIs('penghuni.index') ? 'active' : '' }}">
                            Penghuni Management
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Detail Penghuni
                    </li>
                </ol>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Nama Lengkap:</strong><br>
                        {{ $penghuni->nama_lengkap }}
                    </div>
                    <div class="col-md-6">
                        <strong>Nomor Telepon:</strong><br>
                        {{ $penghuni->nomor_telepon }}
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Status Penghuni:</strong><br>
                        {{ ucfirst($penghuni->status_penghuni) }}
                    </div>
                    <div class="col-md-6">
                        <strong>Status Menikah:</strong><br>
                        {{ ucfirst($penghuni->status_menikah) }}
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-12">
                        <strong>Foto KTP:</strong><br>
                        @if ($penghuni->foto_ktp)
                            <img src="{{ asset('storage/' . $penghuni->foto_ktp) }}" alt="Foto KTP"
                                 class="img-thumbnail" width="300">
                        @else
                            <p class="text-muted">Tidak ada foto KTP.</p>
                        @endif
                    </div>
                </div>

                <a href="{{ route('penghuni.index') }}" class="btn btn-secondary">Kembali</a>
                <a href="{{ route('penghuni.edit', $penghuni->id) }}" class="btn btn-warning">Edit</a>
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
