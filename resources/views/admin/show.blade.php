@extends('layouts.template')
@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools"></div>
        </div>
        <div class="card-body">
            @empty($admin)
                <div class="alert alert-danger alert-dismissible">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                    Data yang Anda cari tidak ditemukan.
                </div>
            @else
                <table class="table table-bordered table-striped table-hover table-sm">
                    <tr>
                        <th width="20%">Nama Admin</th>
                        <td>{{ $admin->admin_nama }}</td>
                    </tr>
                    <tr>
                        <th>NIP</th>
                        <td>{{ $admin->nip }}</td>
                    </tr>
                    <tr>
                        <th>Username</th>
                        <td>{{ $admin->username }}</td>
                    </tr>
                    <tr>
                        <th>No Telepon</th>
                        <td>{{ $admin->no_telepon }}</td>
                    </tr>
                    <tr>
                        <th>Foto</th>
                        <td>
                            @if($admin->foto)
                                <img src="{{ asset('uploads/'.$admin->foto) }}" class="img-thumbnail" width="200">
                            @else
                                <span class="text-muted">Tidak ada foto</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Program Studi</th>
                        <td>{{ $admin->prodi->prodi_nama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Level</th>
                        <td>{{ $admin->level->level_nama ?? '-' }}</td>
                    </tr>
                </table>
            @endempty
            <a href="{{ url('admin') }}" class="btn btn-sm btn-default mt-2">Kembali</a>
        </div>
    </div>
@endsection