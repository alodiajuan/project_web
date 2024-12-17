@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Daftar mahasiswa yang terdapat dalam sistem</h3>
            <div class="card-tools">
                <form action="{{ url('/users/import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <button type="button" class="btn btn-sm btn-info mt-1"
                        onclick="document.getElementById('fileInput').click()">
                        Import mahasiswa
                    </button>
                    <input type="file" id="fileInput" name="file" style="display: none;"
                        onchange="this.form.submit()">
                </form>

                <a href="{{ url('/users/export?role=mahasiswa') }}" class="btn btn-sm btn-primary mt-1">
                    <i class="fa fa-file-excel"></i> Export mahasiswa (Excel)
                </a>

                <a href="{{ url('/mahasiswa/create') }}" class="btn btn-sm btn-success mt-1">Tambah Data</a>
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
                    <form action="{{ url('/mahasiswa') }}" class="form-group row align-items-center" method="GET">
                        <div class="col-auto">
                            <label class="control-label col-form-label">Filter:</label>
                        </div>
                        <div class="col-auto">
                            <select class="form-control" id="prodi_id" name="prodi_id">
                                <option value="">- Semua -</option>
                                @foreach ($prodi as $prodiItem)
                                    <option value="{{ $prodiItem->id }}"
                                        {{ request('prodi_id') == $prodiItem->id ? 'selected' : '' }}>
                                        {{ $prodiItem->nama }}</option>
                                @endforeach
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
                        <th>NIM</th>
                        <th>Foto</th>
                        <th>Kompetensi</th>
                        <th>Semester</th>
                        <th>Prodi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($mahasiswa as $item)
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
                            <td>{{ $item->competence ? $item->competence->nama : 'N/A' }}</td>
                            <td>{{ $item->semester }}</td>
                            <td>{{ $item->prodi ? $item->prodi->nama : 'N/A' }}</td>
                            <td>
                                <a href="{{ url('/mahasiswa/edit/' . $item->id) }}" class="btn btn-sm btn-warning">Edit</a>

                                <form action="{{ url('/mahasiswa/delete/' . $item->id) }}" method="POST" class="d-inline">
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
