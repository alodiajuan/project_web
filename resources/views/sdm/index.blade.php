@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Daftar SDM yang terdapat dalam sistem</h3>
            <div class="card-tools">
                <form action="{{ url('/users/import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <button type="button" class="btn btn-sm btn-info mt-1"
                        onclick="document.getElementById('fileInput').click()">
                        Import Data
                    </button>
                    <input type="file" id="fileInput" name="file" style="display: none;"
                        onchange="this.form.submit()">
                </form>

                <a href="{{ url('/users/export?role=sdm') }}" class="btn btn-sm btn-primary mt-1">
                    <i class="fa fa-file-excel"></i> Export Data (Excel)
                </a>
                <a href="{{ url('/sdm/create') }}" class="btn btn-sm btn-success mt-1">Tambah Data</a>
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
                    <form action="{{ url('/sdm') }}" class="form-group row align-items-center" method="GET">
                        <div class="col-auto">
                            <label class="control-label col-form-label">Filter:</label>
                        </div>
                        <div class="col-auto">
                            <select class="form-control" id="role" name="role">
                                <option value="">- Semua -</option>
                                <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="dosen" {{ request('role') == 'dosen' ? 'selected' : '' }}>Dosen</option>
                                <option value="tendik" {{ request('role') == 'tendik' ? 'selected' : '' }}>Tendik</option>
                            </select>
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-sm btn-primary">Filter</button>
                        </div>
                    </form>
                </div>
            </div>

            <table class="table table-bordered table-striped table-hover table-sm" id="table_mahasiswa">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>NIP/NIPPK</th>
                        <th>Foto</th>
                        <th>Role</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sdm as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->username }}</td>
                            <td>
                                @if ($item->foto_profile)
                                    <img src="{{ asset('images/' . $item->foto_profile) }}" alt="Foto Profile"
                                        class="img-thumbnail" width="50">
                                @else
                                    No Image
                                @endif
                            </td>
                            <td>{{ $item->role }}</td>
                            <td>
                                <a href="{{ url('/sdm/edit/' . $item->id) }}" class="btn btn-sm btn-warning">Edit</a>

                                <form action="{{ url('/sdm/delete/' . $item->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger mt-3"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus data mahasiswa ini?')">Delete</button>
                                </form>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
