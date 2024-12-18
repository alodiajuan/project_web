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

            @if ($submissions->isNotEmpty())
                <h4>Data Pengumpulan Tugas:</h4>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Pemberi Tugas</th>
                            <th>Jenis Pengumpulan</th>
                            <th>File / URL</th>
                            <th>Progress</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($submissions as $submission)
                            <tr>
                                <td>{{ $task->dosen->nama }}</td>
                                <td>{{ ucfirst($task->tipe) }}</td>
                                <td>
                                    @if ($task->tipe === 'file' && $submission->file)
                                        <a href="{{ asset('submissions/' . $submission->file) }}" target="_blank">Lihat File</a>
                                    @elseif ($task->tipe === 'url' && $submission->url)
                                        <a href="{{ $submission->url }}" target="_blank">Lihat URL</a>
                                    @else
                                        <span>Tidak ada pengumpulan</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($submission->progress === null)
                                        Belum Direview
                                    @else
                                        {{ $submission->progress }}%
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="alert alert-info">Belum ada pengumpulan untuk tugas ini.</div>
            @endif

            @if ($available)
                @if (!Auth::user()->hasRequestedTask($task))
                    <a href="{{ url('/tasks/request/' . $task->id) }}" class="btn btn-sm btn-primary mt-3">Request</a>
                @else
                    <div class="mt-3">
                        @if ($task->isRequested && $task->requestStatus === 'terima')
                            <form action="{{ url('/tasks') }}" method="POST" enctype="multipart/form-data" class="mt-4">
                                @csrf
                                <input type="text" value="{{ $task->id }}" name="id_task" style="display: none">
                                @if ($task->tipe === 'file')
                                    <label for="file">Upload File</label>
                                    <input type="file" name="file" id="file" class="form-control">
                                @elseif ($task->tipe === 'url')
                                    <label for="url">Submit URL</label>
                                    <input type="url" name="url" id="url" class="form-control" placeholder="Masukkan URL">
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
            @else
                <div class="alert alert-danger">Anda tidak bisa mengirimkan tugas karena progress sudah mencapai 100%.</div>
            @endif
        </div>
    </div>
@endsection