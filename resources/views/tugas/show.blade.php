@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
        </div>

        <div class="card-body">
            <h4>Tugas: {{ $task->judul }}</h4>
            <p><strong>Deskripsi:</strong> {{ $task->deskripsi }}</p>
            <p><strong>Bobot:</strong> {{ $task->bobot }}</p>
            <p><strong>Semester:</strong> {{ $task->semester }}</p>
            <p><strong>Tipe:</strong> {{ $task->tipe }}</p>

            <hr>

            <h5>Daftar Request</h5>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIM</th>
                        <th>Nama Mahasiswa</th>
                        <th>Prodi</th>
                        <th>Kompetensi</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($requests as $index => $req)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $req->user->username }}</td>
                            <td>{{ $req->user->nama }}</td>
                            <td>{{ $req->user->prodi ? $req->user->prodi->nama : 'No Prodi' }}</td>
                            <td>{{ $req->user->competence ? $req->user->competence->nama : 'No Kompetensi' }}</td>
                            <td>
                                @if ($req->status)
                                    {{ ucfirst($req->status) }}
                                @else
                                    <span class="text-muted">Belum diproses</span>
                                @endif
                            </td>
                            <td>
                                @if (is_null($req->status))
                                    <a href="{{ url('/tugas/request/' . $req->id . '/approve') }}"
                                        class="btn btn-sm btn-success">Terima</a>
                                    <a href="{{ url('/tugas/request/' . $req->id . '/decline') }}"
                                        class="btn btn-sm btn-danger">Tolak</a>
                                @else
                                    <span class="text-muted">Tidak ada aksi</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
