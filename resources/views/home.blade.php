@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800">Dashboard</h1>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="card shadow mb-4">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Saldo Bulanan</h6>
                @if ($needsUpdate)
                    <div class="alert alert-warning mt-2 mb-0">
                        <strong>Perhatian!</strong> Saldo bulan ini tidak sesuai dengan data terbaru. Klik
                        <strong>Buat/Update Saldo Bulan Ini</strong> untuk memperbarui.
                    </div>
                @endif
            </div>
            <div class="card-body">
                <form action="{{ route('dashboard.create-saldo') }}" method="POST">
                    @csrf
                    <input type="hidden" name="bulan" value="{{ now()->format('m') }}">
                    <input type="hidden" name="tahun" value="{{ now()->format('Y') }}">
                    <button type="submit" class="btn btn-primary mb-3">
                        <i class="fas fa-sync-alt"></i> Buat/Update Saldo Bulan Ini
                    </button>
                </form>

                @php
                    $bulanIndo = [
                        1 => 'Januari',
                        2 => 'Februari',
                        3 => 'Maret',
                        4 => 'April',
                        5 => 'Mei',
                        6 => 'Juni',
                        7 => 'Juli',
                        8 => 'Agustus',
                        9 => 'September',
                        10 => 'Oktober',
                        11 => 'November',
                        12 => 'Desember',
                    ];
                @endphp

                <div class="table-responsive">
                    <table class="table table-bordered" id="saldoTable" width="100%" cellspacing="0">
                        <thead class="thead-light">
                            <tr>
                                <th>No</th>
                                <th>Bulan</th>
                                <th>Tahun</th>
                                <th>Total Pemasukan</th>
                                <th>Total Pengeluaran</th>
                                <th>Saldo</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($saldos as $index => $saldo)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        {{ $bulanIndo[$saldo->bulan] }}
                                        @if ($saldo->bulan == now()->format('n') && $saldo->tahun == now()->format('Y'))
                                            <span class="badge badge-info ml-1">Bulan Ini</span>
                                        @endif
                                    </td>
                                    <td>{{ $saldo->tahun }}</td>
                                    <td>Rp {{ number_format($saldo->total_pemasukan, 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($saldo->total_pengeluaran, 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($saldo->saldo, 0, ',', '.') }}</td>
                                    <td>
                                        <form action="{{ route('dashboard.create-saldo') }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            <input type="hidden" name="bulan" value="{{ $saldo->bulan }}">
                                            <input type="hidden" name="tahun" value="{{ $saldo->tahun }}">
                                            <button class="btn btn-sm btn-warning" type="submit">
                                                <i class="fas fa-sync-alt"></i> Update
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <small class="text-muted mt-2 d-block">
                        Klik tombol <strong>Update</strong> untuk menghitung ulang saldo berdasarkan pemasukan dan
                        pengeluaran terbaru.
                    </small>
                </div>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Ringkasan Keuangan Tahun {{ now()->year }}</h6>
            </div>
            <div class="card-body">
                <canvas id="financialChart" width="400" height="200"></canvas>
            </div>
        </div>
        <div class="card shadow mb-4">
            <div class="card-header">
                <form id="filterForm" class="form-inline mb-3">
                    <div class="form-group mr-2">
                        <label for="bulan" class="mr-2">Bulan:</label>
                        <select name="bulan" id="bulan" class="form-control">
                            @foreach ($bulanIndo as $key => $val)
                                <option value="{{ str_pad($key, 2, '0', STR_PAD_LEFT) }}"
                                    {{ $bulan == str_pad($key, 2, '0', STR_PAD_LEFT) ? 'selected' : '' }}>
                                    {{ $val }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mr-2">
                        <label for="tahun" class="mr-2">Tahun:</label>
                        <select name="tahun" id="tahun" class="form-control">
                            @for ($y = date('Y'); $y >= 2020; $y--)
                                <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>
                                    {{ $y }}
                                </option>
                            @endfor
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Filter</button>
                </form>
            </div>
        </div>
        <div class="card shadow mb-4">

            <div id="detailKeuangan">
                @include('partials.detail-keuangan', [
                    'detailPemasukan' => $detailPemasukan,
                    'detailPengeluaran' => $detailPengeluaran,
                    'bulan' => $bulan,
                    'tahun' => $tahun,
                ])
            </div>
        </div>


    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        $(document).ready(function() {
            $('#pemasukanTable').DataTable();
            $('#pengeluaranTable').DataTable();
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#saldoTable').DataTable();
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetch('/dashboard/financial-data')
                .then(response => response.json())
                .then(data => {
                    const ctx = document.getElementById('financialChart').getContext('2d');
                    new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: data.labels,
                            datasets: [{
                                    label: 'Pemasukan',
                                    data: data.income,
                                    borderColor: 'rgb(75, 192, 192)',
                                    fill: false,
                                },
                                {
                                    label: 'Pengeluaran',
                                    data: data.expenses,
                                    borderColor: 'rgb(255, 99, 132)',
                                    fill: false,
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                x: {
                                    title: {
                                        display: true,
                                        text: 'Bulan'
                                    }
                                },
                                y: {
                                    title: {
                                        display: true,
                                        text: 'Jumlah (Rp)'
                                    }
                                }
                            }
                        }
                    });
                });
        });
    </script>
    <script>
        $('#filterForm').on('submit', function(e) {
            e.preventDefault();
            let bulan = $('#bulan').val();
            let tahun = $('#tahun').val();

            $.ajax({
                url: "{{ route('dashboard.filter-detail') }}",
                method: "GET",
                data: {
                    bulan: bulan,
                    tahun: tahun
                },
                beforeSend: function() {
                    $('#detailKeuangan').html('<div class="text-center">Loading...</div>');
                },
                success: function(response) {
                    $('#detailKeuangan').html(response);
                    $('#pemasukanTable').DataTable();
                    $('#pengeluaranTable').DataTable();
                },
                error: function() {
                    alert('Gagal memuat data');
                }
            });
        });
    </script>
@endpush
