@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Daftar Tugas</h3>
        </div>

        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <table class="table table-bordered table-striped table-hover table-sm" id="table_task">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Bobot</th>
                        <th>Tipe</th>
                        <th>Status Request</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tasks as $task)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $task->judul }}</td>
                            <td>{{ $task->bobot }}</td>
                            <td>{{ ucfirst($task->tipe) }}</td>
                            <td>
                                @if (isset($task->isRequested))
                                    @if ($task->isRequested['status'] == null)
                                        BELUM ADA
                                    @elseif ($task->isRequested['status'] == 'terima')
                                        TERIMA
                                    @elseif ($task->isRequested['status'] == 'tolak')
                                        TOLAK
                                    @endif
                                @else
                                    BELUM ADA
                                @endif
                            </td>
                            <td>
                                <a href="{{ url('/requests/' . $task->id) }}" class="btn btn-sm btn-dark">Detail</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
