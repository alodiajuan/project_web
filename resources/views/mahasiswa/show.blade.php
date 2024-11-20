@extends('layouts.template')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools">
            <a href="{{ url('/mahasiswa') }}" class="btn btn-secondary btn-sm">Kembali</a>
        </div>
    </div>
    <div class="card-body">
        @empty($mahasiswa)
            <div class="alert alert-danger alert-dismissible">
                <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                Data yang Anda cari tidak ditemukan.
            </div>
        @else
            <table class="table table-bordered table-striped table-hover table-sm">
                <tr>
                    <th>ID</th>
                    <td>{{ $mahasiswa->mahasiswa_id }}</td>
                </tr>
                <tr>
                    <th>Kode Mahasiswa</th>
                    <td>{{ $mahasiswa->mahasiswa_kode }}</td>
                </tr>
                <tr>
                    <th>Nama Mahasiswa</th>
                    <td>{{ $mahasiswa->nama }}</td>
                </tr>
                <tr>
                    <th>Kompetensi</th>
                    <td>{{ $mahasiswa->kompetensi->kompetensi_nama ?? 'Tidak ada kompetensi' }}</td> <!-- Jika ada relasi dengan kompetensi -->
                </tr>
            </table>
        @endempty
    </div>
</div>
@endsection
@push('css')
@endpush
@push('js')
@endpush