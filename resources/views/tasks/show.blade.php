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
                    <td>{{ $task->semester }}</td>
                </tr>
                <tr>
                    <th>Tipe</th>
                    <td>{{ ucfirst($task->tipe) }}</td>
                </tr>
            </table>

            @if (!Auth::user()->hasRequestedTask($task))
                <a href="{{ url('/tasks/request/' . $task->id) }}" class="btn btn-sm btn-primary mt-3">Request</a>
            @else
                <div class="mt-3">
                    @if ($task->isRequested && $task->requestStatus === 'terima')
                        <form action="{{ url('/tasks') }}" method="POST" enctype="multipart/form-data" class="mt-4">
                            @csrf
                            @if ($task->tipe === 'file')
                                <label for="file">Upload File</label>
                                <input type="file" name="file" id="file" class="form-control">
                            @elseif ($task->tipe === 'url')
                                <label for="url">Submit URL</label>
                                <input type="url" name="url" id="url" class="form-control"
                                    placeholder="Masukkan URL">
                            @endif
                            <button type="submit" class="btn btn-primary mt-3">Submit Tugas</button>
                        </form>
                    @elseif ($task->isRequested && $task->requestStatus === 'tolak')
                        <div class="alert alert-danger">Request Anda ditolak.</div>
                    @else
                        <div class="alert alert-info">Tunggu keputusan permintaan tugas Anda.</div>
                    @endif
                </div>
            @endif
        </div>
    </div>
@endsection
