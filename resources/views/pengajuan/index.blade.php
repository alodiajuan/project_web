@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Daftar Pengumpulan Tugas</h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Pemberi Tugas</th>
                        <th>Nama Tugas</th>
                        <th>Nama Mahasiswa</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($taskSubmissions as $submission)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $submission->task->dosen->nama }}</td>
                            <td>{{ $submission->task->judul }}</td>
                            <td>{{ $submission->mahasiswa->nama }}</td>
                            <td>
                                @if ($submission->acc_dosen)
                                    {{ ucfirst($submission->acc_dosen) }}
                                @else
                                    <span class="text-muted">Menunggu</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ url('/pengajuan/' . $submission->id) }}" class="btn btn-sm btn-primary">Lihat
                                    Detail</a>
                                @if (is_null($submission->acc_dosen))
                                    <form action="{{ url('/pengajuan/' . $submission->id . '/terima') }}" method="POST"
                                        style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success">Terima</button>
                                    </form>
                                    <form action="{{ url('/pengajuan/' . $submission->id . '/tolak') }}" method="POST"
                                        style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger">Tolak</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
