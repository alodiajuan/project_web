@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
        </div>
        <div class="card-body">
            <a href="{{ url('/prodi/create') }}" class="btn btn-primary mb-3">Tambah Program Studi</a>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Program Studi</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($prodi as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>
                                <a href="{{ url('/prodi/edit/' . $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ url('/prodi/delete/' . $item->id) }}" method="POST" style="display:inline;">
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
