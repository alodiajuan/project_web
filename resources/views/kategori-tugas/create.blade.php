@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Tambah Kategori Tugas</h3>
        </div>
        <div class="card-body">
            <form action="{{ url('/kategori-tugas') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="nama">Nama Kategori</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama') }}" required>
                    @error('nama')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary mt-3">Simpan</button>
                <a href="{{ url('/kategori-tugas') }}" class="btn btn-secondary mt-3">Kembali</a>
            </form>
        </div>
    </div>
@endsection
