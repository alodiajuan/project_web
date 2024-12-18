@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Tambah Periode</h3>
        </div>
        <div class="card-body">
            <form action="{{ url('/periode/store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="nama">Nama Periode</label>
                    <input type="text" name="nama" id="nama" value=""
                        class="form-control @error('nama') is-invalid @enderror">
                    @error('nama')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="tipe">Tipe Periode</label>
                    <select name="tipe" id="tipe" class="form-control @error('tipe') is-invalid @enderror">
                        <option value="" selected disabled>Pilih Tipe Periode</option>
                        <option value="ganjil">Ganjil</option>
                        <option value="genap">Genap</option>
                    </select>
                    @error('tipe')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="semester">Semester</label>
                    <input type="number" name="semester" id="semester" value=""
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
