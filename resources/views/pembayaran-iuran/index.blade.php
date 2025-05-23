@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Pembayaran Iuran</h6>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('pembayaran-iuran.index') }}"
                            class="{{ request()->routeIs('pembayaran-iuran.index') ? 'active' : '' }}">
                            Pembayaran Iuran
                        </a>
                    </li>
                </ol>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-end mb-3">
                    <a href="{{ route('generate-tagihan.form') }}"
                        class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm mr-2">
                        <i class="fas fa-plus fa-sm text-white-50"></i> Auto Generate Tagihan
                    </a>
                    <a href="{{ route('pembayaran-iuran.form-generate-tagihan-penghuni') }}"
                        class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                        <i class="fas fa-plus fa-sm text-white-50"></i> Generate Tagihan Penghuni Baru
                    </a>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered" id="IuranTables" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Penghuni</th>
                                <th>Nomor Rumah</th>
                                <th>Jenis Iuran</th>
                                <th>Periode</th>
                                <th>Bulan</th>
                                <th>Tahun</th>
                                <th>Jumlah</th>
                                <th>Status</th>
                                <th>Tanggal Bayar</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- DataTables will fill this -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#IuranTables').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('pembayaran-iuran.list') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'penghuni_rumah.penghuni.nama_lengkap',
                        name: 'penghuni_rumah.penghuni.nama_lengkap',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'penghuni_rumah.rumah.nomor_rumah',
                        name: 'penghuni_rumah.rumah.nomor_rumah',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'iuran.jenis',
                        name: 'iuran.jenis'
                    },
                    {
                        data: 'iuran.periode',
                        name: 'iuran.periode'
                    },
                    {
                        data: 'bulan',
                        name: 'bulan'
                    },
                    {
                        data: 'tahun',
                        name: 'tahun'
                    },
                    {
                        data: 'jumlah',
                        name: 'jumlah'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        render: function(data) {
                            if (data == 'lunas') {
                                return `<span class="badge badge-success">${data}</span>`;
                            } else {
                                return `<span class="badge badge-danger">${data}</span>`;
                            }
                        }
                    },
                    {
                        data: 'tanggal_bayar',
                        name: 'tanggal_bayar'
                    },
                    {
                        data: 'id',
                        name: 'id',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            let showUrl = `/transaksi-management/pembayaran-iuran/${data}`;
                            let editUrl = `/transaksi-management/pembayaran-iuran/${data}/edit`;
                            let lunasButton = '';

                            if (row.status === 'belum lunas') {
                                lunasButton = `
                <button class="btn icon btn-sm btn-success btn-lunas" onclick="confirmLunas('${data}')" data-bs-toggle="tooltip" title="Lunasi Tagihan">
                    <i class="bi bi-check-circle"></i>
                </button>
            `;
                            }

                            return `
            <a href="${showUrl}" class="btn icon btn-sm btn-info" data-bs-toggle="tooltip" title="Lihat Detail"><i class="bi bi-eye"></i></a>
            <a href="${editUrl}" class="btn icon btn-sm btn-warning" data-bs-toggle="tooltip" title="Edit Tagihan"><i class="bi bi-pencil"></i></a>
            ${lunasButton}
            <button class="btn icon btn-sm btn-danger" onclick="confirmDelete('${data}')" data-bs-toggle="tooltip" title="Hapus Tagihan"><i class="bi bi-trash"></i></button>
        `;
                        }
                    }
                ]
            });
            $(function() {
                $('[data-bs-toggle="tooltip"]').tooltip();
            });

            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: '{{ session('success') }}',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                });
            @endif
            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: '{{ session('error') }}',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                });
            @endif
        });

        function confirmDelete(id) {
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: "Data akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/transaksi-management/pembayaran-iuran/' + id,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Swal.fire('Berhasil!', response.message, 'success');
                            $('#IuranTables').DataTable().ajax.reload();
                        },
                        error: function() {
                            Swal.fire('Gagal!', 'Tidak dapat menghapus data.', 'error');
                        }
                    });
                }
            });
        }

        function confirmLunas(id) {
            Swal.fire({
                title: 'Yakin ingin menandai sebagai lunas?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, tandai lunas!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/transaksi-management/pembayaran-iuran/' + id + '/lunas',
                        type: 'PATCH',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Swal.fire('Berhasil!', response.message, 'success');
                            $('#IuranTables').DataTable().ajax.reload();
                        },
                        error: function() {
                            Swal.fire('Gagal!', 'Tidak dapat menandai sebagai lunas.', 'error');
                        }
                    });
                }
            });
        }
    </script>
@endpush
