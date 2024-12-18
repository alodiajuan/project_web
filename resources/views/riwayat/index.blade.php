@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Riwayat Kompensasi</h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Dosen</th>
                        <th>Tugas</th>
                        <th>Nama Mahasiswa</th>
                        <th>Semester</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($compensations as $index => $compensation)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $compensation->dosen->nama }}</td>
                            <td>{{ $compensation->task->judul }}</td>
                            <td>{{ $compensation->mahasiswa->nama }}</td>
                            <td>{{ $compensation->semester }}</td>
                            <td>
                                <a href="/riwayat/{{ $compensation->id }}" class="btn btn-sm btn-primary">Detail</a>
                                <a href="/compensations/download/{{ $compensation->id }}" target="_blank"
                                    class="btn btn-sm btn-success">Download</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
