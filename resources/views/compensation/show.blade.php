@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Detail Tugas Submission</h3>
        </div>

        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th>Judul Tugas</th>
                    <td>{{ $taskSubmission->task->judul }}</td>
                </tr>
                <tr>
                    <th>Deskripsi</th>
                    <td>{{ $taskSubmission->task->deskripsi }}</td>
                </tr>
                <tr>
                    <th>Nama Dosen</th>
                    <td>{{ $taskSubmission->dosen ? $taskSubmission->dosen->nama : 'Belum Ditugaskan' }}</td>
                </tr>
                <tr>
                    <th>Status Kompensasi</th>
                    <td>
                        @if ($taskSubmission->compensations->acc_dosen == 'terima')
                            Diterima
                        @elseif ($taskSubmission->compensations->acc_dosen == 'tolak')
                            Ditolak
                        @else
                            Belum Direview
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>File</th>
                    <td>
                        @if ($taskSubmission->file)
                            <a href="{{ asset('submissions/' . $taskSubmission->file) }}" target="_blank">Lihat File</a>
                        @else
                            Tidak Ada File
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>URL</th>
                    <td>{{ $taskSubmission->url ?? 'Tidak Ada URL' }}</td>
                </tr>
            </table>

            <a href="{{ url('/kompensasi') }}" class="btn btn-sm btn-secondary">Kembali</a>
        </div>
    </div>
@endsection
