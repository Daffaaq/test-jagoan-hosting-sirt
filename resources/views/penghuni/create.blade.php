@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Tambah Penghuni</h6>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('penghuni.index') }}"
                            class="{{ request()->routeIs('penghuni.index') ? 'active' : '' }}">Penghuni Management</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('penghuni.create') }}"
                            class="{{ request()->routeIs('penghuni.create') ? 'active' : '' }}">Tambah Penghuni</a>
                    </li>
                </ol>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('penghuni.store') }}" enctype="multipart/form-data">
                    @csrf

                    <!-- Nama Lengkap -->
                    <div class="form-group">
                        <label for="nama_lengkap">Nama Lengkap:</label>
                        <input type="text" name="nama_lengkap" id="nama_lengkap" placeholder="Nama Lengkap"
                            class="form-control @error('nama_lengkap') is-invalid @enderror"
                            value="{{ old('nama_lengkap') }}">
                        @error('nama_lengkap')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Nomor Telepon -->
                    <div class="form-group">
                        <label for="nomor_telepon">Nomor Telepon:</label>
                        <input type="text" name="nomor_telepon" id="nomor_telepon" placeholder="08xxxxx"
                            class="form-control @error('nomor_telepon') is-invalid @enderror"
                            value="{{ old('nomor_telepon') }}">
                        @error('nomor_telepon')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Status Penghuni -->
                    <div class="form-group">
                        <label for="status_penghuni">Status Penghuni:</label>
                        <select name="status_penghuni" id="status_penghuni"
                            class="form-control @error('status_penghuni') is-invalid @enderror">
                            <option value="">-- Pilih Status --</option>
                            <option value="kontrak" {{ old('status_penghuni') == 'kontrak' ? 'selected' : '' }}>Kontrak
                            </option>
                            <option value="tetap" {{ old('status_penghuni') == 'tetap' ? 'selected' : '' }}>
                                Tetap</option>
                        </select>
                        @error('status_penghuni')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Status Menikah -->
                    <div class="form-group">
                        <label for="status_menikah">Status Menikah:</label>
                        <select name="status_menikah" id="status_menikah"
                            class="form-control @error('status_menikah') is-invalid @enderror">
                            <option value="">-- Pilih Status --</option>
                            <option value="menikah" {{ old('status_menikah') == 'menikah' ? 'selected' : '' }}>Menikah
                            </option>
                            <option value="belum menikah" {{ old('status_menikah') == 'belum menikah' ? 'selected' : '' }}>
                                Belum Menikah</option>
                        </select>
                        @error('status_menikah')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Upload Foto KTP -->
                    <div class="form-group">
                        <label for="foto_ktp">Foto KTP (Opsional):</label>
                        <input type="file" name="foto_ktp" id="foto_ktp"
                            class="form-control-file @error('foto_ktp') is-invalid @enderror">
                        @error('foto_ktp')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Buttons -->
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <a class="btn btn-secondary" href="{{ route('penghuni.index') }}">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
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
