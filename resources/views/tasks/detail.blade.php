@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Detail Tugas</h3>
        </div>

        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th>Pemberi Tugas</th>
                    <td>{{ $task->dosen->nama }}</td>
                </tr>
                <tr>
                    <th>Judul</th>
                    <td>{{ $task->judul }}</td>
                </tr>
                <tr>
                    <th>Deskripsi</th>
                    <td>{{ $task->deskripsi }}</td>
                </tr>
                <tr>
                    <th>Bobot</th>
                    <td>{{ $task->bobot }}</td>
                </tr>
                <tr>
                    <th>Semester</th>
                    <td>{{ $task->periode->nama }}</td>
                </tr>
                <tr>
                    <th>Tipe</th>
                    <td>{{ ucfirst($task->tipe) }}</td>
                </tr>
            </table>

            <hr>

            @if ($task->file)
                <p><strong>File Pendukung:</strong>
                    <a href="{{ asset($task->file) }}" download>Download File</a>
                </p>
            @elseif($task->url)
                <p><strong>URL Pendukung:</strong>
                    <a href="{{ $task->url }}" target="_blank">{{ $task->url }}</a>
                </p>
            @endif

            <hr>

            <div class="mt-3">
                @if (!$task->isRequested)
                    <a href="{{ url('/tasks/request/' . $task->id) }}" class="btn btn-sm btn-primary">Request</a>
                @elseif ($task->isRequested && $task->requestStatus === null)
                    <div class="alert alert-info">Tunggu keputusan permintaan tugas Anda.</div>
                @elseif ($task->isRequested && $task->requestStatus === 'tolak')
                    <div class="alert alert-danger">Request Anda ditolak.</div>
                @endif
            </div>
        </div>
    </div>
@endsection
