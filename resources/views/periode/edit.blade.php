@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Edit Periode</h3>
        </div>
        <div class="card-body">
            <form action="{{ url('/periode/update/' . $periode->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="nama">Nama Periode</label>
                    <input type="text" name="nama" id="nama" value="{{ old('nama', $periode->nama) }}" 
                        class="form-control @error('nama') is-invalid @enderror">
                    @error('nama')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="tipe">Tipe Periode</label>
                    <select name="tipe" id="tipe" class="form-control @error('tipe') is-invalid @enderror">
                        <option value="ganjil" {{ old('tipe', $periode->tipe) == 'ganjil' ? 'selected' : '' }}>Ganjil</option>
                        <option value="genap" {{ old('tipe', $periode->tipe) == 'genap' ? 'selected' : '' }}>Genap</option>
                    </select>
                    @error('tipe')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="semester">Semester</label>
                    <input type="number" name="semester" id="semester" 
                        value="{{ old('semester', $periode->semester) }}" 
                        class="form-control @error('semester') is-invalid @enderror">
                    @error('semester')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="{{ url('/periode') }}" class="btn btn-default">Batal</a>
            </form>
        </div>
    </div>
@endsection
