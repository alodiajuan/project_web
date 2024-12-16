@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Tambah Tugas</h3>
        </div>

        <div class="card-body">
            <form action="{{ url('/tugas') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label>Judul</label>
                    <input type="text" name="judul" class="form-control" placeholder="Masukkan judul task" required>
                </div>

                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" rows="4" placeholder="Masukkan deskripsi task" required></textarea>
                </div>

                <div class="form-group">
                    <label>Bobot</label>
                    <input type="number" name="bobot" class="form-control" placeholder="Masukkan bobot task" required>
                </div>

                <div class="form-group">
                    <label>Semester</label>
                    <input type="number" name="semester" class="form-control" placeholder="Masukkan semester task" required>
                </div>

                <div class="form-group">
                    <label>Kategori Tugas</label>
                    <select name="id_jenis" class="form-control" required>
                        <option value="" selected disabled>Pilih Kategori Tugas</option>
                        @foreach ($jenis_tasks as $jenis)
                            <option value="{{ $jenis->id }}">{{ $jenis->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Tipe Tugas</label>
                    <select name="tipe" class="form-control" required>
                        <option value="" selected disabled>Pilih Tipe Tugas</option>
                        <option value="file">File</option>
                        <option value="url">URL</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ url('/tugas') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
@endsection