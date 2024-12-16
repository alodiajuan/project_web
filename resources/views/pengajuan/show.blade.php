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

            <hr>

            @if ($taskSubmission->task->tipe == 'file' && $taskSubmission->file)
                <p><strong>File yang Dikirim:</strong> <a href="{{ asset('submissions/' . $taskSubmission->file) }}"
                        target="_blank">Lihat File</a></p>
            @elseif ($taskSubmission->task->tipe == 'url' && $taskSubmission->url)
                <p><strong>URL yang Dikirim:</strong> <a href="{{ $taskSubmission->url }}" target="_blank">Lihat URL</a></p>
            @else
                <p><strong>Belum ada pengumpulan</strong></p>
            @endif

            <hr>

            @if (is_null($taskSubmission->acc_dosen))
                <form action="{{ url('/pengajuan/' . $taskSubmission->id . '/terima') }}" method="post"
                    style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-success">Terima</button>
                </form>

                <form action="{{ url('/pengajuan/' . $taskSubmission->id . '/tolak') }}" method="post"
                    style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-danger">Tolak</button>
                </form>
            @else
                <span class="text-muted">Status: {{ ucfirst($taskSubmission->acc_dosen) }}</span>
            @endif
        </div>
    </div>
@endsection
