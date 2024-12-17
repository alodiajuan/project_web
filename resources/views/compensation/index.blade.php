@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Daftar Tugas Anda</h3>
        </div>

        <div class="card-body">
            <table class="table table-bordered table-striped table-hover table-sm">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Dosen</th>
                        <th>Nama Tugas</th>
                        <th>Status Kompensasi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($taskSubmissions as $submission)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $submission->task->dosen ? $submission->task->dosen->nama : 'Belum Ditugaskan' }}</td>
                            <td>{{ $submission->task->judul }}</td>
                            <td>
                                @if ($submission->acc_dosen == 'terima')
                                    Diterima
                                @elseif ($submission->acc_dosen == 'tolak')
                                    Ditolak
                                @else
                                    Belum Direview
                                @endif
                            </td>
                            <td>
                                <a href="{{ url('kompensasi/' . $submission->id) }}" class="btn btn-sm btn-dark">Detail</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
