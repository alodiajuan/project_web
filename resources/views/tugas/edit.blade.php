@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Edit Tugas</h3>
        </div>

        <div class="card-body">
            <form action="{{ url('/tugas/' . $task->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label>Judul</label>
                    <input type="text" name="judul" class="form-control" placeholder="Masukkan judul task" value="{{ old('judul', $task->judul) }}" required>
                </div>

                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" rows="4" placeholder="Masukkan deskripsi task" required>{{ old('deskripsi', $task->deskripsi) }}</textarea>
                </div>

                <div class="form-group">
                    <label>Bobot</label>
                    <input type="number" name="bobot" class="form-control" placeholder="Masukkan bobot task" value="{{ old('bobot', $task->bobot) }}" required>
                </div>

                <div class="form-group">
                    <label>Semester</label>
                    <select name="semester" class="form-control" required>
                        <option value="" selected disabled>Pilih Semester</option>
                        @foreach ($periods as $period)
                            <option value="{{ $period->semester }}" {{ old('semester', $task->semester) == $period->semester ? 'selected' : '' }}>
                                {{ $period->nama }} ({{ $period->tipe }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Kategori Tugas</label>
                    <select name="id_jenis" class="form-control" required>
                        <option value="" selected disabled>Pilih Kategori Tugas</option>
                        @foreach ($jenis_tasks as $jenis)
                            <option value="{{ $jenis->id }}" {{ old('id_jenis', $task->id_jenis) == $jenis->id ? 'selected' : '' }}>
                                {{ $jenis->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Tipe Tugas</label>
                    <select name="tipe" class="form-control" required>
                        <option value="" selected disabled>Pilih Tipe Tugas</option>
                        <option value="file" {{ old('tipe', $task->tipe) == 'file' ? 'selected' : '' }}>File</option>
                        <option value="url" {{ old('tipe', $task->tipe) == 'url' ? 'selected' : '' }}>URL</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Kuota</label>
                    <input type="number" name="kuota" class="form-control" placeholder="Masukkan kuota peserta" value="{{ old('kuota', $task->kuota) }}" required>
                </div>

                <div class="form-group">
                    <label>Deadline</label>
                    <input type="datetime-local" name="deadline" class="form-control" value="{{ old('deadline', \Carbon\Carbon::parse($task->deadline)->format('Y-m-d\TH:i')) }}" required>
                </div>

                <div class="form-group">
                    <label>File Pendukung (Opsional)</label>
                    <input type="file" name="file" class="form-control">
                </div>

                <div class="form-group">
                    <label>URL Pendukung (Opsional)</label>
                    <input type="url" name="url" class="form-control" placeholder="Masukkan URL pendukung" value="{{ old('url', $task->url) }}">
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ url('/tugas') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
@endsection
