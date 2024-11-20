@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Daftar tugas yang terdapat dalam sistem</h3>
        <div class="card-tools">
            <button onclick="modalAction('{{ url('/tugas/create_ajax') }}')" class="btn btn-sm btn-success mt-1">Tambah Ajax</button>
            <a href="{{ url('/tugas/import') }}" class="btn btn-success btn-sm">Import</a>
            <a href="{{ url('/tugas/export/excel') }}" class="btn btn-info btn-sm">Export Excel</a>
            <a href="{{ url('/tugas/export/pdf') }}" class="btn btn-danger btn-sm">Export PDF</a>
        </div>
    </div>
    <div class="card-body">
        <!-- Filter Form -->
        <form id="filterForm" class="mb-3">
            <div class="row">
                <div class="col-md-4">
                    <select name="kategori_id" id="kategori_id" class="form-control">
                        <option value="">Pilih Kategori</option>
                        @foreach($kategori as $k)
                            <option value="{{ $k->kategori_id }}">{{ $k->kategori_nama }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </form>

        <!-- Tabel Data Tugas -->
        <table id="table_tugas" class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Tugas</th>
                    <th>Nama Tugas</th>
                    <th>Deskripsi</th>
                    <th>Jenis Tugas</th>
                    <th>Nilai Jam Kompen</th>
                    <th>Tanggal Mulai</th>
                    <th>Tanggal Akhir</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@endsection

@push('css')
<link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
@endpush

@push('js')
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script>
$(function() {
    var dataTable = $('#table_tugas').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ url('/tugas/list') }}',
            data: function(d) {
                d.kategori_id = $('#kategori_id').val();
            }
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false, orderable: false },
            { data: 'tugas_kode', name: 'tugas_kode' },
            { data: 'tugas_nama', name: 'tugas_nama' },
            { data: 'deskripsi', name: 'deskripsi' },
            { data: 'kategori.kategori_nama', name: 'kategori.kategori_nama' },
            { data: 'jam_kompen', name: 'jam_kompen' },
            { data: 'tanggal_mulai', name: 'tanggal_mulai' },
            { data: 'tanggal_akhir', name: 'tanggal_akhir' },
            { 
                data: 'status_dibuka', 
                name: 'status_dibuka',
                render: function(data) {
                    return data ? 'Dibuka' : 'Ditutup';
                }
            },
            { 
                data: 'aksi', 
                name: 'aksi', 
                searchable: false, 
                orderable: false,
                render: function(data, type, row) {
                    return `
                        <a href="{{ url('/tugas') }}/${row.tugas_id}/edit_ajax" class="btn btn-warning btn-sm">Edit</a>
                        <a href="{{ url('/tugas') }}/${row.tugas_id}/delete_ajax" class="btn btn-danger btn-sm">Hapus</a>
                    `;
                }
            }
        ]
    });

    $('#kategori_id').change(function() {
        dataTable.draw();
    });
});

function modalAction(url) {
    $.ajax({
        url: url,
        success: function(response) {
            $('#modal-default .modal-content').html(response);
            $('#modal-default').modal('show');
        }
    });
}
</script>
@endpush
