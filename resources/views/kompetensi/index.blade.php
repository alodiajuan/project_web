@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Daftar Kompetensi</h3>
            <a href="{{ url('/kompetensi/create') }}" class="btn btn-primary btn-sm float-right">Tambah Kompetensi</a>
        </div>

        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Kompetensi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kompetensi as $competence)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $competence->nama }}</td>
                            <td>
                                <a href="{{ url('/kompetensi/edit/' . $competence->id) }}"
                                    class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ url('/kompetensi/delete/' . $competence->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
