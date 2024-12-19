@extends('layouts.template')

@section('content')
    <div class="row">
        <div class="col-lg-4 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $data['primary'][0] }}</h3>
                    <p>Total {{ $data['primary'][1] }}</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $data['second'][0] }}</h3>
                    <p>Total {{ $data['second'][1] }}</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $data['three'][0] }}</h3>
                    <p>Total {{ $data['three'][1] }}</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
            </div>
        </div>
    </div>

    @if (Auth::user()->role == 'mahasiswa')
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">Daftar Tugas</h3>
            </div>

            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Pemberi Tugas</th>
                            <th>Nama Tugas</th>
                            <th>Progress</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tasks as $task)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $task->dosen->nama }}</td>
                                <td>{{ $task->judul }}</td>
                                <td>
                                    @if ($task->highestProgressSubmission)
                                        @if ($task->highestProgressSubmission->progress === null)
                                            Belum Direview
                                        @else
                                            {{ $task->highestProgressSubmission->progress }}%
                                        @endif
                                    @else
                                        Belum Dikerjakan
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ url('requests/' . $task->id) }}" class="btn btn-sm btn-primary">Kerjakan
                                        Sekarang</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
@endsection
