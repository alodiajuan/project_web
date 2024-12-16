@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Edit Task</h3>
        </div>

        <div class="card-body">
            <form action="{{ url('/tugas/' . $task->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label>Judul</label>
                    <input type="text" name="judul" class="form-control" value="{{ $task->judul }}" required>
                </div>

                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" rows="4" required>{{ $task->deskripsi }}</textarea>
                </div>

                <div class="form-group">
                    <label>Bobot</label>
                    <input type="number" name="bobot" class="form-control" value="{{ $task->bobot }}" required>
                </div>

                <div class="form-group">
                    <label>Semester</label>
                    <input type="number" name="semester" class="form-control" value="{{ $task->semester }}" required>
                </div>

                <div class="form-group">
                    <label>Kategori Tugas</label>
                    <select name="id_jenis" class="form-control" required>
                        <option value="" disabled>Pilih Kategori Tugas</option>
                        @foreach ($jenis_tasks as $jenis)
                            <option value="{{ $jenis->id }}" {{ $jenis->id == $task->id_jenis ? 'selected' : '' }}>
                                {{ $jenis->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Jenis Task</label>
                    <select name="tipe" class="form-control" required>
                        <option value="" disabled>Pilih Jenis Tugas</option>
                        <option value="file" {{ $task->tipe == 'file' ? 'selected' : '' }}>File</option>
                        <option value="url" {{ $task->tipe == 'url' ? 'selected' : '' }}>URL</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ url('/tugas') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
@endsection