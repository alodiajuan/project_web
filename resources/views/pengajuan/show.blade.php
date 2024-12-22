@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Detail Pengumpulan Tugas</h3>
        </div>
        <div class="card-body">
            <h4>Tugas: {{ $taskSubmission->task->judul }}</h4>
            <p><strong>Deskripsi:</strong> {{ $taskSubmission->task->deskripsi }}</p>
            <p><strong>Nama Mahasiswa:</strong> {{ $taskSubmission->mahasiswa->nama }}</p>
            <p><strong>Kompetensi:</strong> {{ $taskSubmission->mahasiswa->competence->nama }}</p>
            @if ($taskSubmission->acc_dosen == 'terima' && $taskSubmission->progress !== null)
                <p><strong>Progress: </strong>{{ $taskSubmission->progress }}%</p>
            @endif

            <hr>

            @if ($taskSubmission->task->tipe == 'file' && $taskSubmission->file)
                <p><strong>File yang Dikirim:</strong> <a href="{{ asset($taskSubmission->file) }}" target="_blank">Lihat
                        File</a></p>
            @elseif ($taskSubmission->task->tipe == 'url' && $taskSubmission->url)
                <p><strong>URL yang Dikirim:</strong> <a href="{{ $taskSubmission->url }}" target="_blank">Lihat URL</a></p>
            @else
                <p><strong>Belum ada pengumpulan</strong></p>
            @endif

            <hr>

            @if (is_null($taskSubmission->acc_dosen))
                <button type="button" class="btn btn-success" data-toggle="modal"
                    data-target="#modalTerima{{ $taskSubmission->id }}">Terima</button>

                <form action="{{ url('/pengajuan/' . $taskSubmission->id . '/tolak') }}" method="POST"
                    style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-danger">Tolak</button>
                </form>
            @else
                <span class="text-muted">Status: {{ ucfirst($taskSubmission->acc_dosen) }}</span>
            @endif
        </div>
    </div>

    <div class="modal fade" id="modalTerima{{ $taskSubmission->id }}" tabindex="-1" role="dialog"
        aria-labelledby="modalTerimaLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTerimaLabel">Masukkan Progress</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('/pengajuan/' . $taskSubmission->id . '/terima') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="progress">Progress (%)</label>
                            <input type="number" name="progress" id="progress" class="form-control" min="0"
                                max="100" placeholder="Masukkan progress" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Kirim</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
