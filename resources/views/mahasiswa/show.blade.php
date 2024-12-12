@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools"></div>
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
                        <th width="20%">Nama Mahasiswa</th>
                        <td>{{ $mahasiswa->mahasiswa_nama }}</td>
                    </tr>
                    <tr>
                        <th>NIM</th>
                        <td>{{ $mahasiswa->nim }}</td>
                    </tr>
                    <tr>
                        <th>Username</th>
                        <td>{{ $mahasiswa->username }}</td>
                    </tr>
                    <tr>
                        <th>Semester</th>
                        <td>{{ $mahasiswa->semester }}</td>
                    </tr>
                    <tr>
                        <th>Foto</th>
                        <td>
                            @if($mahasiswa->foto)
                                <img src="{{ asset('uploads/' . $mahasiswa->foto) }}" class="img-thumbnail" width="200">
                            @else
                                <span class="text-muted">Tidak ada foto</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Program Studi</th>
                        <td>{{ $mahasiswa->prodi->prodi_nama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Kompetensi</th>
                        <td>{{ $mahasiswa->kompetensi->kompetensi_nama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Level</th>
                        <td>{{ $mahasiswa->level->level_nama ?? '-' }}</td>
                    </tr>
                </table>
            @endempty
            <a href="{{ url('mahasiswa') }}" class="btn btn-sm btn-default mt-2">Kembali</a>
        </div>
    </div>
@endsection