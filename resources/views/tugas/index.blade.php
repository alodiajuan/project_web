@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Daftar Tugas</h3>
            <div class="card-tools">
                <a href="{{ url('/tugas/create') }}" class="btn btn-sm btn-success mt-1">Tambah Tugas</a>
            </div>
        </div>

        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <table class="table table-bordered table-striped table-hover table-sm" id="table_task">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Deskripsi</th>
                        <th>Bobot</th>
                        <th>Semester</th>
                        <th>Tipe</th>
                        <th>Deadline</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tasks as $task)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $task->judul }}</td>
                            <td>{{ $task->deskripsi }}</td>
                            <td>{{ $task->bobot }}</td>
                            <td>{{ $task->periode ? $task->periode->nama : 'Tidak Ditemukan' }}</td>
                            <td>{{ ucfirst($task->tipe) }}</td>
                            <td>{{ \Carbon\Carbon::parse($task->deadline)->format('d-m-Y') }}</td>
                            <td>
                                <a href="{{ url('/tugas/edit/' . $task->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <a href="{{ url('/tugas/show/' . $task->id) }}" class="btn btn-sm btn-dark">Detail</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
