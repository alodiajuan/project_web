@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Daftar SDM yang terdapat dalam sistem</h3>
            <div class="card-tools">
                <button onclick="modalAction('{{ url('/sdm/import') }}')" class="btn btn-sm btn-info mt-1">Import</button>
                <a href="{{ url('/sdm/export_excel') }}" class="btn btn-sm btn-primary mt-1"><i class="fa fa-file-excel"></i> Export (Excel)</a>
                <a href="{{ url('/sdm/export_pdf') }}" class="btn btn-sm btn-warning mt-1"><i class="fa fa-file-pdf"></i> Export (PDF)</a>
                <button onclick="modalAction('{{ url('sdm/create_ajax') }}')" class="btn btn-sm btn-success mt-1">Tambah Data</button>
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
                            <select class="form-control" id="level_id" name="level_id">
                                <option value="">- Semua -</option>
                                @foreach ($levels as $level)
                                    <option value="{{ $level->level_id }}">{{ $level->level_nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <small class="form-text text-muted">Level SDM </small>
                    </div>
                </div>
            </div>            
            <table class="table table-bordered table-striped table-hover table-sm" id="table_sdm">
                <thead>
                    <tr>
                        <th>No</th> 
                        <th>Nama</th> 
                        <th>NIP</th>
                        <th>Username</th>
                        <th>No Telepon</th> 
                        <th>Foto</th> 
                        <th>Program Studi</th> 
                        <th>Jabatan</th> 
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
            datasdm = $('#table_sdm').DataTable({
                serverSide: true,
                ajax: {
                    url: "{{ url('sdm/list') }}",
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
                        data: "sdm_nama",
                        className: "",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "nip",
                        className: "",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "username",
                        className: "",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "no_telepon",
                        className: "",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "foto",
                        className: "",
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return '<img src="' + data + '" alt="Foto of ' + row.sdm_nama + '" width="50" height="50">';
                        }
                    },
                    {
                        data: "prodi.prodi_nama", // Menampilkan nama program studi
                        className: "",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "level.level_nama",
                        className: "",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "aksi",
                        className: "",
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            $('#level_id').on('change', function() {
                datasdm.ajax.reload();
            });
        });
    </script>
@endpush