@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Rumah Management</h6>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('rumah.index') }}"
                            class="{{ request()->routeIs('rumah.index') ? 'active' : '' }}">Rumah Management</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('rumah.create') }}"
                            class="{{ request()->routeIs('rumah.create') ? 'active' : '' }}">Tambah Rumah</a>
                    </li>
                </ol>
            </div>
            <div class="card-body">
                <!-- Rumah Create Form -->
                <form method="POST" action="{{ route('rumah.store') }}">
                    @csrf

                    <!-- Nomor Rumah -->
                    <div class="form-group">
                        <label for="nomor_rumah">Nomor Rumah:</label>
                        <input type="text" name="nomor_rumah" id="nomor_rumah" placeholder="Contoh: A1"
                            class="form-control @error('nomor_rumah') is-invalid @enderror"
                            value="{{ old('nomor_rumah') }}">
                        @error('nomor_rumah')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Status Huni -->
                    <div class="form-group">
                        <label for="status_huni">Status Huni:</label>
                        <select name="status_huni" id="status_huni"
                            class="form-control @error('status_huni') is-invalid @enderror">
                            <option value="">-- Pilih Status --</option>
                            <option value="dihuni" {{ old('status_huni') == 'dihuni' ? 'selected' : '' }}>Dihuni</option>
                            <option value="tidak dihuni" {{ old('status_huni') == 'tidak dihuni' ? 'selected' : '' }}>Tidak Dihuni</option>
                        </select>
                        @error('status_huni')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <a class="btn btn-secondary" href="{{ route('rumah.index') }}">Batal</a>
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
