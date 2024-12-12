@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Daftar Tugas yang Terdapat dalam Sistem</h3>
            <div class="card-tools">
                <button onclick="modalAction('{{ url('tugas/create_ajax') }}')" class="btn btn-sm btn-success mt-1">Tambah
                    Data</button>
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Filter:</label>
                        <div class="col-3">
                            <select class="form-control" id="kategori_id" name="kategori_id">
                                <option value="">- Semua -</option>
                                @foreach ($kategoris as $kategori)
                                    <option value="{{ $kategori->kategori_id }}">{{ $kategori->kategori_nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <small class="form-text text-muted">Kategori Soal </small>
                    </div>
                </div>
            </div>
            <table class="table table-bordered table-striped table-hover table-sm" id="table_tugas">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Tugas</th>
                        <th>Nama</th>
                        <th>Deskripsi</th>
                        <th>Jam Kompen</th>
                        <th>Status</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Akhir</th>
                        <th>Kategori</th>
                        <th>SDM</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" databackdrop="static"
        data-keyboard="false" data-width="75%" aria-hidden="true"></div>
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
@endpush

@push('js')
    <script>
        function modalAction(url) {
            $('#myModal').load(url, function() {
                $('#myModal').modal('show');
            });
        }

        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var dataTugas = $('#table_tugas').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ url('tugas/list') }}',
                    type: 'POST',
                    data: function(d) {
                        d.kategori_id = $('#kategori_id').val(); // Pass filter data
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        searchable: false,
                        orderable: false
                    },
                    {
                        data: 'tugas_kode',
                        className: "",
                        searchable: false,
                        orderable: false
                    },
                    {
                        data: 'tugas_nama',
                        className: "",
                        searchable: true,
                        orderable: false
                    },
                    {
                        data: 'deskripsi',
                        name: 'deskripsi',
                        searchable: true,
                        orderable: false
                    },
                    {
                        data: 'jam_kompen',
                        name: 'jam_kompen',
                        searchable: true,
                        orderable: false
                    },
                    {
                        data: 'status_dibuka',
                        name: 'status_dibuka',
                        searchable: true,
                        orderable: false,
                        render: function(data) {
                            console.log(data); // Debugging untuk melihat nilai data
                            return data === 'Dibuka' ?
                                '<span class="badge badge-success">Dibuka</span>' :
                                '<span class="badge badge-danger">Ditutup</span>';
                        }
                    },
                    {
                        data: 'tanggal_mulai',
                        name: 'tanggal_mulai'
                    },
                    {
                        data: 'tanggal_akhir',
                        name: 'tanggal_akhir'
                    },
                    {
                        data: 'kategori.kategori_nama',
                        className: "",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'sdm.sdm_nama',
                        name: 'sdm.sdm_nama'
                    },
                    {
                        data: 'aksi',
                        name: 'aksi',
                        searchable: false,
                        orderable: false,
                    }
                ]
            });

            // Reload data when filter is changed
            $('#kategori_id').on('change', function() {
                dataTugas.ajax.reload();
            });
        });
    </script>
@endpush
