@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Daftar mahasiswa yang terdapat dalam sistem</h3>
            <div class="card-tools">
                <button onclick="modalAction('{{ url('/mahasiswa/import') }}')" class="btn btn-sm btn-info mt-1">Import mahasiswa</button>
                <a href="{{ url('/mahasiswa/export_excel') }}" class="btn btn-sm btn-primary mt-1"><i class="fa fa-file-excel"></i> Export mahasiswa (Excel)</a>
                <a href="{{ url('/mahasiswa/export_pdf') }}" class="btn btn-sm btn-warning mt-1"><i class="fa fa-file-pdf"></i> Export mahasiswa (PDF)</a>
                <button onclick="modalAction('{{ url('mahasiswa/create_ajax') }}')" class="btn btn-sm btn-success mt-1">Tambah Data</button>
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
                            <select class="form-control" id="level_id" name="level_id" required>
                                <option value="">- Semua -</option>
                                @foreach ($level as $item)
                                    <option value="{{ $item->level_id }}">{{ $item->level_nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <small class="form-text text-muted">Level Pengguna</small>
                    </div>
                </div>
            </div>
            <table class="table table-bordered table-striped table-hover table-sm" id="table_mahasiswa">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Mahasiswa</th>
                        <th>NIM</th>
                        <th>Username</th>
                        <th>Kompetensi</th>
                        <th>Semester</th>
                        <th>Level Pengguna</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" data-width="75%" aria-hidden="true"></div>
@endsection

@push('css')
@endpush

@push('js')
    <script>
        function modalAction(url = '') {
            $('#myModal').load(url, function() {
                $('#myModal').modal('show');
            });
        }

        $(document).ready(function() {
            var datamahasiswa = $('#table_mahasiswa').DataTable({
                serverSide: true,
                ajax: {
                    url: "{{ url('mahasiswa/list') }}",
                    type: "POST",
                    data: function(d) {
                        d.level_id = $('#level_id').val();
                    }
                },
                columns: [
                    {
                        data: "DT_RowIndex",
                        className: "text-center",
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: "mahasiswa_nama", // Ensure this matches your model
                        className: "",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "nim", // Ensure this matches your model
                        className: "",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "username", // Ensure this matches your model
                        className: "",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "kompetensi", // Ensure this matches your model
                        className: "",
                        orderable: true,
                        searchable: true
                    },
                    {
 data: "semester", // Ensure this matches your model
                        className: "",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "level.level_nama", // Ensure this matches your model
                        className: "",
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: "aksi", // Ensure this matches your model
                        className: "",
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            $('#level_id').on('change', function() {
                datamahasiswa.ajax.reload();
            });
        });
    </script>
@endpush