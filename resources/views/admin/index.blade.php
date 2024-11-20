@extends('layouts.template')
@section('content')
   <div class="card card-outline card-primary">
       <div class="card-header">
           <h3 class="card-title">{{ $page->title }}</h3>
           <div class="card-tools">
               <a class="btn btn-sm btn-primary mt-1" href="{{ url('admin/create') }}">Tambah</a>
           </div>
       </div>
       <div class="card-body">
           @if (session('success'))
               <div class="alert alert-success">{{ session('success') }}</div>
           @endif
           @if (session('error'))
               <div class="alert alert-danger">{{ session('error') }}</div>
           @endif
           <table class="table table-bordered table-striped table-hover table-sm" id="table_admin">
               <thead>
                   <tr>
                       <th>ID</th>
                       <th>Nama</th>
                       <th>NIP</th>
                       <th>No Telepon</th>
                       <th>Program Studi</th>
                       <th>Aksi</th>
                   </tr>
               </thead>
           </table>
       </div>
   </div>
@endsection
@push('css')
@endpush
@push('js')
   <script>
       $(document).ready(function() {
           var dataAdmin = $('#table_admin').DataTable({
               serverSide: true,
               ajax: {
                   "url": "{{ url('admin/list') }}",
                   "dataType": "json",
                   "type": "POST"
               },
               columns: [{
                   data: "DT_RowIndex",
                   className: "text-center",
                   orderable: false,
                   searchable: false
               }, {
                   data: "admin_nama",
                   className: "",
                   orderable: true,
                   searchable: true
               }, {
                   data: "nip",
                   className: "",
                   orderable: true,
                   searchable: true
               }, {
                   data: "no_telepon",
                   className: "",
                   orderable: true,
                   searchable: true
               }, {
                   data: "prodi_id",
                   className: "",
                   orderable: true,
                   searchable: true
               }, {
                   data: "aksi",
                   className: "",
                   orderable: false,
                   searchable: false
               }]
           });
       });
   </script>
@endpush