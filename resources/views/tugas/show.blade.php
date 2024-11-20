@extends('layouts.template')
@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools"></div>
        </div>
        <div class="card-body">
            @if(!$tugas)
                <div class="alert alert-danger alert-dismissible">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                    Data tugas tidak ditemukan.
                </div>
            @else
                <table class="table table-bordered table-striped table-hover table-sm">
                    <tr>
                        <th>ID</th>
                        <td>{{ $tugas->tugas_id }}</td>
                    </tr>
                    <tr>
                        <th>Kode Tugas</th>
                        <td>{{ $tugas->tugas_kode }}</td>
                    </tr>
                    <tr>
                        <th>Nama Tugas</th>
                        <td>{{ $tugas->tugas_nama }}</td>
                    </tr>
                    <tr>
                        <th>Deskripsi</th>
                        <td>{{ $tugas->deskripsi }}</td>
                    </tr>
                    <tr>
                        <th>Jam Kompen</th>
                        <td>{{ $tugas->jam_kompen }}</td>
                    </tr>
                    <tr>
                        <th>Status Dibuka</th>
                        <td>{{ $tugas->status_dibuka ? 'Dibuka' : 'Ditutup' }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Mulai</th>
                        <td>{{ \Carbon\Carbon::parse($tugas->tanggal_mulai)->format('d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Akhir</th>
                        <td>{{ \Carbon\Carbon::parse($tugas->tanggal_akhir)->format('d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <th>Kategori</th>
                        <td>{{ $tugas->kategori->kategori_nama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>SDM</th>
                        <td>{{ $tugas->sdm->sdm_nama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Admin</th>
                        <td>{{ $tugas->admin->admin_nama ?? '-' }}</td>
                    </tr>
                </table>
            @endif
            <a href="{{ url('tugas') }}" class="btn btn-sm btn-default mt-2">Kembali</a>
        </div>
    </div>
@endsection

@push('css')
@endpush

@push('js')
@endpush
