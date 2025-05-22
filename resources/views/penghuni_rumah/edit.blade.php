@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Edit Penghuni Rumah</h6>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('rumah.index') }}">Rumah Management</a>
                    </li>
                    <li class="breadcrumb-item active">Edit Penghuni Rumah</li>
                </ol>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('rumah.penghuni.update', $penghuniRumah->id) }}">
                    @csrf
                    @method('PUT')

                    <!-- Pilih Penghuni -->
                    <div class="form-group">
                        <label for="penghuni_id">Penghuni:</label>
                        <select name="penghuni_id" id="penghuni_id" class="form-control @error('penghuni_id') is-invalid @enderror">
                            <option value="">-- Pilih Penghuni --</option>
                            @foreach ($penghunis as $penghuni)
                                <option value="{{ $penghuni->id }}"
                                    {{ old('penghuni_id', $penghuniRumah->penghuni_id) == $penghuni->id ? 'selected' : '' }}>
                                    {{ $penghuni->nama_lengkap }} ({{ $penghuni->status_penghuni }})
                                </option>
                            @endforeach
                        </select>
                        @error('penghuni_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Tanggal Mulai -->
                    <div class="form-group">
                        <label for="tanggal_mulai">Tanggal Mulai:</label>
                        <input type="date" name="tanggal_mulai" id="tanggal_mulai"
                            class="form-control @error('tanggal_mulai') is-invalid @enderror"
                            value="{{ old('tanggal_mulai', $penghuniRumah->tanggal_mulai) }}">
                        @error('tanggal_mulai')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Tanggal Selesai -->
                    <div class="form-group">
                        <label for="tanggal_selesai">Tanggal Selesai:</label>
                        <input type="date" name="tanggal_selesai" id="tanggal_selesai"
                            class="form-control @error('tanggal_selesai') is-invalid @enderror"
                            value="{{ old('tanggal_selesai', $penghuniRumah->tanggal_selesai) }}">
                        @error('tanggal_selesai')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Tombol -->
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <a href="{{ route('rumah.penghuni', $penghuniRumah->rumah_id) }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">Update</button>
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

        .breadcrumb-item.active {
            font-weight: bold;
            color: #007bff;
        }
    </style>
@endpush
