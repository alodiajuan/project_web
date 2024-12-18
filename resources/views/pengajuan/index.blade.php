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
                                    <button type="button" class="btn btn-sm btn-success" data-toggle="modal"
                                        data-target="#modalTerima{{ $submission->id }}">Terima</button>
                                    <form action="{{ url('/pengajuan/' . $submission->id . '/tolak') }}" method="POST"
                                        style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger">Tolak</button>
                                    </form>
                                @endif

                            </td>
                        </tr>

                        <!-- Modal for approving progress -->
                        <div class="modal fade" id="modalTerima{{ $submission->id }}" tabindex="-1" role="dialog"
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
                                        <form action="{{ url('/pengajuan/' . $submission->id . '/terima') }}"
                                            method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <label for="progress">Progress (%)</label>
                                                <input type="number" name="progress" id="progress" class="form-control"
                                                    min="0" max="100" placeholder="Masukkan progress" required>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Kirim</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
