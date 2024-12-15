@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Daftar SDM yang terdapat dalam sistem</h3>
            <div class="card-tools">
                <button onclick="modalAction('{{ url('/sdm/import') }}')" class="btn btn-sm btn-info mt-1">Import
                    Data</button>
                <a href="{{ url('/sdm/export_excel') }}" class="btn btn-sm btn-primary mt-1"><i class="fa fa-file-excel"></i>
                    Export (Excel)</a>
                <a href="{{ url('/sdm/export_pdf') }}" class="btn btn-sm btn-warning mt-1"><i class="fa fa-file-pdf"></i>
                    Export (PDF)</a>
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
