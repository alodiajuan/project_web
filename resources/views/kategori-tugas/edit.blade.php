@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Edit Kategori Tugas</h3>
        </div>
        <div class="card-body">
            <form action="{{ url('/kategori-tugas/update/' . $typeTask->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="nama">Nama Kategori</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama', $typeTask->nama) }}" required>
                    @error('nama')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary mt-3">Update</button>
                <a href="{{ url('/kategori-tugas') }}" class="btn btn-secondary mt-3">Kembali</a>
            </form>
        </div>
    </div>
@endsection
