@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Detail Kompensasi Tugas</h3>
        </div>
        <div class="card-body">
            <h4>Tugas: {{ $compensation->task->judul }}</h4>
            <p><strong>Deskripsi:</strong> {{ $compensation->task->deskripsi }}</p>
            <p><strong>Nama Mahasiswa:</strong> {{ $compensation->mahasiswa->nama }}</p>
            <p><strong>Nama Dosen:</strong> {{ $compensation->dosen->nama }}</p>
            <p><strong>Semester:</strong> {{ $compensation->semester }}</p>

            <hr>

            <a href="{{ url('/compensations/download/' . $compensation->id) }}" target="_blank"
                class="btn btn-success">Download</a>
        </div>
    </div>
@endsection
